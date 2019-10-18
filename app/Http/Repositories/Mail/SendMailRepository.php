<?php


namespace App\Http\Repositories\Mail;


use App\Mail\User\ActivatedAccount;
use App\Mail\User\VerifyMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class SendMailRepository
{

    public function verifyEmail($data)
    {
        return Mail::to($data->email)->send(new VerifyMail($data));
    }

    public function activatedEmail()
    {
        return Mail::to(Auth::user()->email)->send(new ActivatedAccount());
    }

}
