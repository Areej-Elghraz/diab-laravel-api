<?php

namespace App\Enums;

enum TokenAbilityEnum: string
{
    case access_token = 'access_token';
    case remember_token = 'remember_token';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
