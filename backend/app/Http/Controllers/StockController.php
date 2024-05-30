<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Repositories\StockRepository;
use App\Repositories\TransactionRepository;
use App\Service\FinMindService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class StockController extends Controller
{
    protected $finMindService;
    protected $stockRepository;
    protected $transactionRepository;

    public function __construct(FinMindService $finMindService, StockRepository $stockRepository, TransactionRepository $transactionRepository)
    {
        parent::__construct();
        
        $this->finMindService = $finMindService;
        $this->stockRepository = $stockRepository;
        $this->transactionRepository = $transactionRepository;
    }

    public function index(): Response
    {
        $stocks = $this->stockRepository->find();

        return $this->createApiResponse($stocks);
    }

    public function getInfoByDateRange(Stock $stock, Request $request): Response
    {
        $prices = $this->finMindService->getStockPriceByDateRange(
            $stock->code, 
            $request->input('start_date'), 
            $request->input('end_date')
        );

        return $this->createApiResponse($prices);
    }

    public function getTaiexIndex(): Response
    {
        $stock = $this->stockRepository->findByCode('TAIEX');

        $prices = $this->finMindService->getStockPriceByDateRange(
            $stock->code, 
            Carbon::now()->format('Y-m-d')
        );

        if (!$prices) {
            return $this->createApiResponse();
        }

        return $this->createApiResponse($prices[0]);
    }

    public function getTpexIndex(): Response
    {
        $stock = $this->stockRepository->findByCode('TPEx');

        $prices = $this->finMindService->getStockPriceByDateRange(
            $stock->code, 
            Carbon::now()->format('Y-m-d')
        );

        if (!$prices) {
            return $this->createApiResponse();
        }

        return $this->createApiResponse($prices[0]);
    }

    public function getHighestProfit(): Response
    {
        $stocks = $this->transactionRepository->getHoldingsByUserId(auth()->user()->id);

        $highestProfit = null;
        $highestProfitStock = null;
        foreach ($stocks as $stock) {
            $stock['profit'] = $stock['stock_current_price'] * $stock['quantity'] - $stock['total'];

            if (!$highestProfit || $stock['profit'] > $highestProfit) {
                $highestProfit = $stock['profit'];
                $highestProfitStock = $stock;
            }
        }

        return $this->createApiResponse($highestProfitStock);
    }

    public function getHighestROI(): Response
    {
        $stocks = $this->transactionRepository->getHoldingsByUserId(auth()->user()->id);

        $highestROI = null;
        $highestROIStock = null;
        foreach ($stocks as $stock) {
            $profit = $stock['stock_current_price'] * $stock['quantity'] - $stock['total'];
            $stock['ROI'] = number_format($profit / $stock['total'], 2);

            if (!$highestROI || $stock['ROI'] > $highestROI) {
                $highestROI = $stock['ROI'];
                $highestROIStock = $stock;
            }
        }

        return $this->createApiResponse($highestROIStock);
    }
}
