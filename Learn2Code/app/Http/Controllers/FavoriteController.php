<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\CoursesModel;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function toggle(Request $request, CoursesModel $course)
    {
        $userId = $request->user()->getKey();
        $cond = ['user_id' => $userId, 'course_id' => $course->course_id];

        $exists = Favorite::where($cond)->exists();
        if ($exists) {
            Favorite::where($cond)->delete();
            return response()->json(['favorited' => false]);
        }
        Favorite::create($cond + ['created_at' => now()]);
        return response()->json(['favorited' => true]);
    }
}
