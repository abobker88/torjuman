<?php

namespace App\Http\Requests\UserRequist;

use App\Http\Requests\PARANTAPI;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class Update extends PARANTAPI
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
       
            // 'mobile' => ['required', Rule::unique('users')->ignore(auth()->id()),],
          
        ];
    }
}
