<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'name' => 'required|min:3|max:80',
            'last_name' => 'required|min:3|max:80',
            'username' => 'min:5|max:35|unique:specific_users',
            'phone' => 'min:9|max:15',
            'city' => 'min:3|max:80',
            'sex' => 'required|integer|min:1|max:2',
            'birthday' => 'required'
        ];
    }
}
