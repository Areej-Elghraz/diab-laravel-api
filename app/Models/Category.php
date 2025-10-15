<?php

namespace App\Models;

use App\Traits\LocalTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    /** @use HasFactory<\Database\Factories\CategoryFactory> */
    use HasFactory, LocalTimestamps;

    protected $fillable = [
        'name',
        // 'created_by',
        // 'updated_by'
    ];

    // protected $hidden = [
    //     'created_by',
    //     'updated_by',
    // ];

    protected $appends = [
        'products_count',
    ];

    // public function creator(): BelongsTo
    // {
    //     return $this->belongsTo(User::class, 'created_by');
    // }

    // public function updater(): BelongsTo
    // {
    //     return $this->belongsTo(User::class, 'updated_by');
    // }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function getProductsCountAttribute(): int
    {
        return $this->products_count ?? $this->products()->count();
    }

    // public function products(): HasMany
    // {
    //     return $this->hasMany(Product::class);
    // }

    //  with product_images
}
