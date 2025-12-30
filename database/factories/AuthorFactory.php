<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Author>
 */
class AuthorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'bio' => [
                'sk' => fake()->paragraphs(3, true),
                'en' => fake()->paragraphs(3, true),
            ],
            'image_path' => null, // Will be set in seeder
        ];
    }
}
