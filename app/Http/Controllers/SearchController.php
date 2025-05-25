<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kisah;
use App\Models\User;
use App\Models\genre;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('q');

        // Pencarian kisah
        $kisahQuery = Kisah::with(['user', 'genres']);

        if ($query) {
            $kisahQuery->where(function ($q) use ($query) {
                $q->where('judul', 'like', "%{$query}%")
                    ->orWhereHas('user', fn($sub) => $sub->where('name', 'like', "%{$query}%"))
                    ->orWhereHas('genres', fn($sub) => $sub->where('genre', 'like', "%{$query}%"));
            });
        }

        $kisahResults = $kisahQuery->get();

        // Pencarian user
        $userResults = User::when($query, fn($q) => $q->where('name', 'like', "%{$query}%"))->get();


        return view('search.index', compact('query', 'kisahResults', 'userResults'));
    }
}
