<?php

namespace App\Repositories;

use App\Models\Stock;
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
}
