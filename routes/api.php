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


Route::get('/user/{user}', function (User $user) {
    return $user;
});

Route::get('user', [userController::class, 'getbyName']);

Route::get('kisah', [kisahController::class, 'getUserKisah']);
Route::get('kisah', [kisahController::class, 'getKisah']);
Route::get('kisah/judul', [kisahController::class, 'getJudul']);
Route::get('kisah/all', [kisahController::class, 'getAllkisah']);

Route::get('/api/auth/google/redirect', [GoogleAuthController::class, 'redirect'])->name('auth.google.redirect');
Route::get('/api/auth/google/cphpphpallback', [GoogleAuthController::class, 'callback'])->name('auth.google.callback');
