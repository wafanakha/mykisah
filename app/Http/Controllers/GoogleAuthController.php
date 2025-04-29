<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Throwable;

class GoogleAuthController extends Controller
{
    // redirect user ke google auth page
    public function redirect(){
        return Socialite::driver('google')->redirect();
    }

    public function callback(){
        try{
            $user = Socialite::driver('google')->user();
        } catch (Throwable $e) {
            return redirect('/')->with('error', 'Google authentication failed.');
        }

        $existingUser = User::where('email', $user->email)->first();

        if($existingUser){
            Auth::login($existingUser);
        } else {
            $newUser = User::updateOrCreate([
                'email' => $user->email
            ],[
                'name' => $user->name,
                'password' => bcrypt(Str::random(16)),
                'email_verified_at' => now()
            ]);
            Auth::login($newUser);   
        }
        return redirect()->intended(route('dashboard', absolute: false).'?verified=1');
    }
}
