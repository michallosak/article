<?php

namespace App\Models\User;

use App\User;
use Illuminate\Database\Eloquent\Model;

class SpecificUser extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'last_name',
        'sex',
        'birthday'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
