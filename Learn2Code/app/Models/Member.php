<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Member extends Authenticatable
{
    use Notifiable;

    protected $table = 'tbl_users';
    protected $primaryKey = 'user_id';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = true;

    protected $fillable = [
        'role_id',
        'name',
        'email',
        'password',
        'avatar_url',
    ];


    protected $hidden = ['password'];


    protected $casts = [
        'role_id'    => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'password'   => 'hashed',
    ];

    /** ====== Mutators ปรับอีเมลให้เป็นตัวพิมพ์เล็กเสมอ ====== */
    public function setEmailAttribute($value): void
    {
        $this->attributes['email'] = strtolower(trim((string) $value));
    }

    /** ====== Relationships ====== */

    /** บทบาทผู้ใช้ */
    public function role(): BelongsTo
    {
        // tbl_roles: role_id (PK), code, name
        return $this->belongsTo(Role::class, 'role_id', 'role_id');
    }

    /** รายการโปรดของคอร์ส (tbl_favorites) */
    public function favorites(): BelongsToMany
    {
        return $this->belongsToMany(CoursesModel::class, 'tbl_favorites', 'user_id', 'course_id')
            ->withTimestamps();
    }

    /** รีวิวที่ผู้ใช้งานเขียน (tbl_reviews.user_id) */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'user_id', 'user_id');
    }

    /** ====== Scopes ====== */

    /** ดึงเฉพาะแอดมิน */
    public function scopeAdmins($query)
    {
        return $query->where(function ($w) {
            $w->where('role_id', 1)
                ->orWhere('is_admin', 1);
        });
    }

    /** ค้นหาจากชื่อ/อีเมล */
    public function scopeKeyword($query, ?string $kw)
    {
        $kw = trim((string) $kw);
        if ($kw === '') return $query;
        return $query->where(function ($w) use ($kw) {
            $w->where('name', 'like', "%{$kw}%")
                ->orWhere('email', 'like', "%{$kw}%");
        });
    }

    /** เช็คว่าเป็นแอดมินหรือไม่ */
    public function isAdmin(): bool
    {
        if ((int)($this->role_id ?? 0) === 1) return true;
        if (property_exists($this, 'is_admin') && (int)$this->is_admin === 1) return true;

        try {
            $role = $this->relationLoaded('role') ? $this->role : $this->role()->first();
            if ($role && in_array(strtolower((string)$role->code), ['admin', 'administrator'], true)) {
                return true;
            }
        } catch (\Throwable $e) {
        }
        return false;
    }
}
