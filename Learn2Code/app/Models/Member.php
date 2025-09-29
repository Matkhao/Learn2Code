<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Member extends Authenticatable
{
    use Notifiable;

    protected $table = 'tbl_users';
    protected $primaryKey = 'user_id';
    public $timestamps = true;

    protected $fillable = ['role_id', 'name', 'email', 'password', 'avatar_url'];
    protected $hidden = ['password', 'remember_token'];

    public function favorites()
    {
        return $this->belongsToMany(CoursesModel::class, 'course_favorites', 'member_id', 'course_id')
            ->withTimestamps();
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'member_id');
    }

    public function isAdmin(): bool
    {
        return (int)$this->user_id === 1 || (int)$this->role_id === 1;
    }
}
