<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

trait Userstamps
{
    public static function bootUserstamps()
    {
        static::creating(function (Model $model) {
            if (Auth::check()) {
                $model->created_by = Auth::id();
                $model->updated_by = Auth::id();
            }
        });

        static::updating(function (Model $model) {
            if (Auth::check()) {
                $model->updated_by = Auth::id();
            }
        });

        static::deleting(function (Model $model) {
            if (Auth::check() && method_exists($model, 'getDeletedByColumn')) {
                $model->{$model->getDeletedByColumn()} = Auth::id();
                $model->save();
            }
        });

        if (static::usingSoftDeletes()) {
            static::restoring(function (Model $model) {
                if (Auth::check() && method_exists($model, 'getDeletedByColumn')) {
                    $model->{$model->getDeletedByColumn()} = null;
                }
            });
        }
    }

    protected static function usingSoftDeletes()
    {
        return in_array('Illuminate\Database\Eloquent\SoftDeletes', class_uses_recursive(static::class));
    }

    public function creator()
    {
        return $this->belongsTo(config('auth.providers.users.model', 'App\Models\User'), 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(config('auth.providers.users.model', 'App\Models\User'), 'updated_by');
    }

    public function deleter()
    {
        return $this->belongsTo(config('auth.providers.users.model', 'App\Models\User'), 'deleted_by');
    }

    public function getDeletedByColumn()
    {
        return defined('static::DELETED_BY') ? static::DELETED_BY : 'deleted_by';
    }
}