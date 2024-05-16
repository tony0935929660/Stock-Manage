<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Models\StockDaily;
use App\Models\UserStock;
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

    // public function getTodayInfo(Stock $stock): Response
    // {
    //     $todayInfo = UserStock::where('stock_id', $stock->id)
    //     ->whereDate('date', Carbon::today())
    //     ->get();

    //     if (!$todayInfo) {
    //         $data = $this->finMindService->getStockPriceByDate($stock->id, Carbon::today());
    //         $todayInfo = StockDaily::create([
    //             'stock_id' => $stock->id,
    //             'date' => $data['date'],
    //             'vol'
    //         ]);
    //     }

    //     return $this->createApiResponse($todayInfo);
    // }
}
