<?php

namespace Database\Seeders;

use App\Models\Reaction;
use App\Models\User;
use App\Models\Kisah;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReactionSeeder extends Seeder
{

    public function run(): void
    {
        // Create test data if none exists
        $users = User::count() > 20 ? User::all() : User::factory(20)->create();
        $kisahs = Kisah::count() > 5 ? Kisah::all() : Kisah::factory(5)->create();

        // Create reactions
        Reaction::factory(50)->create([
            'user_id' => fn() => $users->random()->id,
            'kisah_id' => fn() => $kisahs->random()->id,
        ]);
    }
}
