<?php

namespace App\Enums;

enum ProductImagePositionEnum: string
{
    case before = 'before';
    case after = 'after';
    case gallery = 'gallery';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}