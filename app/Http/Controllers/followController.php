<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;

class followController extends Controller
{
    public function follow($id)
    {
        $user = User::find(Auth::id());
        if ($user->id == $id) {
            return response()->json(['message' => 'Tidak bisa follow diri sendiri'], 400);
        }

        $user->follows()->syncWithoutDetaching([$id]);

        return response()->json(['message' => 'Berhasil follow user']);
    }

    public function unfollow($id)
    {
        $user = User::find(Auth::id());
        $user->follows()->detach($id);

        return response()->json(['message' => 'Berhasil unfollow user']);
    }

    public function myFollowers()
    {
        $user = User::find(Auth::id());
        return response()->json($user->followers);
    }

    public function myFollowings()
    {
        $user = User::find(Auth::id());
        return response()->json($user->follows);
    }

    public function followersOf($id)
    {
        $target = User::findOrFail($id);
        return response()->json($target->followers);
    }

    public function followingsOf($id)
    {
        $target = User::findOrFail($id);
        return response()->json($target->follows);
    }
}
