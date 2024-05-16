<?php

namespace App\Console\Commands;

use App\Models\Stock;
use Illuminate\Console\Command;
use App\Service\FinMindService;

class GetStockSummary extends Command
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
    protected $signature = 'stock:summary';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get stock summary.';

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
        $data = $this->finMindService->getStockSummary();
        
        foreach ($data as $datum) {
            $stock = Stock::findByCode($datum['stock_id']);
            if ($stock) {
                continue;
            }

            Stock::create([
                'code' => $datum['stock_id'],
                'name' => $datum['stock_name'],
                'industry_category' => $datum['industry_category'],
                'type' => $datum['type'],
                'created_by' => 'System-GetStockSummary',
                'updated_by' => 'system-GetStockSummary'
            ]);
        }

        return 0;
    }
}
