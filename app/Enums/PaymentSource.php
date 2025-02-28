<?php

namespace App\Enums;

enum PaymentSource: int
{
    case ATM = 1;
    case USER = 2;
}
