<?php

namespace App\Repositories;

use App\Models\Stock;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class StockRepository
{
    protected $model;

    public function __construct(Stock $model)
    {
        $this->model = $model;
    }

    public function find()
    {
        return $this->model
            ->whereNotIn('industry_category', Stock::$nonStockCategory)
            ->get();
    }

    public function findByCode(string $code): ?Stock
    {
        return $this->model
            ->where('code', $code)->first();
    }

    public function getAllHeldStock(): Collection
    {
        return $this->model
            ->selectRaw('stocks.*, 
                SUM(CASE WHEN transactions.is_buy = 1 THEN transactions.total ELSE -transactions.total END) as total')
            ->leftJoin('transactions', 'stocks.id', '=', 'transactions.stock_id')
            ->groupBy('stocks.id')
            ->having('total', '>', 0)
            ->get();
    }

    public function getIndex(): Collection
    {
        return $this->model
            ->whereIn('industry_category', Stock::$nonStockCategory)
            ->get();
    }
}
