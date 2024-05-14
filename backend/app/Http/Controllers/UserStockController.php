<?php

namespace App\Http\Controllers;

use App\Models\UserStock;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class UserStockController extends Controller
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
        $userStock = UserStock::create($params);

        return $this->createApiResponse(['id' => $userStock->id]);
    }

    public function historyList(): Response
    {
        $userStocks = UserStock::where('user_id', auth()->user()->id)->get();
        return $this->createApiResponse($userStocks);
    }

    public function holdingList(): Response
    {
        $userStocks = UserStock::selectRaw('stock_id, sum(total_cost) as total_cost, sum(amount) as amount')
            ->groupBy('stock_id')
            ->get();
        return $this->createApiResponse($userStocks);
    }
}
