<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CoursesController;
use App\Http\Controllers\MemberAuthController;

/*
|--------------------------------------------------------------------------
| Public (ไม่ต้องล็อกอิน)
|--------------------------------------------------------------------------
*/

Route::get('/', [CoursesController::class, 'frontend'])->name('frontend'); // หน้าแรกหลัก
Route::get('/home', [HomeController::class, 'index'])->name('home.index');  // สำรอง/เดโม

// หน้า product (เดโม)
Route::get('/detail/{id}', [HomeController::class, 'detail'])->name('product.detail')->whereNumber('id');
Route::get('/search', [HomeController::class, 'searchProduct'])->name('product.search');

// Courses (สาธารณะ)
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

// ให้ middleware auth redirect ไปเส้นนี้
Route::get('/login', fn() => redirect()->route('member.login'))->name('login');

/*
|--------------------------------------------------------------------------
| Member Area (ต้องล็อกอินด้วย guard: member)
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
| Admin Area (ต้องล็อกอินด้วย guard: admin)
|--------------------------------------------------------------------------
| หลังบ้าน + จัดการคอร์ส
*/
// 🚨 TEMP: ปิด middleware สำหรับทดสอบ (เปิดคืนภายหลัง)
Route::prefix('admin')->name('admin.')->group(function () {
    // ===== คอร์ส: วางไว้ก่อน! =====
    Route::get('/courses', [CoursesController::class, 'index'])->name('courses.index');
    Route::get('/courses/adding', [CoursesController::class, 'adding'])->name('courses.adding');
    Route::post('/courses', [CoursesController::class, 'create'])->name('courses.store');
    Route::get('/courses/{id}/edit', [CoursesController::class, 'edit'])->name('courses.edit')->whereNumber('id');
    Route::put('/courses/{id}', [CoursesController::class, 'update'])->name('courses.update')->whereNumber('id');
    Route::delete('/courses/{id}', [CoursesController::class, 'remove'])->name('courses.destroy')->whereNumber('id');

    // ===== อื่น ๆ ค่อยตามมา =====
    Route::get('/', [AdminController::class, 'index'])->name('index');
    Route::get('/adding', [AdminController::class, 'adding'])->name('adding');
    Route::post('/', [AdminController::class, 'create'])->name('create');

    // ไดนามิกทั้งหมดบังคับเป็นตัวเลข
    Route::get('/{id}', [AdminController::class, 'edit'])->name('edit')->whereNumber('id');
    Route::put('/{id}', [AdminController::class, 'update'])->name('update')->whereNumber('id');
    Route::delete('/remove/{id}', [AdminController::class, 'remove'])->name('remove')->whereNumber('id');
    Route::get('/reset/{id}', [AdminController::class, 'reset'])->name('reset.get')->whereNumber('id');
    Route::put('/reset/{id}', [AdminController::class, 'resetPassword'])->name('reset.put')->whereNumber('id');

    // ===== เพิ่มเติม (ไม่ทับของเดิม) : ชี้ dashboard ไปที่ /admin/courses =====
    Route::get('/dashboard', fn() => redirect()->route('admin.courses.index'))->name('dashboard');
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



