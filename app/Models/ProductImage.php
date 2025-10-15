<?php

namespace App\Models;

use App\Traits\LocalTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Validation\ValidationException;

class ProductImage extends Model
{
    /** @use HasFactory<\Database\Factories\ProductImageFactory> */
    use HasFactory, LocalTimestamps;

    protected $fillable = [
        'product_id',
        'image',
        'position',
    ];

    protected $hidden = [
        'product_id',
    ];

    protected $touches = ['product'];

    protected static function booted()
    {
        static::creating(function ($image) {
            $product = $image->product;
            $max = config('max.product_images', 5);
            if ($product && $product->images()->count() >= $max) {
                throw ValidationException::withMessages([
                    'images' => __('messages.max_reached', ['max' => $max, 'object' => __('messages.resources.productimage.plural')]),
                ]);
            }
        });
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function getImageAttribute($value)
    {
        return $value ? url('storage/' . $value) : null;
    }

    public function isBeforeImage()
    {
        return $this->position == 'before';
    }

    public function isAfterImage()
    {
        return $this->position == 'after';
    }

    public function isGallery()
    {
        return $this->position == 'gallery';
    }


    // with categories

}
