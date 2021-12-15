<?php

namespace App\Http\Controllers\Api\Driver;

use App\Enums\DriverApproval;
use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\Driver;
use App\Models\Vehicle;
use App\Traits\mobileTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;

class RegisterController extends Controller
{
    //
    use mobileTrait;

     /**
     * check user OTP, and validate it
     *
     * @api POST api/driver/auth/check_phone
     * @param Request $request
     * @return Driver
     */
    public function checkPhone(Request $request)
    {

        $request->validate([
            'phone' => 'required',
        ]);

        $phone = $this->fixNumberCode($request->phone);

        $locales = config('app.locales');

        $user = Driver::firstOrNew([
            'phone' => $phone
        ], [
            'otp' => rand(1000, 9999),
            'is_phone_verified' => 0,
            'is_active' => 1,
            'step' => 0

        ]);

        if (!$user->is_active) {
            return response()->error('user_deactivated');
        }

        if ($user->approval_state == DriverApproval::Rejected) {
            return response()->error('Driver Rejected ');
        }

        if ($user->is_phone_verified == 0) {
            // create otp & send only if its expired
            if (!$user->otp_expiration || now()->gt($user->otp_expiration)) {
                $user->otp = rand(1000, 9999);
                $user->otp_expiration = now()->addMinutes(config('app.otp_expiration', 3));
                //   \Notification::send($user, new LoginOtpNotification($user->otp));
            }
        }

        $user->save();
        $data = [
            'approval_state' => $user->approval_state,
            'is_phone_verified' => $user->is_phone_verified,
            'step' => $user->step,
        ];
        return response()->api($data,'OTP Sent');
    }



       /**
     * check user OTP, and validate it
     *
     * @api POST api/auth/verify_otp
     * @param Request $request
     * @return Driver
     */
    public function verify_otp(Request $request)
    {
       
        $request->validate([
            'phone' => 'required',
            'otp' => 'required|numeric',
        ]);

        $phone = $this->fixNumberCode($request->phone);

        $user = Driver::where('phone', $phone)->first(); 

        if(!$user)
        return response()->error('Driver_not_found',400);

        if ($user->is_phone_verified ) {
            return response()->error('already_verified',400);
        }
          
        // validate otp
        if ($user->otp != $request->otp) {
            return response()->error('invalid_otp');
        }

        // User phone validated
        $user->otp = 0;
        $user->is_phone_verified = 1;
        $user->save();

        $data = [
            'message' => 'phone verified'
        ];

        return response()->api($data);

    }


      /**
     * Resend user OTP
     *
     * @api POST api/driver/auth/resend_otp
     * @param Request $request
     * @return void
     */
    public function resend_otp(Request $request)
    {

        $request->validate([
            'phone' => 'required',
        ]);

        $phone = $this->fixNumberCode($request->phone);

        $user = Driver::where('phone', $phone)->first();
        if(!$user)
        return response()->error('Driver_not_found',400);
 
        if ($user->is_phone_verified == 1 ) 
        {
            return response()->error('already verified',400);
        }

        // send only if its expired
        if (!$user->otp_expiration || now()->gt($user->otp_expiration)) {
            $user->otp_expiration = now()->addMinutes(config('app.otp_expiration', 3));
          //  \Notification::send($user, new LoginOtpNotification($user->otp));
        }

        return response()->api(null , 'otp resent');
    }


      /**
     * Create Register Password
     *
     * @api POST api/driver/auth/create_password_register
     * @param Request $request
     * @return void
     */
    public function register_password(Request $request)
    {

        $request->validate([
            'password' => ['required', 
               'min:6', 
               ],
            'device_token' =>'required',
            'device_type' =>'required',
            'locale'=>'required',
            'phone'=>'required'

        ]);

        $phone = $this->fixNumberCode($request->phone);

        $user = Driver::where('phone', $phone)->firstOrFail();
        if(!$user)
        return response()->error('not_register',400);
 
        $locales = config('app.locales');
        $locale = $request->locale;
        if (array_key_exists($locale, $locales)) {
            $user->locale = $locale;
       
        }
        $user->api_token = \Str::random(60);
        $user->password = bcrypt($request->password);
        $user->device_token = $request->device_token;
        $user->device_type=$request->device_type;
        $user->step = 1;
        $user->makeVisible(['api_token']);
        $user->save();
      
        return response()->api($user,Lang::get('models/driver.driver_register_password'));
    }


    /**
     * Create Register Password
     *
     * @api POST api/driver/register
     * @param Request $request
     * @return void
     */
    public function register(Request $request)
    {

        $request->validate([
            'first_name' =>'required',
            'last_name' =>'required',
            'national_id'=>'required',
            'driver_license'=>'required',
            'front_vehicle'=>'required',
            'back_vehicle'=>'required',
            'vehicle_registration'=>'required',
            'vehicle_insurance'=>'',
            'authoriztion'=>'',
        ]);

        $user = $request->user();
        
       if(!$user)
       return response()->error('not_register',400);
       DB::beginTransaction();
       try {
           
       
       // create vehicle 
        $vehicle = $user->vehicle()->create([]);
        

        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->step = 2;
        $user->device_type=$request->device_type;

        if($request->hasFile('national_id'))
        {
           $user->documents()->create([
                'image'=>$request->national_id->store(Driver::IMAGEPATH),
            ]);
    
        }
        if($request->hasFile('driver_license'))
        {
           $user->documents()->create([
                'image'=>$request->driver_license->store(Driver::IMAGEPATH),
            ]);
    
        }

        if($request->hasFile('front_vehicle'))
        {
           $vehicle->documents()->create([
                'image'=>$request->front_vehicle->store(Driver::IMAGEPATH),
            ]);
    
        }
        if($request->hasFile('back_vehicle'))
        {
            $vehicle->documents()->create([
                'image'=>$request->back_vehicle->store(Driver::IMAGEPATH),
            ]);
        }
        if($request->hasFile('vehicle_registration'))
        {
           $vehicle->documents()->create([
                'image'=>$request->vehicle_registration->store(Driver::IMAGEPATH),
            ]);
        }
        if($request->hasFile('vehicle_insurance'))
        {
           $vehicle->documents()->create([
                'image'=>$request->vehicle_insurance->store(Driver::IMAGEPATH),
            ]);
        }
        if($request->hasFile('authoriztion'))
        {
           $vehicle->documents()->create([
                'image'=>$request->authoriztion->store(Driver::IMAGEPATH),
            ]);
        }
        
        $user->save();

        DB::commit();
        
        return response()->api($user,Lang::get('models/driver.driver_register'));
        } catch (\Throwable $th) {
           return response()->error('error',400);
        }
    }
}
