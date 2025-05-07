<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\follow>
 */
class FollowFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => $user = User::inRandomOrder()->first()->id ?? User::factory(),
            'following_id' => function () use ($user) {
                do {
                    $followId = User::inRandomOrder()->first()->id ?? User::factory();
                } while ($followId == $user);
                return $followId;
            },
        ];
    }
}
