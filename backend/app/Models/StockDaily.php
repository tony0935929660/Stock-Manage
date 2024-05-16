<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockDaily extends Model
{
    use HasFactory;

    protected $fillable = [
        "date",
        "stock_id",
        "trading_volume",
        "trading_money",
        "open",
        "max",
        "min",
        "close",
        "spread",
        "trading_turnover"
    ];
}
