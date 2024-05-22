<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Models\StockDaily;
use App\Repositories\StockRepository;
use App\Service\FinMindService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class StockController extends Controller
{
    protected $finMindService;
    protected $stockRepository;

    public function __construct(FinMindService $finMindService, StockRepository $stockRepository)
    {
        $this->finMindService = $finMindService;
        $this->stockRepository = $stockRepository;
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
}
