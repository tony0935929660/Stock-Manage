<?php

namespace App\Repositories;

use App\Models\Transaction;
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

    public function getHoldingCategoriesByUserId(string $userId): Collection
    {
        return $this->model
            ->selectRaw('stocks.industry_category, SUM(CASE WHEN is_buy = 1 THEN total ELSE -total END) AS total')
            ->leftJoin('stocks', 'stocks.id', '=', 'transactions.stock_id')
            ->where('user_id', $userId)
            ->groupBy('stocks.industry_category')
            ->having('total', '>', '0')
            ->get();
    }

    public function getHoldingsByUserId(string $userId): Collection
    {
        return $this->model
            ->selectRaw('stock_id,
                stocks.name as stock_name,
                stocks.code as stock_code,
                stocks.industry_category as stock_industry,
                stocks.current_price as stock_current_price,
                SUM(CASE WHEN is_buy = 1 THEN total ELSE -total END) as total, 
                SUM(CASE WHEN is_buy = 1 THEN quantity ELSE -quantity END) AS quantity')
            ->leftJoin('stocks', 'stocks.id', '=', 'transactions.stock_id')
            ->where('user_id', $userId)
            ->groupBy('stock_id')
            ->having('total', '>', '0')
            ->get();
    }
}
