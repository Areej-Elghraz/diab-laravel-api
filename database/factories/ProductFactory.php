<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // 'description' => fake()->text(),
            'name' => fake()->unique()->name(),
            'description' => 'ركنة: 4 فتيه و 1 كنبة و 1 ترابيزة',
            'category_id' => Category::inRandomOrder()->first()->id,
        ];
    }
}
