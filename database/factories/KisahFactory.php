<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Kisah>
 */
class KisahFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'judul' => fake()->sentence(3),
            'sinopsis' => fake()->paragraph(2),
            'isi' => fake()->paragraph(10),
            'like' => fake()->numberBetween(0, 100),
            'dislike' => fake()->numberBetween(0, 50),
            'user_id' => User::inRandomOrder()->first()->id ?? User::factory(),
        ];
    }
}
