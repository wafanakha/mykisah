<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Kisah;
use App\Models\User;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\komen>
 */
class komenFactory extends Factory
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
            'user_id' => User::inRandomOrder()->first()->id ?? User::factory(),
            'textkomen' => fake()->sentence(10),
        ];
    }
}
