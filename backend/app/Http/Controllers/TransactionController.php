<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\TransactionMapping;
use App\Repositories\TransactionRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    protected $transactionRepository;

    public function __construct(TransactionRepository $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;
    }
    
    public function buy(Request $request): Response
    {
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

        // TODO auto convert datetime to date
        $params['date'] = date('Y-m-d', strtotime($params['date']));

        // TODO calculate function can define in model
        $discount = 0.28;
        $fee = $params['price'] * $params['quantity'] * 0.1425 * $discount;
        $total = $params['price'] * $params['quantity'] + $fee;

        $params = array_merge($params, [
            "user_id" => auth()->user()->id,
            "is_buy" => true,
            "fee_discount" => $discount,
            "total" => $total,
            "remaining" => $params['quantity']
        ]);
        $transaction = Transaction::create($params);

        return $this->createApiResponse(['id' => $transaction->id]);
    }

    public function sell(Request $request): Response
    {
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

        // TODO auto convert datetime to date
        $params['date'] = date('Y-m-d', strtotime($params['date']));

        // TODO calculate function can define in model
        $discount = 0.28;
        $fee = $params['price'] * $params['quantity'] * 0.1425 * $discount;
        $tax = $params['price'] * $params['quantity'] * 0.3;
        $total = $params['price'] * $params['quantity'] + $fee + $tax;

        $params = array_merge($params, [
            "user_id" => auth()->user()->id,
            "is_buy" => false,
            "fee_discount" => $discount,
            "tax" => $tax,
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

        DB::commit();

        return $this->createApiResponse(['id' => $transaction->id]);
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
