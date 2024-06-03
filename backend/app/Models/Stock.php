<?php

namespace App\Models;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory, CreatedUpdatedBy;

    protected $fillable = [
        'code',
        'name',
        'industry_category',
        'type',
        'current_price',
        'created_by',
        'updated_by'
    ];

    static $nonStockCategory = ['大盤', 'Index'];
}
