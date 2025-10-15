<?php

namespace App\Enums;

enum ProductImageRelationEnum: string
{
    case product = 'product';
    case product_category = 'product-category';
    case product_images = 'product-images';
    case product_beforeImage = 'product-beforeImage';
    case product_afterImage = 'product-afterImage';
    case product_gallery = 'product-gallery';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
