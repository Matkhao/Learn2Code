<?php
// app/Http/Controllers/MemberAuthController.php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class MemberAuthController extends Controller
{
    /** =========================================================
     * Helpers: Normalization + Throttle
     * =======================================================*/

    private function normalizeEmail(?string $email): string
    {
        return strtolower(trim((string) $email));
    }

    private function throttleKey(Request $request): string
    {
        return 'member-login:' . Str::lower((string) $request->input('email')) . '|' . $request->ip();
    }

    private function ensureIsNotRateLimited(Request $request, int $max = 5, int $decaySeconds = 60): void
    {
        $key = $this->throttleKey($request);

        if (RateLimiter::tooManyAttempts($key, $max)) {
            $seconds = RateLimiter::availableIn($key);

            throw ValidationException::withMessages([
                'email' => "พยายามเข้าสู่ระบบหลายครั้งเกินไป กรุณาลองใหม่ใน {$seconds} วินาที",
            ]);
        }

        // จอง 1 สิทธิ์ไว้ก่อน (จะล้างเมื่อสำเร็จ)
        RateLimiter::hit($key, $decaySeconds);
    }

    private function clearRateLimit(Request $request): void
    {
        RateLimiter::clear($this->throttleKey($request));
    }

    private function isAdminUser($u): bool
    {
        if (!$u) return false;

        // รองรับหลายรูปแบบของ is_admin (bool/int/string)
        $fromFlag = property_exists($u, 'is_admin')
            ? ((is_bool($u->is_admin) && $u->is_admin)
                || (is_numeric($u->is_admin) && (int)$u->is_admin === 1)
                || (is_string($u->is_admin) && in_array(strtolower($u->is_admin), ['1', 'true', 'yes', 'y'], true)))
            : false;

        return $fromFlag
            || (int)($u->role_id ?? 0) === 1
            || (method_exists($u, 'isAdmin') && (bool)$u->isAdmin())
            || (int)($u->user_id ?? 0) === 1; // สำรองกรณีไอดี 1
    }

    /** =========================================================
     * Views
     * =======================================================*/

    public function showLogin(Request $request)
    {
        // ถ้าล็อกอินแล้ว และไม่มีแฟลก login_success → ส่งกลับหน้าที่เหมาะสม
        if (Auth::guard('member')->check() && !$request->session()->has('login_success')) {
            $u = Auth::guard('member')->user();
            $isAdmin = $this->isAdminUser($u);

            if ($isAdmin && !Auth::guard('admin')->check()) {
                Auth::guard('admin')->login($u);
            }

            return $isAdmin
                ? redirect()->intended(route('admin.courses.index'))
                : redirect()->intended('/');
        }

        return view('auth.member_login');
    }

    public function showRegister()
    {
        return view('auth.member_register');
    }

    /** =========================================================
     * Register
     * =======================================================*/

    public function register(Request $request)
    {
        // normalize email ก่อน validate
        if ($request->has('email')) {
            $request->merge(['email' => $this->normalizeEmail($request->email)]);
        }

        // ใช้ชื่อตารางจริงจากโมเดล (tbl_users)
        $usersTable = (new Member)->getTable();

        $request->validate([
            'name'     => ['required', 'string', 'min:3', 'max:100', 'regex:/^[\pL\pM\pN\s\.\-_]+$/u'],
            'email'    => ['required', 'email', 'max:190', "unique:{$usersTable},email"],
            'password' => ['required', 'string', 'min:8', 'max:100', 'confirmed'],
        ], [
            'name.required'         => 'กรุณากรอกชื่อ',
            'name.min'              => 'ชื่อต้องมีอย่างน้อย 3 ตัวอักษร',
            'email.required'        => 'กรุณากรอกอีเมล',
            'email.email'           => 'รูปแบบอีเมลไม่ถูกต้อง',
            'email.unique'          => 'อีเมลนี้ถูกใช้แล้ว',
            'password.required'     => 'กรุณากรอกรหัสผ่าน',
            'password.min'          => 'รหัสผ่านต้องมีอย่างน้อย 8 ตัวอักษร',
            'password.confirmed'    => 'รหัสผ่านยืนยันไม่ตรงกัน',
        ]);

        // เตรียม payload ให้ทนทานต่อคอลัมน์ที่มี/ไม่มี
        $payload = [
            'name'     => strip_tags($request->name),
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ];

        // แนวทาง: ใส่เฉพาะคอลัมน์ที่มีอยู่จริงในตาราง users
        if (Schema::hasColumn($usersTable, 'role_id')) {
            $payload['role_id'] = 2; // student
        }

        if (Schema::hasColumn($usersTable, 'avatar_url')) {
            $payload['avatar_url'] = null;
        }

        if (Schema::hasColumn($usersTable, 'is_active')) {
            $payload['is_active'] = 1;
        }

        try {
            $member = Member::create($payload);
        } catch (\Throwable $e) {
            // กันเคส race condition/DB error อื่น ๆ
            return back()->withErrors([
                'email' => 'ไม่สามารถสมัครสมาชิกได้ กรุณาลองใหม่อีกครั้ง',
            ])->withInput();
        }

        // ล็อกอินเข้า guard member ทันทีหลังสมัคร
        Auth::guard('member')->login($member);
        $request->session()->regenerate();

        // กลับหน้า login เพื่อให้แสดง Success Modal หนึ่งครั้ง
        return redirect()->route('member.login')->with('login_success', true);
        // หากต้องการส่งเข้าหน้าหลักทันที: return redirect()->intended('/');
    }

    /** =========================================================
     * Login
     * =======================================================*/

    public function login(Request $request)
    {
        // normalize email
        if ($request->has('email')) {
            $request->merge(['email' => $this->normalizeEmail($request->email)]);
        }

        $request->validate([
            'email'    => ['required', 'email', 'max:190'],
            'password' => ['required', 'string', 'min:8'],
        ], [
            'email.required'    => 'กรุณากรอกอีเมล',
            'email.email'       => 'รูปแบบอีเมลไม่ถูกต้อง',
            'password.required' => 'กรุณากรอกรหัสผ่าน',
            'password.min'      => 'รหัสผ่านต้องมีอย่างน้อย 8 ตัวอักษร',
        ]);

        // Rate limit: 5 ครั้ง/นาที ต่อ (อีเมล+IP)
        $this->ensureIsNotRateLimited($request, max: 5, decaySeconds: 60);

        // ดึงผู้ใช้ก่อนเพื่อแจ้งสาเหตุแบบปลอดภัย
        $email     = $request->email;
        $member    = Member::where('email', $email)->first();
        $remember  = $request->boolean('remember');

        if ($member) {
            $table       = $member->getTable();
            $hasActive   = Schema::hasColumn($table, 'is_active');
            $hasVerified = Schema::hasColumn($table, 'email_verified_at');
            $hasDeleted  = Schema::hasColumn($table, 'deleted_at');

            if ($hasDeleted && !is_null($member->deleted_at)) {
                return back()->withErrors([
                    'email' => 'บัญชีนี้ถูกปิดการใช้งาน',
                ])->onlyInput('email');
            }

            if ($hasActive && (string) $member->is_active === '0') {
                return back()->withErrors([
                    'email' => 'บัญชีถูกระงับการใช้งาน กรุณาติดต่อผู้ดูแล',
                ])->onlyInput('email');
            }

            if ($hasVerified && is_null($member->email_verified_at)) {
                return back()->withErrors([
                    'email' => 'กรุณายืนยันอีเมลก่อนเข้าสู่ระบบ',
                ])->onlyInput('email');
            }
        }

        // ดำเนินการล็อกอิน
        if ($member && Auth::guard('member')->attempt(['email' => $email, 'password' => $request->password], $remember)) {
            $request->session()->regenerate();
            $this->clearRateLimit($request); // สำเร็จแล้วล้างเคาน์เตอร์

            // [ADMIN] เลือกหน้า redirect ตามสิทธิ์
            $u = Auth::guard('member')->user();
            $isAdmin = $this->isAdminUser($u); // 🔧 เปลี่ยนมาใช้ helper เดียวกับ showLogin()

            // เพิ่ม: ถ้าเป็นแอดมิน ให้ล็อกอินเข้า guard:admin ด้วย แล้วค่อยเข้า /admin/courses
            if ($isAdmin) {
                if (!Auth::guard('admin')->check()) {
                    Auth::guard('admin')->login($u);
                }
                return redirect()->intended(route('admin.courses.index'));  // แอดมิน → หน้าจัดการคอร์ส
            }

            return redirect()->intended('/');                   // สมาชิกทั่วไป → หน้าเดิม/หน้าแรก
        }

        // ล้มเหลว: คงเคาน์เตอร์ไว้ (หมดอายุเอง)
        return back()->withErrors([
            'email' => 'อีเมลหรือรหัสผ่านไม่ถูกต้อง',
        ])->onlyInput('email');
    }

    /** =========================================================
     * Logout
     * =======================================================*/

    public function logout(Request $request)
    {
        // ออกจากทั้งสอง guard (ถ้ามี)
        Auth::guard('admin')->logout();
        Auth::guard('member')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // เด้งกลับหน้าหลัก หรือจะส่งไป login ก็ได้
        return redirect('/');
    }
}
