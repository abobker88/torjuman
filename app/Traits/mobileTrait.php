<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait mobileTrait {

    /**
     * @param Request $request
     * @return $this|false|string
     */
    public function fixNumberCode($phoneNumber, $country = "SA") {

        $countryCode = self::getCountryCode($country);

        if (substr($phoneNumber, 0, 3) == $countryCode)
            return $phoneNumber;

        elseif(substr($phoneNumber, 0, 2) == "05")
            return $countryCode.substr($phoneNumber, 1); //remove 0 and place country code

        elseif (substr($phoneNumber, 0, 4) == "+966")
            return substr($phoneNumber, 1);

        elseif(substr($phoneNumber, 0, 1) == "5")
            return $countryCode.$phoneNumber; //Just add country code 966
    }

    public static $countryCodes = [
        'SA' => '966',
    ];

    private static function getCountryCode($country)
    {
        return self::$countryCodes[$country];
    }

}