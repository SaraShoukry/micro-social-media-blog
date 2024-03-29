<?php

namespace App\Http\Requests;

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
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|max:12|regex:/^(?=.*[A-Z])(?=.*[!@#$&*])(?=.*[0-9]).*$/',//regex must contain at least one character , one special character , one number
            'c_password' => 'required|same:password|min:6|max:12',
            'profile_picture'     =>  'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }
}
