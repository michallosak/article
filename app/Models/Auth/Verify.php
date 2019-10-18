<?php

namespace App\Models\Auth;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Verify extends Model
{
    protected $fillable = [
        'user_id',
        '_key'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
