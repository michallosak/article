<?php

namespace App\Http\Repositories\Auth;

use App\Http\Helpers\AuthHelper;
use App\Models\User\Avatar;
use App\Models\User\SpecificUser;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthRepository
{

    private $auth_helper;

    public function __construct(AuthHelper $auth_helper)
    {
        $this->auth_helper = $auth_helper;
    }

    public function registerUser($data)
    {
        DB::transaction(function () use ($data) {
            $user = User::create([
                'email' => $data->email,
                'password' => Hash::make($data->password)
            ]);
            $userID = $user->id;
            $this->saveSpecificData($data, $userID);
            $this->saveAvatar($data->sex, $userID);
            $this->auth_helper->sendVerifyMail($userID, $data);
            return true;
        });
    }

    private function saveSpecificData($data, $userID)
    {
        SpecificUser::create([
            'user_id' => $userID,
            'name' => $data->name,
            'last_name' => $data->last_name,
            'username' => $data->username,
            'phone' => $data->phone,
            'sex' => $data->sex,
            'birthday' => $data->birthday
        ]);
    }

    private function saveAvatar($sex, $userID)
    {
        $avatar_woman = asset('images/avatars/default/woman.png');
        $avatar_man = asset('images/avatars/default/man.png');

        /*
         |--------------------------------------------------------------
         | $sex = 1 = WOMAN
         | $sex = 2 = MAN
         |--------------------------------------------------------------
         */

        if ($sex != 1) {
            $avatar = $avatar_man;
        } else {
            $avatar = $avatar_woman;
        }
        Avatar::create([
            'user_id' => $userID,
            'src' => $avatar
        ]);
    }

    public function loginUser($data)
    {
        $email = $data->email;
        $pass = $data->password;
        $LOGIN = ['error' => false, 'msg' => '', 'token' => '', 'token_type' => 'Bearer', 'status' => 200];

        $credentials = ['email' => $email, 'password' => $pass];


        if (!Auth::attempt($credentials)) {
            $LOGIN['error'] = true;
            $LOGIN['msg'] = 'Unauthorized';
            $LOGIN['status'] = 403;

            return $LOGIN;
        }

        $user = Auth::user();
        $LOGIN['token'] = $user->createToken(config('app.name'))->accessToken;

        return $LOGIN;

    }

    public function activateAccount($data)
    {
        $verify = $this->auth_helper->verifyMail($data->key);

        return $verify;
    }

}
