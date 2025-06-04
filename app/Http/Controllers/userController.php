<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Kisah;
use App\Models\bookmark;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

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
        $user =  User::find(Auth::id());

        $request->validate([
            'avatar' => 'required|image|mimes:jpg,jpeg,png,gif',
        ]);

        $file = $request->file('avatar');
        $filename = time() . '_' . $user->id . '.' . $file->extension();
        $path = public_path('storage/avatars/');

        if (!file_exists($path)) {
            mkdir($path, 0775, true);
        }

        $file->move($path, $filename);

        $imageUrl = 'storage/avatars/' . $filename;
        $user->avatar = $imageUrl;
        $user->save();

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


    public function destroy_bookmark(Request $request, Kisah $kisah)
    {
        $user = $request->user();

        $user->bookmarks()->detach($kisah->id);

        return response()->json([
            'message' => 'Bookmark removed successfully.',
        ]);
    }

    public function update(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return response()->json([
            'message' => 'Profile updated successfully.',
            'user' => $user,
        ]);
    }

    public function me(Request $request)
    {
        $user = $request->user()->load('kisah.genres');

        return response()->json([
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'avatar_url' => $user->avatar_url,
            ],
            'kisah' => $user->kisah->map(function ($kisah) {
                return [
                    'id' => $kisah->id,
                    'judul' => $kisah->judul,
                    'sinopsis' => $kisah->sinopsis,
                    'genres' => $kisah->genres->pluck('genre'),
                    'created_at' => $kisah->created_at,
                ];
            }),
        ]);
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

    public function web_bookmark()
    {
        $user = User::find(Auth::id());
        $bookmarkedKisahs = $user->bookmarks()->with('genres', 'user')->latest()->get();

        return view('bookmarks.index', compact('bookmarkedKisahs'));
    }
}
