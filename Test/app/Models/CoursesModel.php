<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CoursesModel extends Model
{
    protected $table = 'tbl_courses';       // ใช้ตาราง tbl_courses
    protected $primaryKey = 'course_id';    // Primary Key คือ course_id

    protected $fillable = [
        'title',
        'category_id',
        'provider',
        'provider_instructor',
        'level',
        'language',
        'price_type',
        'price',
        'duration_text',
        'description',
        'cover_img',
        'course_url',
        'avg_rating',
        'created_at'
    ];

    public $incrementing = true;  // course_id เป็น auto increment
    public $timestamps = false;
}
