<?php

namespace App\Http\Requests\UserRequist;

use App\Http\Requests\PARANTAPI;
use Illuminate\Foundation\Http\FormRequest;
use InfyOm\Generator\Request\APIRequest;

class Login extends PARANTAPI
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
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:6',
            'lang'=>'required'
        ];
    }
}
