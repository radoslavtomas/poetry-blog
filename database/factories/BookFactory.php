<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $titleSk = fake()->sentence(rand(2, 4), false);
        $titleEn = fake()->sentence(rand(2, 4), false);
        
        return [
            'title' => [
                'sk' => $titleSk,
                'en' => $titleEn,
            ],
            'cover' => null, // Will be set in seeder
            'publishing_year' => fake()->numberBetween(2000, 2024),
            'publishing_house' => [
                'sk' => fake()->company(),
                'en' => fake()->company(),
            ],
            'description' => [
                'sk' => fake()->paragraph(3),
                'en' => fake()->paragraph(3),
            ],
            'pdf_path' => null,
        ];
    }
}
