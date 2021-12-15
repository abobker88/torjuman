<?php

namespace App\Http\Controllers\Api\Driver;

use App\Enums\DriverAvailability;
use App\Enums\DriverBehaviorType;
use App\Events\DriverBehaviorAlertCreated;
use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Rules\MatchOldPassword;
use App\Traits\mobileTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Lang;

class ProfileController extends Controller
{
    use mobileTrait;
    /**
     * Change auth locale preference
     *
     * @api POST api/drivers/profile/change_locale
     * @param Request $request
     * @return Response
     */
    public function change_locale(Request $request)
    {
        $request->validate([
            'locale' => 'nullable|string'
        ]);

        $locales = config('app.locales');
        $locale = $request->locale;
        $user = $request->user();

        if (array_key_exists($locale, $locales)) {
            $user->locale = $locale;
            $user->save();
        }

        return response()->api($user->only('locale'));
    }

    /**
     * Change auth locale preference
     *
     * @api POST api/drivers/profile/toggle_duty
     * @param Request $request
     * @return Response
     */
    public function toggle_duty(Request $request)
    {
        $user = $request->user();

        if ($user->is_available == DriverAvailability::OnDuty) {
            return response()->error('cant_switch_onduty');
        }

        $user->is_available = 1 - $user->is_available;
        $user->save();

        return response()->api($user->only('is_available'));
    }

    /**
     * Change auth locale preference
     *
     * @api POST api/drivers/profile/update_location
     * @param Request $request
     * @return Response
     */
    public function update_location(Request $request)
    {
        $request->validate([
            'latitude' => 'required',
            'longitude' => 'required',
            'timestamp' => 'required|date_format:U',
        ]);

        $user = $request->user();

        $geo = $user->geo()->create([
            'vehicle_id' => $user->vehicle_id,
            'timestamp' => Carbon::createFromTimestamp($request->timestamp)->toDateTimeString(),
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'altitude' => $request->altitude,
            'speed_accuracy' => $request->speed_accuracy,
            'degrees' => $request->degrees,
            'speed' => $request->speed,
        ]);

        // TODO:: create the event
        // event(new GeoLocationCreated);

        return response()->api($geo);
    }

    /**
     * Change auth locale preference
     *
     * @api POST api/drivers/profile/update_password
     * @param Request $request
     * @return Response
     */
    public function update_password(Request $request)
    {
        $request->validate([
            'current_password' => ['required', new MatchOldPassword],
            'new_password' => ['required'],
            'new_confirm_password' => ['same:new_password'],
        ]);


        Driver::find($request->user()->id)->update(['password'=> Hash::make($request->new_password)]);

        return response()->api(Lang::get('models/driver.updated_password'));
    }

    /**
     * Change auth locale preference
     *
     * @api POST api/drivers/profile/reset_password
     * @param Request $request
     * @return Response
     */
    public function reset_password(Request $request)
    {
        $request->validate([
            'phone' => 'required',
        ]);

        $phone = $this->fixNumberCode($request->phone);

        $user = Driver::where('phone', $phone)->first();
        if(!$user)
        return response()->error('Driver_not_found',400);
 

        // send only if its expired

            $user->otp = rand(1000, 9999);
            $user->otp_expiration = now()->addMinutes(config('app.otp_expiration', 3));

            $user->save();
          //  \Notification::send($user, new LoginOtpNotification($user->otp));
      
        return response()->api([] , 'otp send');
        
    }


     /**
     * Change auth locale preference
     *
     * @api POST api/drivers/profile/password_create_reset
     * @param Request $request
     * @return Response
     */
    public function reset_password_password(Request $request)
    {
        $request->validate([
            'new_password' => ['required'],
            'new_confirm_password' => ['same:new_password'],
            'otp'=>'required'
        ]);

        $user=Driver::find($request->user()->id);
        // validate otp
        if ($user->otp != $request->otp) {
            return response()->error('invalid_otp');
        }

        $user->otp=0;
        $user->password=Hash::make($request->new_password);
        $user->save();

        return response()->api(Lang::get('models/driver.updated_password'));
    }

    
}
