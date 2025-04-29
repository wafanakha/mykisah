<?php

use App\Http\Controllers\kisahController;
use App\Http\Controllers\userController;
use App\Http\Controllers\GoogleAuthController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/getuser/{user}', function (Request $request,User $user) {
    return $user->email;
});

Route::get('/home', function () {

    return response('Hello World', 200)

        ->header('Content-Type', 'text/plain');

});

Route::get('kisah/{id}', [kisahController::class, 'getKisah']);
Route::get('kisah/', [kisahController::class, 'getAllkisah']);

Route::get('/api/auth/google/redirect', [GoogleAuthController::class, 'redirect'])->name('auth.google.redirect');
Route::get('/api/auth/google/callback', [GoogleAuthController::class, 'callback'])->name('auth.google.callback');