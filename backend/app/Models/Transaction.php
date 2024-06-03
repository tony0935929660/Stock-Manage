<?php

namespace App\Models;

use App\Models\Stock;
use App\Models\User;
use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory, CreatedUpdatedBy;

    protected $fillable = [
        'user_id',
        'stock_id',
        'is_buy',
        'quantity',
        'date',
        'price',
        'total',
        'remaining',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'date' => 'datetime:Y-m-d',
    ];

    protected $dates = ['date'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function stock()
    {
        return $this->belongsTo(Stock::class);
    }
}
