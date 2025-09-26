<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\TestController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CoursesController;

//home page
Route::get('/', [HomeController::class, 'index']);

//product home page
Route::get('/detail/{id}',  [HomeController::class, 'detail']);
Route::get('/search/', [HomeController::class, 'searchProduct']);

//admin crud
Route::get('/admin', [AdminController::class, 'index']);
Route::get('/admin/adding',  [AdminController::class, 'adding']);
Route::post('/admin',  [AdminController::class, 'create']);
Route::get('/admin/{id}',  [AdminController::class, 'edit']);
Route::put('/admin/{id}',  [AdminController::class, 'update']);
Route::delete('/admin/remove/{id}',  [AdminController::class, 'remove']);
Route::get('/admin/reset/{id}',  [AdminController::class, 'reset']);
Route::put('/admin/reset/{id}',  [AdminController::class, 'resetPassword']);

//test crud
Route::get('/test', [TestController::class, 'index']);
Route::get('/test/adding',  [TestController::class, 'adding']);
Route::post('/test',  [TestController::class, 'create']);
Route::get('/test/{id}',  [TestController::class, 'edit']);
Route::put('/test/{id}',  [TestController::class, 'update']);
Route::delete('/test/remove/{id}',  [TestController::class, 'remove']);

//product crud
Route::get('/product', [ProductController::class, 'index']);
Route::get('/product/adding',  [ProductController::class, 'adding']);
Route::post('/product',  [ProductController::class, 'create']);
Route::get('/product/{id}',  [ProductController::class, 'edit']);
Route::put('/product/{id}',  [ProductController::class, 'update']);
Route::delete('/product/remove/{id}',  [ProductController::class, 'remove']);

//student crud
Route::get('/student', [StudentController::class, 'index']);
Route::get('/student/adding',  [StudentController::class, 'adding']);
Route::post('/student',  [StudentController::class, 'create']);
Route::get('/student/{id}',  [StudentController::class, 'edit']);
Route::put('/student/{id}',  [StudentController::class, 'update']);
Route::delete('/student/remove/{id}',  [StudentController::class, 'remove']);

// Courses CRUD
Route::get('/courses',              [CoursesController::class, 'index'])->name('courses.index');
Route::get('/courses/adding',       [CoursesController::class, 'adding'])->name('courses.adding'); // หน้าเพิ่ม
Route::post('/courses',             [CoursesController::class, 'create'])->name('courses.store');
Route::get('/courses/{id}/edit',    [CoursesController::class, 'edit'])->name('courses.edit')->whereNumber('id');
Route::put('/courses/{id}',         [CoursesController::class, 'update'])->name('courses.update')->whereNumber('id');
Route::delete('/courses/{id}',      [CoursesController::class, 'remove'])->name('courses.destroy')->whereNumber('id');

// Frontend
Route::get('/', [CoursesController::class, 'frontend'])->name('frontend');

// Article page
Route::get('/blog', function () {
        return view('blog.index');
});
