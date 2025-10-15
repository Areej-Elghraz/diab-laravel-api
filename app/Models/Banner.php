<?php

namespace App\Models;

use App\Traits\LocalTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Banner extends Model
{
    /** @use HasFactory<\Database\Factories\BannerFactory> */
    use HasFactory, LocalTimestamps;

    protected $fillable = [
        'image'
    ];

    protected static function booted()
    {
        static::creating(function ($banner) {
            $max = config('max.banners', 10); // allowed banners
            if (self::count() >= $max) {
                throw new \Exception(__('messages.max_reached', ['max' => $max, 'object' => __('messages.resources.banner.plural')]), 400);
            }
        });
    }

    public function getImageAttribute($value)
    {
        return $value ? url('storage/' . $value) : null;
    }
}
