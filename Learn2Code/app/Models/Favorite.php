<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    protected $table = 'tbl_favorites';
    public $timestamps = false;
    protected $fillable = ['user_id', 'course_id', 'created_at'];
}
