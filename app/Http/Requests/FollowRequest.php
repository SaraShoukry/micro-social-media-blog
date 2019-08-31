<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use \Illuminate\Support\Facades\Auth;

class FollowRequest extends FormRequest
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
            'follower_id' => 'required|exists:users,id|not_in:' . Auth::user()->id .
                '|unique:followers,follower_id,' . Auth::user()->id,
        ];
    }


    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'follower_id.not_in' => 'You can\'t follow yourself.',
        ];
    }
}
