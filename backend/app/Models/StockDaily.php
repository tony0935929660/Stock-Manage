<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockDaily extends Model
{
    use HasFactory;

    protected $fillable = [
        'stock_id',
        'date',
        'volume',
        'amount',
        'open',
        'close',
        'high',
        'low',
        'change',
        'total_transaction'
    ];
}
