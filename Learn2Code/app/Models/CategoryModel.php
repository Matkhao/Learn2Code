<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryModel extends Model
{
    protected $table = 'tbl_categories';
    protected $primaryKey = 'category_id';

    public $incrementing = true;
    public $timestamps = false; // ตาราง tbl_categories ไม่มี updated_at column
    protected $keyType = 'int';

    protected $fillable = [
        'name',
        'icon',
        'created_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    /**
     * ความสัมพันธ์กับ CoursesModel
     * หมวดหมู่หนึ่งมีหลายคอร์ส
     */
    public function courses()
    {
        return $this->hasMany(CoursesModel::class, 'category_id', 'category_id');
    }
}
