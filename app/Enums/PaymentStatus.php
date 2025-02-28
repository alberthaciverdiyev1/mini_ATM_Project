<?php

namespace App\Enums;

enum PaymentStatus: int
{
    case ACTIVE = 1;
    case CANCELLED = 2;
}
