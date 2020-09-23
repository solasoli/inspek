<?php

namespace App\Repository;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

class BaseModel extends Model
{
    public $timestamps = false;
    use SoftDeletes;

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->created_at = date('Y-m-d H:i:s');
            $model->created_by = Auth::id();

            $model->updated_at = date('Y-m-d H:i:s');
            $model->updated_by = Auth::id();

            $model->deleted_by = 0;
            return $model;
        });

        self::created(function ($model) {
        });

        self::updating(function ($model) {

            $model->updated_at = date('Y-m-d H:i:s');
            $model->updated_by = Auth::id();
            return $model;
        });

        self::updated(function ($model) {
        });

        self::deleting(function ($model) {
        });

        self::deleted(function ($model) {
            $model->deleted_at = date('Y-m-d H:i:s');
            $model->deleted_by = Auth::id();
            $model->is_deleted = 1;
            $model->save();
        });
    }
}
