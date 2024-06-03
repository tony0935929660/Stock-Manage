<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Models\Transaction;
use App\Models\TransactionMapping;
use App\Repositories\TransactionRepository;
use App\Service\StockService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    protected $transactionRepository;
    protected $stockService;

    public function __construct(TransactionRepository $transactionRepository, StockService $stockService)
    {
        parent::__construct();
        
        $this->transactionRepository = $transactionRepository;
        $this->stockService = $stockService;
    }
    
    public function buy(Request $request): Response
    {
        try {
            $params = $request->all();
            $validator = Validator::make($params, [
                'stock_id',
                'date',
                'price',
                'quantity'
            ]);

            if ($validator->fails()) {
                return $this->createValidatorErrorApiResponse($validator);
            }

            $fee = $this->stockService->calculateFee($params['price'], $params['quantity']);

            $params = array_merge($params, [
                "user_id" => auth()->user()->id,
                "is_buy" => true,
                "total" => $params['price'] * $params['quantity'] + $fee,
                "remaining" => $params['quantity']
            ]);
            $transaction = Transaction::create($params);
            
            $this->stockService->updateCurrentPriceByStock(Stock::find($transaction['stock_id']));

            return $this->createApiResponse(['id' => $transaction->id]);
        } catch (\Exception $exception) {
            return $this->createHttpExceptionResponse(Response::HTTP_BAD_REQUEST, $exception->getMessage());
        }
    }

    public function sell(Request $request): Response
    {
        try {
            $params = $request->all();
            $validator = Validator::make($params, [
                'stock_id',
                'date',
                'price',
                'quantity'
            ]);

            if ($validator->fails()) {
                return $this->createValidatorErrorApiResponse($validator);
            }

            $remainingSellingQuantity = intval($params['quantity']);
            $remaining = $this->transactionRepository->findStockInventoryByStockId($params['stock_id']);

            if ($remaining < $remainingSellingQuantity) {
                return $this->createHttpExceptionResponse(Response::HTTP_BAD_REQUEST, 'Please check your stock inventory.');
            }

            DB::beginTransaction();

            $fee = $this->stockService->calculateFee($params['price'], $params['quantity']);
            $tax = $this->stockService->calculateTax($params['price'], $params['quantity']);
            $total = $params['price'] * $params['quantity'] + $fee + $tax;

            $params = array_merge($params, [
                "user_id" => auth()->user()->id,
                "is_buy" => false,
                "total" => $total
            ]);
            $sellTransaction = Transaction::create($params);

            $transactions = $this->transactionRepository->findBuyTransactionsByStockId($params['stock_id']);
            foreach ($transactions as $transaction) {
                if ($transaction->remaining > $remainingSellingQuantity) {
                    TransactionMapping::create([
                        'buy_transaction_id' => $transaction->id,
                        'sell_transaction_id' => $sellTransaction->id,
                        'quantity' => $remainingSellingQuantity
                    ]);
                    $transaction->update(['remaining' => $transaction->remaining - $remainingSellingQuantity]);
                    break;
                } else {
                    TransactionMapping::create([
                        'buy_transaction_id' => $transaction->id,
                        'sell_transaction_id' => $sellTransaction->id,
                        'quantity' => $transaction->remaining
                    ]);
                    $transaction->update(['remaining' => 0]);
                    $remainingSellingQuantity -= $transaction->remaining;
                }
            }
            
            $this->stockService->updateCurrentPriceByStock(Stock::find($transaction['stock_id']));

            DB::commit();

            return $this->createApiResponse(['id' => $transaction->id]);
        } catch (\Exception $exception) {
            return $this->createHttpExceptionResponse(Response::HTTP_BAD_REQUEST, $exception->getMessage());
        }
    }

    public function historyList(): Response
    {
        $transaction = Transaction::with('stock')
            ->where('user_id', auth()->user()->id)
            ->orderBy('date', 'desc')
            ->get();
        return $this->createApiResponse($transaction);
    }

    public function holdingList(): Response
    {
        $holdings = $this->transactionRepository->getHoldingsByUserId(auth()->user()->id);

        return $this->createApiResponse($holdings);
    }

    public function holdingCategoryPieChartData(): Response
    {
        $categories = $this->transactionRepository->getHoldingCategoriesByUserId(auth()->user()->id);

        return $this->createApiResponse($categories);
    }
}
