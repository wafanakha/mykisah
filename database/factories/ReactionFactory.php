<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Kisah;

class ReactionFactory extends Factory
{
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'kisah_id' => Kisah::factory(),
            'value' => $this->faker->randomElement([-1, 1]),
        ];
    }
}
