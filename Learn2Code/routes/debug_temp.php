<?php

// 🚨 EMERGENCY DEBUG ROUTES - เพิ่มเข้า routes/web.php

// Bypass middleware เพื่อเรียก CoursesController โดยตรง
Route::get('/__bypass-admin-courses', function() {
    try {
        // สร้าง instance ของ controller
        $controller = new \App\Http\Controllers\CoursesController();

        // สร้าง request object
        $request = \Illuminate\Http\Request::create('/admin/courses', 'GET');

        // เรียก method โดยตรง
        $response = $controller->index($request);

        return $response;

    } catch (\Exception $e) {
        dd([
            'BYPASS_ERROR' => $e->getMessage(),
            'FILE' => $e->getFile(),
            'LINE' => $e->getLine(),
            'TRACE' => $e->getTraceAsString()
        ]);
    }
});

// ทดสอบ view courses.list โดยตรง
Route::get('/__test-view', function() {
    try {
        $courses = collect([
            (object)['course_id' => 1, 'title' => 'Test Course', 'category_id' => 1]
        ]);

        // สร้าง paginator จำลอง
        $courses = new \Illuminate\Pagination\LengthAwarePaginator(
            $courses,
            1,
            5,
            1,
            ['path' => request()->url()]
        );

        return view('courses.list', compact('courses'));

    } catch (\Exception $e) {
        dd([
            'VIEW_ERROR' => $e->getMessage(),
            'FILE' => $e->getFile(),
            'LINE' => $e->getLine(),
            'TRACE' => $e->getTraceAsString()
        ]);
    }
});