<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockDaily extends Model
{
    use HasFactory;

    protected $fillable = [
        "stock_id",
        "date",
        "trading_volume",
        "trading_money",
        "open",
        "max",
        "min",
        "close",
        "spread",
        "trading_turnover"
    ];

    public function stock()
    {
        return $this->belongsTo(Stock::class);
    }
}
