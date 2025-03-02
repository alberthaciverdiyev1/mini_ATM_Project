<?php

namespace App\Enums;

enum PaymentSource: int
{
    case USER = 0;

    case ATM = 1;
}
