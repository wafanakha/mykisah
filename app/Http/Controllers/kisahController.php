<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class kisahController extends Controller
{
    public function getUserKisah($id)
    {
        $kisah = DB::select('select kisah.id as kisah_id, users.id as user_id, users.name, users.icon, judul, sinopsis, isi, genre  from kisah join users on kisah.user_id=users.id join genre on genre.kisah_id=kisah.id where user_id = ? order by kisah.id asc', [$id]);

        $grouped = [];

        foreach ($kisah as $kis) {
            $id = $kis->kisah_id;

            if (!isset($grouped[$id])) {
                $grouped[$id] = $kis;
                $grouped[$id]->genre = [$kis->genre];
            } else {
                if (!in_array($kis->genre, $grouped[$id]->genre)) {
                    $grouped[$id]->genre[] = $kis->genre;
                }
            }
        }
        return array_values($grouped);
    }

    public function getKisah($id)
    {
        $kisah = DB::select('select kisah.id as kisah_id, users.id as user_id, users.name, users.icon, judul, sinopsis, isi, genre  from kisah join users on kisah.user_id=users.id join genre on genre.kisah_id=kisah.id where kisah.id = ?', [$id]);
        $grouped = [];

        foreach ($kisah as $kis) {
            $id = $kis->kisah_id;

            if (!isset($grouped[$id])) {
                $grouped[$id] = $kis;
                $grouped[$id]->genre = [$kis->genre];
            } else {
                if (!in_array($kis->genre, $grouped[$id]->genre)) {
                    $grouped[$id]->genre[] = $kis->genre;
                }
            }
        }
        return array_values($grouped);
    }
}
