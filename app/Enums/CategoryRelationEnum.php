<?php

namespace App\Enums;

enum CategoryRelationEnum: string
{
    case products = 'products';
    case products_category = 'products-category';
    case products_images = 'products-images';
    case products_beforeImage = 'products-beforeImage';
    case products_afterImage = 'products-afterImage';
    case products_gallery = 'products-gallery';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
