<?php

namespace Database\Seeders;


use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;
use App\Models\Kisah;
use App\Models\genre;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $availableGenres = ['Romance', 'Fantasy', 'Horror', 'Misteri', 'Laga', 'Sejarah', 'Fiksi Ilmiah', 'Petualangan'];

        $kisahList = Kisah::all();

        foreach ($kisahList as $kisah) {
            // Pilih 1-3 genre acak
            $randomGenres = collect($availableGenres)->shuffle()->take(rand(1, 3));

            foreach ($randomGenres as $genreName) {
                genre::create([
                    'kisah_id' => $kisah->id,
                    'genre' => $genreName,
                ]);
            }
        }
    }
}
