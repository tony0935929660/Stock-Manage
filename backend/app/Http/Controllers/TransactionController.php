<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    public function buy(Request $request): Response
    {
        $params = $request->all();
        $validator = Validator::make($params, [
            'stock_id',
            'buy_date',
            'buy_price',
            'amount'
        ]);

        if ($validator->fails()) {
            return $this->createValidatorErrorApiResponse($validator);
        }

        // TODO auto convert datetime to date
        $params['buy_date'] = date('Y-m-d', strtotime($params['buy_date']));


        // TODO calculate function can define in model
        $discount = 0.28;
        $fee = $params['buy_price'] * $params['amount'] * 0.1425 * $discount;
        $total = $params['buy_price'] * $params['amount'] + $fee;

        $params = array_merge($params, [
            "user_id" => auth()->user()->id,
            "buy_fee_discount" => $discount,
            "total_cost" => $total
        ]);
        $transaction = Transaction::create($params);

        return $this->createApiResponse(['id' => $transaction->id]);
    }

    public function historyList(): Response
    {
        $transaction = Transaction::where('user_id', auth()->user()->id)->get();
        return $this->createApiResponse($transaction);
    }

    public function holdingList(): Response
    {
        $transaction = Transaction::selectRaw('stock_id, sum(total) as total, sum(quantity) as quantity')
            ->groupBy('stock_id')
            ->get();
        return $this->createApiResponse($transaction);
    }
}
