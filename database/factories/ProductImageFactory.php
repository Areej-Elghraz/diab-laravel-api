<?php

namespace Database\Factories;

use App\Enums\ProductImagePositionEnum;
use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductImage>
 */
class ProductImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'image' => fake()->unique()->imageUrl(),
            'position' => fake()->randomElement(ProductImagePositionEnum::values()),
            'product_id' => Product::inRandomOrder()->first()->id,
        ];
    }
}
