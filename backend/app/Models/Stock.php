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
        'industry_category',
        'type',
        'created_by',
        'updated_by'
    ];

    static $nonStockCategory = ['大盤', 'Index'];

    public function stockDailies()
    {
        return $this->hasMany(StockDaily::class);
    }
}
