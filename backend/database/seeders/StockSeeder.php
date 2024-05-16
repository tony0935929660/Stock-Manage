<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class StockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('stocks')->insert([
            'code' => '2330',
            'name' => 'TSMC',
            'industry' => 'wafer',
            'price' => '800',
            'created_by' => 'system-StockSeeder',
            'updated_by' => 'system-StockSeeder'
        ]);
    }
}
