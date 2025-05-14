<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class userController extends Controller
{
    public function getbyName(Request $request)
    {
        $name = $request->query('name');

        if (!$name) {
            return response()->json(['message' => 'Parameter name is required'], 400);
        }

        $users = User::where('name', 'like', '%' . $name . '%')->get();

        return response()->json($users);
    }

    public function storeAvatar(Request $request)
    {
        $user = User::find(Auth::id());

        $request->validate([
            'avatar' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $file = $request->file('avatar');
        $filename = time() . '_' . $file->getClientOriginalName();

        $file->move(public_path('images'), $filename);

        $imageUrl = 'images/' . $filename;
        $user->avatar = $imageUrl;
        $user->save(); // 

        return response()->json([
            'message' => 'Image uploaded successfully',
            'path' => $imageUrl,
            'url' => asset($imageUrl),
        ]);
    }

    public function getAvatar()
    {
        $user = User::find(Auth::id());
        return Storage::get($user->avatar);
    }
}
