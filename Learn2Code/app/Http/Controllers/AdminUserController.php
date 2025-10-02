<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AdminUserController extends Controller
{
    private function perPage(): int
    {
        return 10;
    }

    private function sortColumns(): array
    {
        return [
            'id'      => 'tbl_users.user_id',
            'name'    => 'tbl_users.name',
            'email'   => 'tbl_users.email',
            'created' => 'tbl_users.created_at',
            'updated' => 'tbl_users.updated_at',
            'role'    => 'r.name',
        ];
    }

    private function parseSort(string $sort): array
    {
        [$k, $d] = array_pad(explode('_', strtolower($sort), 2), 2, 'asc');
        $col = $this->sortColumns()[$k] ?? 'tbl_users.user_id';
        $dir = $d === 'desc' ? 'desc' : 'asc';
        return [$col, $dir];
    }

    private function normalizeEmail(?string $email): string
    {
        return strtolower(trim((string) $email));
    }

    private function str(Request $request, string $key): string
    {
        return (string) $request->string($key)->trim();
    }

    public function index(Request $request)
    {
        $q = trim((string) $request->query('q', ''));
        $sort = (string) $request->query('sort', 'id_asc');
        [$col, $dir] = $this->parseSort($sort);

        $rows = DB::table('tbl_users')
            ->leftJoin('tbl_roles as r', 'r.role_id', '=', 'tbl_users.role_id')
            ->select('tbl_users.*', 'r.name as role_name', 'r.code as role_code')
            ->where(function ($w) {
                $w->where('r.code', 'admin')->orWhere('tbl_users.role_id', 1);
            })
            ->when($q !== '', function ($w) use ($q) {
                $w->where(function ($x) use ($q) {
                    $x->where('tbl_users.name', 'like', "%{$q}%")
                        ->orWhere('tbl_users.email', 'like', "%{$q}%");
                });
            })
            ->orderBy($col, $dir)
            ->paginate($this->perPage())
            ->appends(['q' => $q, 'sort' => $sort]);

        return view('admin.list', [
            'admins' => $rows,
            'q'      => $q,
            'sort'   => $sort,
        ]);
    }

    public function create()
    {
        $roles = DB::table('tbl_roles')
            ->select('role_id', 'name', 'code')
            ->orderBy('name')
            ->get();

        $admin = (object) [
            'user_id'    => null,
            'name'       => '',
            'email'      => '',
            'role_id'    => 1,
            'avatar_url' => '',
            'created_at' => null,
            'updated_at' => null,
        ];

        return view('admin.create', [
            'roles'    => $roles,
            'admin'    => $admin,
            'row'      => $admin,
            'defaults' => [
                'name'       => '',
                'email'      => '',
                'role_id'    => 1,
                'avatar_url' => '',
            ],
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => ['required', 'string', 'min:2', 'max:100'],
            'email'       => ['required', 'email', 'max:190', Rule::unique('tbl_users', 'email')],
            'password'    => ['required', 'string', 'min:8', 'max:255', 'confirmed'],
            'role_id'     => ['required', 'integer', Rule::exists('tbl_roles', 'role_id')],
            'avatar_url'  => ['nullable', 'url', 'max:255'],
        ]);

        try {
            $now = now();

            $id = DB::transaction(function () use ($request, $now) {
                return DB::table('tbl_users')->insertGetId([
                    'name'       => $this->str($request, 'name'),
                    'email'      => $this->normalizeEmail($this->str($request, 'email')),
                    'password'   => Hash::make($this->str($request, 'password')),
                    'role_id'    => (int) $request->input('role_id', 1),
                    'avatar_url' => $request->input('avatar_url'),
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            });

            return redirect('/admin')->with('success', 'เพิ่มผู้ดูแลระบบสำเร็จ (ID: ' . $id . ')');
        } catch (\Throwable $e) {
            Log::error('Create admin failed', ['error' => $e->getMessage()]);
            return back()->withInput()->withErrors(['error' => 'ไม่สามารถเพิ่มข้อมูลได้ โปรดลองอีกครั้ง']);
        }
    }

    public function edit($id)
    {
        $row = DB::table('tbl_users')
            ->leftJoin('tbl_roles as r', 'r.role_id', '=', 'tbl_users.role_id')
            ->select('tbl_users.*', 'r.name as role_name', 'r.code as role_code')
            ->where('tbl_users.user_id', $id)
            ->first();

        abort_if(!$row, 404);

        $roles = DB::table('tbl_roles')
            ->select('role_id', 'name', 'code')
            ->orderBy('name')
            ->get();

        return view('admin.edit', [
            'row'   => $row,
            'admin' => $row,
            'roles' => $roles,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'       => ['required', 'string', 'min:2', 'max:100'],
            'email'      => ['required', 'email', 'max:190', Rule::unique('tbl_users', 'email')->ignore($id, 'user_id')],
            'password'   => ['nullable', 'string', 'min:8', 'max:255', 'confirmed'],
            'role_id'    => ['required', 'integer', Rule::exists('tbl_roles', 'role_id')],
            'avatar_url' => ['nullable', 'url', 'max:255'],
        ]);

        try {
            DB::transaction(function () use ($request, $id) {
                $data = [
                    'name'       => $this->str($request, 'name'),
                    'email'      => $this->normalizeEmail($this->str($request, 'email')),
                    'role_id'    => (int) $request->input('role_id', 1),
                    'avatar_url' => $request->input('avatar_url'),
                    'updated_at' => now(),
                ];

                if ($request->filled('password')) {
                    $data['password'] = Hash::make($this->str($request, 'password'));
                }

                DB::table('tbl_users')->where('user_id', $id)->update($data);
            });

            return redirect('/admin')->with('success', 'อัปเดตข้อมูลผู้ดูแลระบบสำเร็จ');
        } catch (\Throwable $e) {
            Log::error('Update admin failed', ['user_id' => $id, 'error' => $e->getMessage()]);
            return back()->withInput()->withErrors(['error' => 'ไม่สามารถแก้ไขข้อมูลได้ โปรดลองอีกครั้ง']);
        }
    }

    public function destroy($id)
    {
        try {
            DB::table('tbl_users')->where('user_id', $id)->delete();
            return redirect('/admin')->with('success', 'ลบผู้ใช้สำเร็จ');
        } catch (\Throwable $e) {
            Log::error('Delete admin failed', ['user_id' => $id, 'error' => $e->getMessage()]);
            return back()->withErrors(['error' => 'ไม่สามารถลบข้อมูลได้ โปรดลองอีกครั้ง']);
        }
    }

    public function toggleRoleToAdmin($id)
    {
        $u = DB::table('tbl_users')->where('user_id', $id)->first();
        abort_if(!$u, 404);

        try {
            $adminRoleId = (int) (DB::table('tbl_roles')->where('code', 'admin')->value('role_id') ?? 1);

            DB::table('tbl_users')->where('user_id', $id)->update([
                'role_id'    => $adminRoleId,
                'updated_at' => now(),
            ]);

            return redirect('/admin')->with('success', 'อัปเดตสิทธิ์เป็นผู้ดูแลระบบสำเร็จ');
        } catch (\Throwable $e) {
            Log::error('Toggle admin role failed', ['user_id' => $id, 'error' => $e->getMessage()]);
            return back()->withErrors(['error' => 'ไม่สามารถเปลี่ยนสิทธิ์ได้ โปรดลองอีกครั้ง']);
        }
    }

    public function resetPassword(Request $request, $id)
    {
        $request->validate([
            'new_password' => ['required', 'string', 'min:8', 'max:255', 'confirmed'],
        ]);

        try {
            DB::table('tbl_users')->where('user_id', $id)->update([
                'password'   => Hash::make((string) $request->string('new_password')->trim()),
                'updated_at' => now(),
            ]);

            return redirect('/admin')->with('success', 'รีเซ็ตรหัสผ่านสำเร็จ');
        } catch (\Throwable $e) {
            Log::error('Reset password failed', ['user_id' => $id, 'error' => $e->getMessage()]);
            return back()->withErrors(['error' => 'ไม่สามารถรีเซ็ตรหัสผ่านได้ โปรดลองอีกครั้ง']);
        }
    }
}
