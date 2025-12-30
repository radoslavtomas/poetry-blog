<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Poem>
 */
class PoemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Generate poems of varying lengths
        $isShort = fake()->boolean(20); // 20% chance of short poem
        $linesSk = $isShort ? rand(2, 3) : rand(4, 12);
        $linesEn = $isShort ? rand(2, 3) : rand(4, 12);
        
        $bodySk = collect(range(1, $linesSk))
            ->map(fn() => fake()->sentence(rand(3, 8)))
            ->implode("\n");
            
        $bodyEn = collect(range(1, $linesEn))
            ->map(fn() => fake()->sentence(rand(3, 8)))
            ->implode("\n");
        
        return [
            'title' => [
                'sk' => fake()->sentence(rand(2, 5), false),
                'en' => fake()->sentence(rand(2, 5), false),
            ],
            'body' => [
                'sk' => $bodySk,
                'en' => $bodyEn,
            ],
            'book_id' => null,
            'source_id' => null,
            'position_in_book' => null,
        ];
    }
}
