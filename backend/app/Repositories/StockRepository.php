<?php

namespace App\Repositories;

use App\Models\Stock;
use Illuminate\Support\Facades\DB;

class StockRepository
{
    public function find()
    {
        return DB::table('stocks')
            ->whereNotIn('industry_category', Stock::$nonStockCategory)
            ->get();
    }

    public function findByCode(string $code): ?Stock
    {
        return Stock::where('code', $code)->first();
    }
}
