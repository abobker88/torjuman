<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class DriverAvailability extends Enum
{
    const OutOfService  = 0;
    const InService     = 1;
    const OnDuty        = 2;
}
