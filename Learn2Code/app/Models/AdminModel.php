<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Schema;

class AdminModel extends Member
{
    protected static function booted(): void
    {
        static::addGlobalScope('only_admins', function (Builder $builder) {
            $tbl = $builder->getModel()->getTable(); // 'tbl_users'

            $builder->where(function ($w) use ($tbl) {
                $w->where($tbl . '.role_id', 1);

                if (Schema::hasColumn($tbl, 'is_admin')) {
                    $w->orWhere($tbl . '.is_admin', 1);
                }
            });
        });

        static::saving(function (self $model) {
            $tbl = $model->getTable();
            if (empty($model->role_id)) {
                $model->role_id = 1;
            }
            if (Schema::hasColumn($tbl, 'is_admin')) {
                $model->is_admin = 1;
            }
        });
    }
}