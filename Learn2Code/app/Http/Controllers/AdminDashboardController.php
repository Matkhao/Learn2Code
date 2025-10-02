<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index(Request $request)
    {
        return view('admin.dashboard', $this->payload());
    }

    public function refresh(Request $request)
    {
        $adminRoleId = (int) (DB::table('tbl_roles')->where('code', 'admin')->value('role_id') ?? 1);

        // KPI metrics
        $metrics = [
            'admins'           => (int) DB::table('tbl_users')->where('role_id', $adminRoleId)->count(),
            'members'          => (int) DB::table('tbl_users')->where('role_id', '!=', $adminRoleId)->count(),
            'users_total'      => (int) DB::table('tbl_users')->count(),
            'categories_total' => (int) DB::table('tbl_categories')->count(),
            'courses_total'    => (int) DB::table('tbl_courses')->count(),
            'reviews_total'    => (int) DB::table('tbl_reviews')->count(),
            'favorites_total'  => (int) DB::table('tbl_favorites')->count(),
            'free_courses'     => (int) DB::table('tbl_courses')
                ->where(fn($q) => $q->whereNull('price')->orWhere('price', 0))
                ->count(),
            'paid_courses'     => (int) DB::table('tbl_courses')->where('price', '>', 0)->count(),
            'avg_price'        => (float) (DB::table('tbl_courses')->avg('price') ?? 0),
            'avg_rating'       => (float) (DB::table('tbl_reviews')->avg('rating') ?? 0),
        ];

        // Chart Courses per category
        $catRows = DB::table('tbl_categories as c')
            ->leftJoin('tbl_courses as co', 'co.category_id', '=', 'c.category_id')
            ->select('c.name', DB::raw('COUNT(co.course_id) as total'))
            ->groupBy('c.category_id', 'c.name')
            ->orderBy('c.name', 'asc')
            ->get();

        $categoryChart = [
            'labels' => $catRows->pluck('name'),
            'data'   => $catRows->pluck('total')->map(fn($v) => (int)$v),
        ];

        $from = Carbon::now()->subMonths(11)->startOfMonth();
        $to   = Carbon::now()->endOfMonth();

        $monthRows = DB::table('tbl_courses')
            ->select(DB::raw("DATE_FORMAT(created_at, '%Y-%m') as ym"), DB::raw('COUNT(*) as total'))
            ->whereBetween('created_at', [$from, $to])
            ->groupBy('ym')
            ->orderBy('ym', 'asc')
            ->get()
            ->keyBy('ym');

        $labels = [];
        $data   = [];
        $cur    = $from->copy();
        while ($cur <= $to) {
            $ym      = $cur->format('Y-m');
            $labels[] = $ym;
            $data[]   = (int) ($monthRows[$ym]->total ?? 0);
            $cur->addMonth();
        }

        $monthChart = compact('labels', 'data');

        return response()->json([
            'metrics'       => $metrics,
            'categoryChart' => $categoryChart,
            'monthChart'    => $monthChart,
        ]);
    }

    private function payload(): array
    {
        $adminRoleId = (int) (DB::table('tbl_roles')->where('code', 'admin')->value('role_id') ?? 1);

        $metrics = [
            'admins'          => DB::table('tbl_users')->where('role_id', $adminRoleId)->count(),
            'members'         => DB::table('tbl_users')->where('role_id', '!=', $adminRoleId)->count(),
            'users_total'     => DB::table('tbl_users')->count(),
            'categories_total' => DB::table('tbl_categories')->count(),
            'courses_total'   => DB::table('tbl_courses')->count(),
            'reviews_total'   => DB::table('tbl_reviews')->count(),
            'favorites_total' => DB::table('tbl_favorites')->count(),
            'free_courses'    => DB::table('tbl_courses')->whereNull('price')->orWhere('price', 0)->count(),
            'paid_courses'    => DB::table('tbl_courses')->where('price', '>', 0)->count(),
            'avg_price'       => round((float) (DB::table('tbl_courses')->avg('price') ?? 0), 2),
            'avg_rating'      => round((float) (DB::table('tbl_reviews')->avg('rating') ?? 0), 2),
        ];

        $perCategory = DB::table('tbl_categories as c')
            ->leftJoin('tbl_courses as co', 'co.category_id', '=', 'c.category_id')
            ->select('c.name', DB::raw('COUNT(co.course_id) as total'))
            ->groupBy('c.category_id', 'c.name')
            ->orderBy('c.name')
            ->get();
        $categoryChart = [
            'labels' => $perCategory->pluck('name'),
            'data'   => $perCategory->pluck('total')->map(fn($v) => (int) $v),
        ];

        $start = now()->subMonths(11)->startOfMonth();
        $end   = now()->endOfMonth();
        $monthRows = DB::table('tbl_courses')
            ->selectRaw("DATE_FORMAT(created_at, '%Y-%m') as ym, COUNT(*) as total")
            ->whereBetween('created_at', [$start, $end])
            ->groupBy('ym')
            ->orderBy('ym')
            ->get()
            ->keyBy('ym');

        $labels = [];
        $data   = [];
        $cursor = $start->copy();
        while ($cursor <= $end) {
            $ym = $cursor->format('Y-m');
            $labels[] = $cursor->format('M y');
            $data[]   = (int) ($monthRows[$ym]->total ?? 0);
            $cursor->addMonth();
        }
        $monthChart = compact('labels', 'data');

        $latestCourses = DB::table('tbl_courses')
            ->select('course_id', 'title', DB::raw('cover_img as cover_url'), 'price', 'avg_rating', 'language', 'created_at')
            ->orderByDesc('created_at')
            ->limit(10)
            ->get();

        return compact('metrics', 'categoryChart', 'monthChart', 'latestCourses');
    }
}
