<?php

namespace App\Http\Controllers\Api\Driver;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\UnauthorizedException;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder;

class AuthController extends Controller
{
    /**
     * Change auth locale preference
     *
     * @api GET api/drivers/auth/me
     * @param Request $request
     * @return Response
     */
    public function me(Request $request)
    {
        $user = $request->user()->load("vehicle");

        return response()->api($user);
    }

    /**
     * Change auth locale preference
     *
     * @api POST api/drivers/auth/login
     * @param Request $request
     * @return Response
     */
    public function login(Request $request)
    {
        $request->validate([
            'phone' => 'required',
            'password' => 'required',
            'device_type' => 'nullable|string|in:1,2',
            'device_token' => 'nullable|string',
        ]);

        $user = Driver::where('phone', $request->phone)->first();

        if (!$user || !\Hash::check($request->password, $user->password)) {
            return response()->error('login_failed', 400);
        } elseif ($user->is_active == 0) {
            return response()->error('account_is_suspended', 400);
        }

        $token = \Str::random(60);
        $user->api_token = $token;
        $user->device_type = $request->device_type;
        $user->device_token = $request->device_token;
        $user->save();

        return response()->api(['api_token' => $user->api_token, 'driver_id' => $user->id, 'step' => $user->step]);
    }

    /**
     * Change auth locale preference
     *
     * @api POST api/drivers/auth/logout
     * @param Request $request
     * @return Response
     */
    public function logout(Request $request)
    {
        $user = $request->user();

        $user->api_token = null;
        $user->device_token = null;
        $user->device_type = null;
        $user->is_available = 0;
        $user->save();

        return response()->api(null, 'Successfully logged out');
    }
}
