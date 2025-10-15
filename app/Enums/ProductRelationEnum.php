<?php

namespace App\Enums;

enum ProductRelationEnum: string
{
    case category = 'category';
    case images = 'images';
    case beforeImage = 'beforeImage';
    case afterImage = 'afterImage';
    case gallery = 'gallery';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
