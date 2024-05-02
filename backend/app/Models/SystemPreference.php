<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemPreference extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'value',
        'is_frontend_cached',
        'created_by',
        'updated_by'
    ];
}
