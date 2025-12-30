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
                ['lang' => 'sk', 'content' => '<p>' . $titleSk . '</p>'],
                ['lang' => 'en', 'content' => '<p>' . $titleEn . '</p>'],
            ],
            'cover' => null, // Will be set in seeder
            'publishing_year' => fake()->numberBetween(2000, 2024),
            'publishing_house' => [
                ['lang' => 'sk', 'content' => '<p>' . fake()->company() . '</p>'],
                ['lang' => 'en', 'content' => '<p>' . fake()->company() . '</p>'],
            ],
            'description' => [
                ['lang' => 'sk', 'content' => '<p>' . fake()->paragraph(3) . '</p>'],
                ['lang' => 'en', 'content' => '<p>' . fake()->paragraph(3) . '</p>'],
            ],
            'pdf_path' => null,
        ];
    }
}
