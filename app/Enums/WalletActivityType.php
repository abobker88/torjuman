<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class WalletActivityType extends Enum
{
    const Credit  = 'c';
    const Debit   = 'd';
}
