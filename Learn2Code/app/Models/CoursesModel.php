<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CoursesModel extends Model
{
    protected $table = 'tbl_courses';
    protected $primaryKey = 'course_id';

    public $incrementing = true;   // PK เป็น AUTO_INCREMENT
    public $timestamps  = false;
    protected $keyType = 'int';

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
        'created_at',
    ];

    // แปลงชนิดข้อมูลอัตโนมัติ
    protected $casts = [
        'price'      => 'decimal:2',
        'avg_rating' => 'decimal:2',
        'created_at' => 'datetime',
    ];

    /* -------------------------------------------
     | Relations
     |-------------------------------------------*/
    // คอร์สหนึ่งรายการสังกัดหมวดเดียว
    public function category()
    {
        return $this->belongsTo(CategoryModel::class, 'category_id', 'category_id');
    }

    /* -------------------------------------------
     | Mutators (กันค่าผิดช่วง)
     |-------------------------------------------*/
    // บังคับราคาให้อยู่ในช่วงและปัดทศนิยม 2 ตำแหน่ง
    public function setPriceAttribute($value): void
    {
        if ($value === null || $value === '') {
            $this->attributes['price'] = null;
            return;
        }
        $n = is_numeric($value) ? (float) $value : 0.0;
        $n = max(0.0, min(99999999.99, $n));
        $this->attributes['price'] = number_format($n, 2, '.', '');
    }

    // บังคับเรตติ้งให้อยู่ 0.5 และปัดครึ่งดาว
    public function setAvgRatingAttribute($value): void
    {
        if ($value === null || $value === '') {
            $this->attributes['avg_rating'] = null;
            return;
        }
        $n = is_numeric($value) ? (float) $value : 0.0;
        $n = max(0.0, min(5.0, $n));
        $n = round($n * 2) / 2;
        $this->attributes['avg_rating'] = number_format($n, 2, '.', '');
    }

    public function favoritedBy()
    {
        return $this->belongsToMany(Member::class, 'course_favorites', 'course_id', 'member_id')
            ->withTimestamps();
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'course_id');
    }
    public function isFavoritedBy(?\App\Models\User $user): bool
    {
        return $user ? $this->favoritedBy()->whereKey($user->getKey())->exists() : false;
    }
    public function getRouteKeyName()
    {
        return 'course_id';
    } // เพื่อใช้ {course} ผูกด้วย course_id

}
