<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Kisah;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\genre>
 */
class GenreFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        return [
            'kisah_id' => Kisah::inRandomOrder()->first()->id ?? Kisah::factory(),
            'genre' => fake()->randomElement(['Romance', 'Fantasy', 'Horror', 'Misteri', 'Laga', 'Sejarah', 'Fiksi Ilmiah', 'Petualangan']),
        ];
    }
}
