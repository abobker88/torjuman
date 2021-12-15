<?php

namespace App\Http\Requests\UserRequist;
use App\Http\Requests\PARANTAPI;

class ChangePassword extends PARANTAPI
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
            'password' => 'required|min:6',
            'new_password' => 'required_with:password|min:6',
        ];
    }
}
