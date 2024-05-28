<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StockController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TransactionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/stock', [StockController::class, 'index']);
Route::get('/stock/{stock}/info', [StockController::class, 'getInfoByDateRange']);
Route::get('/stock/highest-profit', [StockController::class, 'getHighestProfit']);
Route::get('/stock/highest-roi', [StockController::class, 'getHighestROI']);

Route::get('/index/taiex', [StockController::class, 'getTaiexIndex']);
Route::get('/index/tpex', [StockController::class, 'getTpexIndex']);

Route::post('/transaction/buy', [TransactionController::class, 'buy']);
Route::post('/transaction/sell', [TransactionController::class, 'sell']);
Route::get('/transaction/history', [TransactionController::class, 'historyList']);
Route::get('/transaction/holding', [TransactionController::class, 'holdingList']);

Route::get('/chart/pie/holding-category', [TransactionController::class, 'holdingCategoryPieChartData']);

Route::group([
    'prefix' => 'auth'
], function ($router) {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/profile', [AuthController::class, 'userProfile']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::post('/logout', [AuthController::class, 'logout']);
});
