<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Models\StockDaily;
use App\Service\FinMindService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class StockController extends Controller
{
    /**
     * @var FinMindService
     */
    protected $finMindService;

    public function __construct(FinMindService $finMindService)
    {
        $this->finMindService = $finMindService;
    }

    public function index(): Response
    {
        $stocks = Stock::get();

        return $this->createApiResponse($stocks);
    }

    public function getRecentInfo(Stock $stock, Request $request): Response
    {
        $info = StockDaily::where('stock_id', $stock->id)
        ->whereDate('date', $request->input('date'))
        ->first();

        if (!$info) {
            $prices = $this->finMindService->getStockPriceByDateRange($stock->code, $request->input('date'), $request->input('date'));

            $data = $prices[0];

            $info = StockDaily::with('stock')->create([
                'stock_id' => $stock->id,
                'date' => $request->input('date'),
                "trading_volume" => $data['Trading_Volume'],
                "trading_money" => $data['Trading_money'],
                "open" => $data['open'],
                "max" => $data['max'],
                "min" => $data['min'],
                "close" => $data['close'],
                "spread" => $data['spread'],
                "trading_turnover" => $data['Trading_turnover']
            ]);
        }

        $info = StockDaily::where('stock_id', $stock->id)
        ->orderBy('date', 'desc')
        ->limit(5)
        ->get();

        return $this->createApiResponse($info);
    }
}
