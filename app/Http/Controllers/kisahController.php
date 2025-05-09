<?php

namespace App\Http\Controllers;

use App\Models\Kisah;
use Illuminate\Http\Request;

class kisahController extends Controller
{
    public function getUserKisah(Request $request)
    {
        $id = $request->query('id');
        $kisahList = Kisah::with(['user', 'genres', 'comments.user'])
            ->where('user_id', $id)
            ->get();

        return response()->json($kisahList);
    }


    public function getAllKisah()
    {
        return Kisah::with('user', 'genres', 'comments')->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required',
            'sinopsis' => 'required',
            'isi' => 'required',
            'user_id' => 'required|exists:users,id',
        ]);

        $kisah = Kisah::create($validated);

        return response()->json($kisah, 201);
    }

    public function show(Request $request)
    {
        $id = $request->query('id');
        return Kisah::with('user', 'genres', 'comments')->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $kisah = Kisah::findOrFail($id);
        $kisah->update($request->only(['judul', 'sinopsis', 'isi']));
        return response()->json($kisah);
    }

    public function destroy($id)
    {
        Kisah::destroy($id);
        return response()->json(['message' => 'Deleted']);
    }
}
