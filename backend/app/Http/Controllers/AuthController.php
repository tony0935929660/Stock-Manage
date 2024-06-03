<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Service\StockService;
use App\Service\SystemPreferenceService;

class AuthController extends Controller
{
    protected $stockService;
    
    protected $systemPreferenceService;

    public function __construct(StockService $stockService, SystemPreferenceService $systemPreferenceService)
    {
        parent::__construct();

        $this->stockService = $stockService;

        $this->systemPreferenceService = $systemPreferenceService;
    }

    public function login(Request $request): Response
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6'
        ]);
        
        if ($validator->fails()) {
            return $this->createValidatorErrorApiResponse($validator);
        }

        if (!$token = Auth::attempt($validator->validated())) {
            return $this->createUnauthorizeApiResponse();
        }

        return $this->createNewToken($token);
    }

    public function register(Request $request): Response
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|confirmed|min:6',
        ]);

        if ($validator->fails()) {
            return $this->createValidatorErrorApiResponse($validator);
        }

        $user = User::create(array_merge(
            $validator->validated(),
            ['password' => bcrypt($request->password)]
        ));

        $this->systemPreferenceService->createDefaultSystemPreferences($user->id);

        return $this->createApiResponse([
            'message' => 'User successfully registered',
            'user' => $user
        ]);
    }

    public function logout(): Response
    {
        Auth::logout();
        return $this->createApiResponse(['message' => 'User successfully signed out']);
    }

    public function refresh(): Response
    {
        return $this->createNewToken(Auth::refresh());
    }

    public function userProfile(): Response
    {
        return $this->createApiResponse(Auth::user());
    }

    protected function createNewToken($token): Response
    {
        return $this->createApiResponse([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60,
            'user' => Auth::user()
        ]);
    }
}
