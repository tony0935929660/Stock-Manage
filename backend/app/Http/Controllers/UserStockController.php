<?php

namespace App\Http\Controllers;

use App\Models\UserStock;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class UserStockController extends Controller
{
    public function create(Request $request): Response
    {
        $validator = Validator::make($request->all(), [
            'stock_id',
            'buy_price',
            'amount'
        ]);

        if ($validator->fails()) {
            return $this->createValidatorErrorApiResponse($validator);
        }

        $params = array_merge($request->all(), ['user_id' => auth()->user()->id]);
        $userStock = UserStock::create($params);

        return $this->createApiResponse(['id' => $userStock->id]);
    }
}
