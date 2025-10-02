<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryModel extends Model
{
    protected $table = 'tbl_categories';
    protected $primaryKey = 'category_id';

    public $incrementing = true;
    public $timestamps = false; 
    protected $keyType = 'int';

    protected $fillable = [
        'name',
        'icon',
        'created_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function courses()
    {
        return $this->hasMany(CoursesModel::class, 'category_id', 'category_id');
    }
}