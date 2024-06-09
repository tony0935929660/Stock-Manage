<?php

namespace App\Console\Commands;

use App\Repositories\StockRepository;
use App\Service\FinMindService;
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
     * @var StockRepository
     */
    protected $stockRepository;

    /**
     * @var FinMindService
     */
    protected $finMindService;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(StockRepository $stockRepository, FinMindService $finMindService)
    {
        parent::__construct();

        $this->stockRepository = $stockRepository;
        $this->finMindService = $finMindService;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $stocks = $this->stockRepository->getAllHeldStock();

        foreach ($stocks as $stock) {
            $stockInfo = $this->finMindService->getNewestStockInfo($stock->code);

            $stock->update([
                'current_price' => $stockInfo['close'],
                'updated_by' => 'System-UpdateStockCurrentPrice'
            ]);
        }

        return 0;
    }
}
