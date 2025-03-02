<?php

namespace App\Enums;

enum PaymentType: int
{
    case IN = 1;
    case OUT = 2;

    public static function name(PaymentType $type): string
    {
        return match($type) {
            self::IN => 'Incoming Payment',
            self::OUT => 'Outgoing Payment',
        };
    }
}
