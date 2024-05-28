<?php

namespace App\Service;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

class FinMindService
{
    protected $url = 'https://api.finmindtrade.com/api/v4/data';

    public function getStockSummary(): array
    {
        return $this->callApi('TaiwanStockInfo');
    }

    public function getStockPriceByDateRange(string $stockCode, string $startDate, ?string $endDate = null): array
    {
        return $this->callApi('TaiwanStockPrice', $stockCode, $startDate, $endDate);
    }

    protected function callApi(string $dataset, ?string $stockCode = null, ?string $startDate = null, ?string $endDate = null): array
    {
        $token = env('FINMIND_TOKEN');

        $query = [
            'dataset' => $dataset,
            'data_id' => $stockCode,
            'start_date' => $startDate,
            'end_date' => $endDate
        ];

        $response = Http::withHeaders([
            'Authorization' => "Bearer $token"
        ])
        ->get($this->url, $query);

        if ($response->successful()) {
            $jsonResponse = $response->json();
            return $jsonResponse['data'];
        } else {
            throw new \Exception('FinMind API failed.');
        }
    }
}