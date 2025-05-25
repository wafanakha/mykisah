<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Kisah;
use App\Models\bookmark;
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

    public function showAll()
    {
        return User::all();
    }

    public function storeAvatar(Request $request)
    {
        $user = User::find(Auth::id());

        $request->validate([
            'avatar' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $file = $request->file('avatar');
        $filename = time() . '_' . $user->id . '.' . $file->extension();

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
        $path = public_path($user->avatar);

        if (!file_exists($path)) {
            return response()->json(['message' => 'Image not found'], 404);
        }

        return response()->file($path);
    }


    public function addBookmark(Request $request)
    {
        $request->validate([
            'kisah_id' => 'required|exists:kisah,id',
        ]);

        $user = User::find(Auth::id());

        if ($user->bookmarks()->where('kisah_id', $request->kisah_id)->exists()) {
            return response()->json(['message' => 'Kisah sudah di-bookmark.'], 409);
        }

        $user->bookmarks()->attach($request->kisah_id);

        return response()->json(['message' => 'Bookmark berhasil ditambahkan.']);
    }

    public function getBookmark()
    {
        $user = User::find(Auth::id());

        $bookmarks = $user->bookmarks()->with('genres', 'user')->get();

        return response()->json($bookmarks);
    }

    //   For Web

    public function profile($id)
    {
        $user = User::find($id);
        $kisahList = $user->kisah()->with('genres')->latest()->get();

        return view('profile', compact('user', 'kisahList'));
    }

    public function followers(User $user)
    {
        return view('profile.followers', [
            'user' => $user,
            'followers' => $user->followers()->paginate(20)
        ]);
    }

    public function following(User $user)
    {
        return view('profile.following', [
            'user' => $user,
            'followings' => $user->follows()->paginate(20)
        ]);
    }
}
