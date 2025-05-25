<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kisah;
use App\Models\User;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('q');

        $kisahResults = Kisah::with(['user', 'genres'])
            ->where('judul', 'like', "%{$query}%")
            ->orWhereHas('user', fn($q) => $q->where('name', 'like', "%{$query}%"))
            ->orWhereHas('genres', fn($q) => $q->where('genre', 'like', "%{$query}%"))
            ->get();

        $userResults = User::where('name', 'like', "%{$query}%")->get();

        return view('search.index', compact('query', 'kisahResults', 'userResults'));
    }
}
