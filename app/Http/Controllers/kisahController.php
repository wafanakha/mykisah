<?php

namespace App\Http\Controllers;

use App\Models\Kisah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class kisahController extends Controller
{
    public function getUserKisah(Request $request)
    {
        $id = $request->query('user');
        $kisah = DB::select(
            'SELECT 
                kisah.id AS kisah_id,
                users.id AS user_id,
                users.name,
                users.avatar,
                kisah.judul,
                kisah.sinopsis,
                kisah.isi,
                genre.genre,
                `like`,
                `dislike`,
                komen.user_id AS komen_user_id,
                komen.kisah_id AS komen_kisah_id,
                komen.textkomen
            FROM kisah
            JOIN users ON kisah.user_id = users.id
            JOIN genre ON genre.kisah_id = kisah.id
            JOIN komen ON komen.kisah_id = kisah.id
            WHERE users.id = ?
            ORDER BY kisah.id ASC',
            [$id]
        );

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

    public function getKisah(Request $request)
    {
        $id = $request->query('kisah');
        $kisah = Kisah::with(['user:id,name,avatar', 'genre'])
            ->where('id', $id)
            ->get();

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

    public function getAllKisah()
    {
        $kisah = DB::select('select kisah.id as kisah_id, users.id as user_id, users.name, users.avatar, judul, sinopsis, isi, genre  from kisah join users on kisah.user_id=users.id join genre on genre.kisah_id=kisah.id');

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

    public function getJudul()
    {
        $title = DB::select('select judul from kisah;');
        return $title;
    }
}
