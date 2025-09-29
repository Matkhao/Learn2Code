<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAdminMember
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // ตรวจสอบ authentication ทั้ง member และ admin guard
        $memberUser = auth('member')->user();
        $adminUser = auth('admin')->user();

        // ถ้าล็อกอินด้วย member guard และเป็น admin
        if ($memberUser && method_exists($memberUser, 'isAdmin') && $memberUser->isAdmin()) {
            return $next($request);
        }

        // ถ้าล็อกอินด้วย admin guard
        if ($adminUser) {
            return $next($request);
        }

        // ถ้าไม่มีสิทธิ์
        return redirect()->route('member.login')->with('error', 'คุณไม่มีสิทธิ์เข้าถึงหน้านี้');
    }
}
