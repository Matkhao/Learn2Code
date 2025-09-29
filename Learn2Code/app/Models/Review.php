<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $table = 'tbl_reviews';
    protected $primaryKey = 'review_id';
    public $timestamps = false;
    protected $fillable = ['course_id', 'user_id', 'rating', 'comment', 'created_at'];

    public function course()
    {
        return $this->belongsTo(CoursesModel::class, 'course_id');
    }
    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }
}
