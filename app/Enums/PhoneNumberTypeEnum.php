<?php

namespace App\Enums;

enum PhoneNumberTypeEnum: string
{
    case phone = 'phone';
    case whatsapp = 'whatsapp';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}