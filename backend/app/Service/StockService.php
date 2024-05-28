<?php

namespace App\Service;

use App\Repositories\TransactionRepository;
use Carbon\Carbon;

class StockService
{
    protected $transactionRepository;

    protected $finMindService;

    public function __construct(TransactionRepository $transactionRepository, FinMindService $finMindService)
    {
        $this->transactionRepository = $transactionRepository;

        $this->finMindService = $finMindService;
    }

    public function updateCurrentPriceByUser(string $userId): void
    {
        $stocks = $this->transactionRepository->getHoldingsByUserId($userId);

        foreach ($stocks as $stock) {
            $prices = $this->finMindService->getStockPriceByDateRange($stock['stock_code'], Carbon::now()->format('Y-m-d'));

            if (!count($prices)) {
                continue;
            }

            $stock->update([
                'current_price' => $prices[0]['close']
            ]);
        }
    }
}