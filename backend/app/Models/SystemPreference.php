<?php

namespace App\Models;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemPreference extends Model
{
    use HasFactory, CreatedUpdatedBy;

    protected $fillable = [
        'user_id',
        'name',
        'value',
        'is_frontend_cached',
        'options',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'options' => 'array',
    ];
}
