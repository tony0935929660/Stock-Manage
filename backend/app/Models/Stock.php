<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'industry_category',
        'price',
        'type',
        'created_by',
        'updated_by'
    ];
}
