<?php

namespace App\Http\Controllers\website;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    //






    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), 
        
            [
                'name' => 'required',
                'password' => 'required|min:6',
                'confirm_password'=>'required_with:password|same:password|min:6',
                'email' => 'required|email|unique:users'
            ]
        );

        if ($validator->fails())
{
    return ['success' => false, 'message' => $validator->messages()];
}

$id = User::create([
    'name' => $request->name,
    'email' => $request->email,
    'mobile' => null, 
    'password' => bcrypt($request->password),
])->id;
$user=User::find($id);
$user->assignRole('end_user');

auth()->login($user);
return ['success' => true, 'message' => 'registration complete'];


    }
}
