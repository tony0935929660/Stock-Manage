<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserStock extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'stock_id',
        'amount',
        'buy_date',
        'buy_price',
        'buy_fee_discount',
        'total_cost',
        'sell_date',
        'sell_price',
        'sell_fee_discount',
        'tax',
        'total_profit',
        'created_by',
        'updated_by'
    ];
}
