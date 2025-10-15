<?php

namespace App\Enums;

enum UserRoleEnum: string
{
    case admin = 'admin';
    case user = 'user';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}