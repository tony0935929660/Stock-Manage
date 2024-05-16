<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Service\FinMindService;

class TestFunction extends Command
{
    /**
     * @var FinMindService
     */
    protected $finMindService;

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
        $data = $this->finMindService->getStockPriceByDate('2330', '2024-05-14');
        
        dump($data);

        return 0;
    }
}
