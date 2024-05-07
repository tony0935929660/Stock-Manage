<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class StockController extends Controller
{
    public function index(): Response
    {
        $stocks = Stock::get();

        return $this->createApiResponse($stocks);
    }
}
