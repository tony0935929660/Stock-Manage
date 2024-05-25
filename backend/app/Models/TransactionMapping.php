<?php

namespace App\Models;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionMapping extends Model
{
    use HasFactory, CreatedUpdatedBy;

    protected $fillable = [
        'buy_transaction_id',
        'sell_transaction_id',
        'quantity',
        'created_by',
        'updated_by'
    ];
}
