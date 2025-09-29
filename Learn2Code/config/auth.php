<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Defaults
    |--------------------------------------------------------------------------
    */
    'defaults' => [
        // ตั้งค่าให้ guard หลักเป็น member (แก้ได้จาก .env ผ่าน AUTH_GUARD)
        'guard' => env('AUTH_GUARD', 'member'),
        'passwords' => env('AUTH_PASSWORD_BROKER', 'members'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Authentication Guards
    |--------------------------------------------------------------------------
    | Supported: "session"
    */
    'guards' => [
        'web' => [
            'driver'   => 'session',
            'provider' => 'users',
        ],

        'login' => [
            'driver'   => 'session',
            'provider' => 'loginusers',
        ],

        'admin' => [
            'driver'   => 'session',
            // เดิมเป็น 'admins' → ปรับให้ชี้ไปที่ 'members' เพื่อใช้บัญชีเดียวกันกับ Member
            'provider' => 'members',
        ],

        'member' => [
            'driver'   => 'session',
            'provider' => 'members',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Providers
    |--------------------------------------------------------------------------
    | Supported: "eloquent", "database"
    */
    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model'  => App\Models\User::class,
        ],

        'loginusers' => [
            'driver' => 'eloquent',
            'model'  => App\Models\LoginModel::class,
        ],

        'admins' => [
            'driver' => 'eloquent',
            'model'  => App\Models\AdminModel::class,
        ],

        'members' => [
            'driver' => 'eloquent',
            'model'  => App\Models\Member::class,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Resetting Passwords
    |--------------------------------------------------------------------------
    */
    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table'    => env('AUTH_PASSWORD_RESET_TOKEN_TABLE', 'password_reset_tokens'),
            'expire'   => 60,
            'throttle' => 60,
        ],

        // reset password สำหรับสมาชิก (ใช้ broker "members")
        'members' => [
            'provider' => 'members',
            'table'    => env('AUTH_PASSWORD_RESET_TOKEN_TABLE', 'password_reset_tokens'),
            'expire'   => 60,
            'throttle' => 60,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Password Confirmation Timeout
    |--------------------------------------------------------------------------
    */
    'password_timeout' => env('AUTH_PASSWORD_TIMEOUT', 10800),

];
