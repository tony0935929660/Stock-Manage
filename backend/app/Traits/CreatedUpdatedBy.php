<?php

namespace App\Traits;
use App\Models\User;

trait CreatedUpdatedBy
{
    public static function bootCreatedUpdatedBy()
    {
        // updating created_by and updated_by when model is created
        static::creating(function ($model) {
            if ($model instanceof User) {
                return;
            }
            if (!$model->isDirty('created_by') && auth()->check()) {
                $model->created_by = auth()->user()->id;
            }
            if (!$model->isDirty('updated_by') && auth()->check()) {
                $model->updated_by = auth()->user()->id;
            }
        });

        // updating updated_by when model is updated
        static::updating(function ($model) {
            if (!$model->isDirty('updated_by') && auth()->check()) {
                $model->updated_by = auth()->user()->id;
            }
        });
    }
}