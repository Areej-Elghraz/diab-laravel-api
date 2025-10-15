<?php

namespace App\Enums;

enum SocialMediaEnum: string
{
    case facebook = 'facebook';
    case instagram = 'instagram';
    case messenger = 'messenger';
    case tiktok = 'tiktok';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
