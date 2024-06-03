<?php

namespace App\Console\Commands;

use App\Repositories\StockRepository;
use App\Service\StockService;
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
     * @var StockService
     */
    protected $stockService;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(StockRepository $stockRepository, StockService $stockService)
    {
        parent::__construct();

        $this->stockRepository = $stockRepository;
        $this->stockService = $stockService;
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
            $this->stockService->updateCurrentPriceByStock($stock);
        }

        return 0;
    }
}
