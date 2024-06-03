<?php

namespace App\Service;

use App\Models\Stock;
use App\Repositories\TransactionRepository;

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
            $stockInfo = $this->finMindService->getNewestStockInfo($stock['stock_code']);

            $stock->update([
                'current_price' => $stockInfo['close']
            ]);
        }
    }

    public function updateCurrentPriceByStock(Stock $stock): void
    {
        $stockInfo = $this->finMindService->getNewestStockInfo($stock->code);

        $stock->update([
            'current_price' => $stockInfo['close']
        ]);
    }
}