<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\CoursesController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\MemberAuthController;
use App\Http\Controllers\ReviewController;

/*
|--------------------------------------------------------------------------
| Public (ไม่ต้องล็อกอิน)
|--------------------------------------------------------------------------
*/

Route::get('/', [CoursesController::class, 'frontend'])->name('frontend'); // หน้าแรกหลัก

// Courses (ผู้ใช้ทั่วไป)
Route::get('/courses/detail/{id}', [CoursesController::class, 'show'])->name('courses.detail')->whereNumber('id');

// บทความ
Route::get('/blog', fn() => view('blog.blog_index'))->name('blog.index');

/*
|--------------------------------------------------------------------------
| Member Authentication (ผู้ใช้ทั่วไป)
|--------------------------------------------------------------------------
*/
Route::get('/member/login', [MemberAuthController::class, 'showLogin'])->name('member.login');

Route::middleware('guest:member')->group(function () {
    Route::get('/member/register',  [MemberAuthController::class, 'showRegister'])->name('member.register');
    Route::post('/member/login',    [MemberAuthController::class, 'login'])->name('member.login.post');
    Route::post('/member/register', [MemberAuthController::class, 'register'])->name('member.register.post');
});

Route::post('/member/logout', [MemberAuthController::class, 'logout'])
    ->middleware('auth:member')->name('member.logout');

Route::get('/login', fn() => redirect()->route('member.login'))->name('login');

/*
|--------------------------------------------------------------------------
| Member Area
|--------------------------------------------------------------------------
| รายการโปรด/รีวิว
*/
Route::middleware('auth:member')->group(function () {
    Route::get('/favorites', [CoursesController::class, 'favorites'])->name('favorites.index');

    Route::post('/courses/{id}/favorite', [CoursesController::class, 'toggleFavorite'])
        ->name('courses.favorite')->whereNumber('id');

    Route::post('/courses/{id}/reviews', [CoursesController::class, 'storeReview'])
        ->name('courses.reviews.store')->whereNumber('id');
});

/*
|--------------------------------------------------------------------------
| Admin Area (ต้องล็อกอิน)
|--------------------------------------------------------------------------
| หลังบ้าน + จัดการคอร์ส + จัดการผู้ดูแลระบบ
*/
Route::prefix('admin')->name('admin.')->group(function () {

    // ===== จัดการคอร์ส =====
    Route::get('/courses', [CoursesController::class, 'index'])->name('courses.index');
    Route::get('/courses/adding', [CoursesController::class, 'adding'])->name('courses.adding');
    Route::post('/courses', [CoursesController::class, 'create'])->name('courses.store');
    Route::get('/courses/{id}/edit', [CoursesController::class, 'edit'])->name('courses.edit')->whereNumber('id');
    Route::put('/courses/{id}', [CoursesController::class, 'update'])->name('courses.update')->whereNumber('id');
    Route::delete('/courses/{id}', [CoursesController::class, 'remove'])->name('courses.destroy')->whereNumber('id');

    Route::resource('users', AdminUserController::class)
        ->parameters(['users' => 'id'])
        ->names('users');

    Route::get('/', fn() => redirect()->route('admin.dashboard.index'))->name('home');

    // ===== Dashboard =====
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])
        ->name('dashboard.index');

    // อัปเดตข้อมูลแบบ realtime
    Route::get('/dashboard/refresh', [AdminDashboardController::class, 'refresh'])
        ->name('dashboard.refresh');
});

/*
|--------------------------------------------------------------------------
| Fallback (404)
|--------------------------------------------------------------------------
*/
Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});

Route::get('/__route-dump', function (\Illuminate\Http\Request $req) {
    $r = $req->route();
    return [
        'request_path' => $req->path(),
        'matched_uri'  => optional($r)->uri(),
        'route_name'   => optional($r)->getName(),
        'action'       => optional($r)->getActionName(),
        'middleware'   => optional($r)->gatherMiddleware(),
        'auth' => [
            'member' => ['ok' => auth('member')->check(), 'id' => auth('member')->id()],
            'admin'  => ['ok' => auth('admin')->check(), 'id' => auth('admin')->id()],
        ],
    ];
});