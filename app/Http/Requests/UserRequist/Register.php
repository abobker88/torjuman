<?php

namespace App\Http\Requests\UserRequist;

use App\Http\Requests\PARANTAPI;
use Illuminate\Foundation\Http\FormRequest;


class Register extends PARANTAPI
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
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'mobile' => 'required|regex:/^((?:[+?0?0?966]+)(?:\s?\d{2})(?:\s?\d{7}))$/|min:9|unique:users,mobile',
            'fcm_token' => 'required',
            'lang'=>'required',
            'mobile_type'=>'required'
        ];
    }
}
