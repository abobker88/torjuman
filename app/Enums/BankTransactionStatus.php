<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class BankTransactionStatus extends Enum
{
    const Approved  = 'a';
    const Decline   = 'd';
    const Pending   = 'p';
}
