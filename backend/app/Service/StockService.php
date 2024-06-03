<?php

namespace App\Service;

use App\Models\Stock;
use App\Repositories\SystemPreferenceRepository;
use App\Repositories\TransactionRepository;

class StockService
{
    protected $transactionRepository;

    protected $systemPreferenceRepository;

    protected $finMindService;

    public function __construct(SystemPreferenceRepository $systemPreferenceRepository, TransactionRepository $transactionRepository, FinMindService $finMindService)
    {
        $this->transactionRepository = $transactionRepository;

        $this->systemPreferenceRepository = $systemPreferenceRepository;

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

    public function calculateFee(int $price, int $quantity): int
    {
        $discount = $this->systemPreferenceRepository->getSystemPreferenceByName(SystemPreferenceService::BROKERAGE_FIRM);
        return ($price * $quantity * 0.001425 * floatval($discount)) > 1 ? intval($price * $quantity * 0.001425 * floatval($discount)) : 1;
    }

    public function calculateTax(int $price, int $quantity, bool $isEtf = false): int
    {
        $proportion = $isEtf ? 0.001 : 0.003;
        return intval($price * $quantity * $proportion);
    }

    public function calculateProfit(int $cost, int $price, int $quantity, bool $isEtf = false): int
    {
        $fee = $this->calculateFee($price, $quantity);
        $tax = $this->calculateTax($price, $quantity, $isEtf);
        return $price * $quantity - $cost - $fee - $tax;
    }
}