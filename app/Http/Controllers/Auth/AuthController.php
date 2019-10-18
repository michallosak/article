<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Auth\AuthRepository;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;

class AuthController extends Controller
{
    private $authRepo;

    public function __construct(AuthRepository $authRepo)
    {
        $this->authRepo = $authRepo;
    }

    public function register(RegisterRequest $request)
    {
        $this->authRepo->registerUser($request);
        return response()->json([
            'error' => false,
            'msg' => 'Register success!'
        ], 200);
    }

    public function login(LoginRequest $request)
    {
        $login = $this->authRepo->loginUser($request);
        if ($login['error'] === true) {
            return response()->json([
                'error' => $login['error'],
                'msg' => $login['msg']
            ], $login['status']);
        }

        return response()->json([
            'error' => $login['error'],
            'access_token' => $login['token'],
            'token_type' => $login['token_type']
        ], $login['status']);
    }
}
