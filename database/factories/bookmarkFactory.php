<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Kisah;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\bookmark>
 */
class bookmarkFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->first()->id ?? User::factory(),
            'kisah_id' => Kisah::inRandomOrder()->first()->id ?? Kisah::factory(),
        ];
    }
}
