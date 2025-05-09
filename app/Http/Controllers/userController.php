<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;


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
}
