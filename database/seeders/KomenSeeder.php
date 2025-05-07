<?php

namespace Database\Seeders;

use App\Models\komen;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KomenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        komen::factory(50)->create();
    }
}
