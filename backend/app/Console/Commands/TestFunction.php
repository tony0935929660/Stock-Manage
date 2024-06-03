<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Service\FinMindService;
use App\Service\StockService;

class TestFunction extends Command
{
    /**
     * @var StockService
     */
    protected $stockService;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:function';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test function';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(StockService $stockService)
    {
        parent::__construct();

        $this->stockService = $stockService;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $data = $this->stockService->calculateProfit(16006, 169.55, 100, true);
        
        dump($data);

        return 0;
    }
}
