<?php

use App\Models\User\Avatar;
use App\Models\User\SpecificUser;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'email' => config('app.admin_email'),
            'password' => Hash::make(config('app.admin_pass')),
            'role' => 'R_ADMIN',
            'activated' => 1
        ]);
        SpecificUser::create([
            'user_id' => $user->id,
            'name' => config('app.admin_name'),
            'last_name' => config('app.admin_last_name'),
            'username' => config('app.admin_username'),
            'phone' => config('app.admin_phone'),
            'city' => config('app.admin_city'),
            'sex' => config('app.admin_sex'),
            'birthday' => config('app.admin_birthday')
        ]);
        if (config('app.admin_sex') != 1){
            $avatar = asset('images/avatars/default/man.png');
        }else{
            $avatar = asset('images/avatars/default/woman.png');
        }
        Avatar::create([
            'user_id' => $user->id,
            'src' => $avatar
        ]);
    }
}
