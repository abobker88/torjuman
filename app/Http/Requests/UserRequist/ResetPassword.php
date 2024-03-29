<?php

namespace App\Http\Requests\UserRequist;
use App\Http\Requests\PARANTAPI;

class ResetPassword extends PARANTAPI
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
            'user_id' => 'required|exists:users,id',
            'password' => 'required|min:6',
        ];
    }
}
