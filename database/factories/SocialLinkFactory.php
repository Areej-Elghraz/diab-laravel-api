<?php

namespace Database\Factories;

use App\Enums\SocialMediaEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SocialLink>
 */
class SocialLinkFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'social_media' => fake()->randomElement(SocialMediaEnum::values()),
            'url' => fake()->url(),
        ];
    }
}
