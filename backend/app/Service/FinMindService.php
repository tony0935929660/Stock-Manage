<?php

namespace App\Service;

use Illuminate\Support\Facades\Http;

class FinMindService
{
    protected $url = 'https://api.finmindtrade.com/api/v4/data';

    public function getStockSummary()
    {
        return $this->callApi('TaiwanStockInfo');
    }

    protected function callApi(string $dataset, ?string $dataId = null, ?string $startDate = null, ?string $endDate = null)
    {
        $token = env('FINMIND_TOKEN');
        $dataset = 'TaiwanStockInfo';

        $query = [
            'dataset' => $dataset,
            'data_id' => $dataId,
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
            return response()->json(['error' => 'Failed to fetch data from API'], $response->status());
        }
    }
}