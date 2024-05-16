<?php

namespace App\Models;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory, CreatedUpdatedBy;

    protected $fillable = [
        'user_id',
        'stock_id',
        'related_transaction_id',
        'type',
        'quantity',
        'date',
        'price',
        'fee_discount',
        'tax',
        'total',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'date' => 'datetime:Y-m-d',
    ];
}
