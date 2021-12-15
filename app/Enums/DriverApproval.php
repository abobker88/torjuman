<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class DriverApproval extends Enum
{
    const Approved  = 'a';
    const Rejected     = 'r';
    const Pending        = 'p';
}
