<?php

namespace Database\Seeders;

use App\Models\Kisah;
use App\Models\Reaction;
use App\Models\User;
use Illuminate\Database\Seeder;

class KisahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Kisah::factory(20)->create();
    }
}
