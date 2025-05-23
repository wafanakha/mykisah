<?php

namespace App\Http\Controllers;

use App\Models\Kisah;
use App\Models\genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class kisahController extends Controller
{


    public function show($id)
    {
        return Kisah::with('user', 'genres', 'comments')->findOrFail($id);
    }

    public function showAll()
    {
        return Kisah::with('user', 'genres', 'comments')->get();
    }

    public function getKisahSearch()
    {
        $kisahList = Kisah::select('kisah.id', 'kisah.judul', 'kisah.user_id')
            ->get()
            ->map(function ($kisah) {
                return [
                    'id' => $kisah->id,
                    'judul' => $kisah->judul,
                    'user_name' => $kisah->user->name,
                    'genres' => $kisah->genres->pluck('genre')
                ];
            });

        return response()->json($kisahList);
    }

    public function getUserKisah($id)
    {
        $kisahList = Kisah::with(['user', 'genres', 'comments.user'])
            ->where('user_id', $id)
            ->get();

        return response()->json($kisahList);
    }

    public function getUserKisahSorted($id, $order = 'asc')
    {
        if (!in_array($order, ['asc', 'desc'])) {
            return response()->json(['error' => 'Invalid sort direction'], 400);
        }

        $kisahList = Kisah::with(['genres', 'comments', 'user'])
            ->where('user_id', $id)
            ->orderBy('created_at', $order)
            ->get();

        return response()->json($kisahList);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'sinopsis' => 'required|string|max:255',
            'isi' => 'required|string',
            'genres' => 'required|array',
            'genres.*' => 'in:Romance,Fantasy,Horror,Misteri,Laga,Sejarah,Fiksi Ilmiah,Petualangan'
        ]);

        $kisah = Kisah::create([
            'judul' => $validated['judul'],
            'sinopsis' => $validated['sinopsis'],
            'isi' => $validated['isi'],
            'user_id' => Auth::id(),
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
            'message' => 'Kisah dan genre Ditambah!',
            'kisah' => $kisah->load('genres', 'user')
        ], 201);
    }

    public function destroy($id)
    {
        $kisah = Kisah::findOrFail($id);

        if ($kisah->user_id != Auth::id()) {
            return response()->json(['message' => 'Kisah bukan dimiliki user!'], 403);
        } else {
            $kisah->genres()->delete();
            $kisah->comments()->delete();
            $kisah->bookmarkedBy()->detach();
            $kisah->delete();
            return response()->json(['message' => 'Kisah Dihapus!']);
        }
    }

    public function update(Request $request, $id)
    {
        $kisah = Kisah::findOrFail($id);

        if ($kisah->user_id != Auth::id()) {
            return response()->json(['message' => 'Kisah bukan dimiliki user!'], 403);
        }

        $validated = $request->validate([
            'judul' => 'sometimes|required|string|max:255',
            'sinopsis' => 'sometimes|required|string|max:255',
            'isi' => 'sometimes|required|string',
            'genres' => 'nullable|array',
            'genres.*' => 'in:Romance,Fantasy,Horror,Misteri,Laga,Sejarah,Fiksi Ilmiah,Petualangan'
        ]);

        // Update only provided fields
        $kisah->fill($validated);
        $kisah->save();

        if (isset($validated['genres'])) {
            // Hapus genre lama
            $kisah->genres()->delete();

            // Tambah genre baru
            foreach ($validated['genres'] as $genre) {
                \App\Models\genre::create([
                    'kisah_id' => $kisah->id,
                    'genre' => $genre
                ]);
            }
        }

        return response()->json([
            'message' => 'Kisah berhasil diperbarui',
            'kisah' => $kisah->load('genres', 'user')
        ]);
    }

    // buat website
    public function index()
    {
        $kisahList = Kisah::with(['user', 'genres'])->latest()->get();
        return view('dashboard', compact('kisahList'));
    }

    public function show_kisah($id)
    {
        $kisah = Kisah::with(['user', 'genres', 'comments.user'])->findOrFail($id);

        return view('kisah.show', compact('kisah'));
    }
}
