<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'industry',
        'price',
        'created_by',
        'updated_by'
    ];
}
