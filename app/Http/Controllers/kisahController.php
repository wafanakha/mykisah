<?php

namespace App\Http\Controllers;

use App\Models\Kisah;
use App\Models\genre;
use Illuminate\Http\Request;

class kisahController extends Controller
{

    public function showAll()
    {
        return Kisah::with('user', 'genres', 'comments')->get();
    }

    public function show(Request $request)
    {
        $id = $request->query('id');
        return Kisah::with('user', 'genres', 'comments')->findOrFail($id);
    }

    public function getUserKisah(Request $request)
    {
        $id = $request->query('id');
        $kisahList = Kisah::with(['user', 'genres', 'comments.user'])
            ->where('user_id', $id)
            ->get();

        return response()->json($kisahList);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'sinopsis' => 'required|string|max:255',
            'isi' => 'required|string',
            'user_id' => 'required|exists:users,id',
            'genres' => 'required|array',
            'genres.*' => 'in:Romance,Fantasy,Horror,Misteri,Laga,Sejarah,Fiksi Ilmiah,Petualangan'
        ]);

        $kisah = Kisah::create([
            'judul' => $validated['judul'],
            'sinopsis' => $validated['sinopsis'],
            'isi' => $validated['isi'],
            'user_id' => $validated['user_id'],
            'like' => 0,
            'dislike' => 0,
        ]);

        foreach ($validated['genres'] as $genre) {
            genre::create([
                'kisah_id' => $kisah->id,
                'genre' => $genre
            ]);
        }

        return response()->json([
            'message' => 'Kisah dan genre Dibuat!',
            'kisah' => $kisah->load('genres', 'user')
        ], 201);
    }

    public function destroy(Request $request)
    {
        $id = $request->query('id');
        $kisah = Kisah::findOrFail($id);

        $kisah->genres()->delete();
        $kisah->comments()->delete();
        $kisah->bookmarks()->detach();
        $kisah->delete();

        return response()->json(['message' => 'Kisah Dihapus!']);
    }

    public function update(Request $request, $id)
    {
        $kisah = Kisah::findOrFail($id);
        $kisah->update($request->only(['judul', 'sinopsis', 'isi']));
        return response()->json($kisah);
    }
}
