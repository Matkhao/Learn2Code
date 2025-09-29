<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\CoursesModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReviewController extends Controller
{
    public function store(Request $request, CoursesModel $course)
    {
        $data = $request->validate([
            'rating'  => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:2000',
        ]);

        DB::transaction(function () use ($request, $course, $data) {
            Review::updateOrCreate(
                ['user_id' => $request->user()->getKey(), 'course_id' => $course->course_id],
                ['rating' => $data['rating'], 'comment' => $data['comment'] ?? null, 'created_at' => now()]
            );
            $avg = Review::where('course_id', $course->course_id)->avg('rating') ?? 0;
            $course->avg_rating = round($avg, 1);
            $course->save();
        });

        return back()->with('success', 'บันทึกรีวิวแล้ว');
    }

    public function destroy(Request $request, Review $review)
    {
        abort_unless($review->user_id === $request->user()->getKey(), 403);
        $courseId = $review->course_id;
        $review->delete();

        $avg = Review::where('course_id', $courseId)->avg('rating') ?? 0;
        CoursesModel::where('course_id', $courseId)->update(['avg_rating' => round($avg, 1)]);

        return back()->with('success', 'ลบรีวิวแล้ว');
    }
}
