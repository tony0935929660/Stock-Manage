<?php

namespace App\Repositories;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Collection;

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

    public function getHoldingCategories(string $userId): Collection
    {
        return $this->model
            ->selectRaw('stocks.industry_category, SUM(CASE WHEN is_buy = 1 THEN total ELSE -total END) AS total')
            ->leftJoin('stocks', 'stocks.id', '=', 'transactions.stock_id')
            ->where('user_id', $userId)
            ->groupBy('stocks.industry_category')
            ->having('total', '>', '0')
            ->get();
    }

    public function getHoldings(string $userId): Collection
    {
        return Transaction::selectRaw('stock_id, 
                SUM(CASE WHEN is_buy = 1 THEN total ELSE -total END) as total, 
                SUM(CASE WHEN is_buy = 1 THEN quantity ELSE -quantity END) AS quantity')
            ->with('stock')
            ->where('user_id', $userId)
            ->groupBy('stock_id')
            ->get();
    }
}
