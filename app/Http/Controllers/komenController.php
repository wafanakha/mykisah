<?php

namespace App\Http\Controllers;

use App\Models\komen;
use App\Models\Kisah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class komenController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'isi' => 'required|string',
            'kisah_id' => 'required|exists:kisah,id',
        ]);

        $komen = Komen::create([
            'isi' => $validated['isi'],
            'kisah_id' => $validated['kisah_id'],
            'user_id' => Auth::id(),
        ]);

        return response()->json([
            'message' => 'Komentar berhasil ditambahkan',
            'komen' => $komen->load('user')
        ], 201);
    }

    public function getByKisah($id)
    {
        $comments = Komen::where('kisah_id', $id)->with('user')->latest()->get();

        return response()->json($comments);
    }

    public function destroy($id)
    {
        $komen = Komen::findOrFail($id);

        if ($komen->user_id === Auth::id() || $komen->kisah->user_id === Auth::id()) {
            $komen->delete();
            return response()->json(['message' => 'Komentar berhasil dihapus']);
        }

        return response()->json(['message' => 'Tidak diizinkan menghapus komentar ini'], 403);
    }
}
