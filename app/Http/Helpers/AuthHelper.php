<?php

namespace App\Http\Helpers;

use App\Http\Repositories\Mail\SendMailRepository;
use App\Models\Auth\Verify;
use App\User;
use Illuminate\Support\Facades\Auth;

class AuthHelper
{

    private $sendMailRepo;

    public function __construct(SendMailRepository $sendMailRepo)
    {
        $this->sendMailRepo = $sendMailRepo;
    }

    public function sendVerifyMail($user_id, $data)
    {
        $_key = $this->generateKey();
        Verify::create([
            'user_id' => $user_id,
            '_key' => $_key
        ]);
        $this->sendMailRepo->verifyEmail($data);
    }

    public function verifyMail($keyUSER)
    {
        $key = $this->getKeyDB();

        $verify = [
            'msg' => 'Activated account!',
            'error' => false,
            'status' => 200
        ];

        if ($keyUSER != $key) {
            $verify['msg'] = 'Invalid key!';
            $verify['error'] = true;
            $verify['status'] = 403;
            return $verify;
        }
        $this->activateAccount();
        return $verify;
    }

    // Private functions

    private function generateKey()
    {
        $key = substr(md5(time() . rand(1, 1000) . date('Y-m-d')), 15, 15);
        return $key;
    }


    private function activateAccount()
    {
        User::where('id', Auth::id())
            ->update([
                'activated' => true
            ]);
        Verify::where('user_id', Auth::id())
            ->delete();
        $this->sendMailRepo->activatedEmail();
    }


    private function getKeyDB()
    {
        $key = Verify::where('user_id', Auth::id())->value('_key');

        return $key;
    }

}
