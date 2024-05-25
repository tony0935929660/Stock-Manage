<?php

namespace App\Repositories;

use App\Models\Transaction;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class TransactionRepository
{
    protected $model;

    public function __construct(Transaction $model)
    {
        $this->model = $model;
    }

    public function findStockInventoryByStockId(string $stockId)
    {
        return $this->model
            ->where('stock_id', $stockId)
            ->where('is_buy', true)
            ->sum('remaining');
    }

    public function findBuyTransactionsByStockId(string $stockId): Collection
    {
        return $this->model
            ->where('stock_id', $stockId)
            ->where('is_buy', true)
            ->where('remaining', '>', 0)
            ->orderBy('date', 'asc')
            ->get();
    }
}
