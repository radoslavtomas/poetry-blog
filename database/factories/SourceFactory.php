<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Source>
 */
class SourceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $type = fake()->randomElement(['newspaper', 'magazine', 'website', 'other']);
        
        return [
            'name' => [
                'sk' => fake()->company(),
                'en' => fake()->company(),
            ],
            'type' => $type,
            'url' => $type === 'website' ? fake()->url() : null,
        ];
    }
}
