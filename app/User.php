<?php

namespace App;

use App\Models\Auth\Verify;
use App\Models\User\Avatar;
use App\Models\User\SpecificUser;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $fillable = [
        'email', 'password',
    ];

    protected $hidden = [
        'password'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     * SPECIFIC DATA USER
     */
    public function s(){
        return $this->hasOne(SpecificUser::class);
    }

    public function avatar()
    {
        return $this->hasOne(Avatar::class);
    }

    public function verify()
    {
        return $this->hasOne(Verify::class);
    }
}
