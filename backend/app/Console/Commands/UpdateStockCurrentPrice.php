<?php

namespace App\Console\Commands;

use App\Models\Stock;
use App\Service\FinMindService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class UpdateStockCurrentPrice extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stock:price';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Stock Current Price EveryDay';
    
    /**
     * @var FinMindService
     */
    protected $finMindService;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(FinMindService $finMindService)
    {
        parent::__construct();

        $this->finMindService = $finMindService;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $stocks = Stock::get();

        foreach ($stocks as $stock) {
            $prices = $this->finMindService->getStockPriceByDateRange($stock->code, Carbon::now()->format('Y-m-d'));

            if (!count($prices)) {
                continue;
            }

            $stock->update([
                'current_price' => $prices[0]['close']
            ]);
        }

        return 0;
    }
}
