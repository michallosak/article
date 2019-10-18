<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Auth\AuthRepository;
use App\Http\Requests\Auth\ActivateAccountRequest;

class ActivateController extends Controller
{
    public function activateAccount(ActivateAccountRequest $request, AuthRepository $authRepo)
    {
        $verify = $authRepo->activateAccount($request);
        return response()->json([
            'error' => $verify['error'],
            'msg' => $verify['msg']
        ], $verify['status']);
    }
}
