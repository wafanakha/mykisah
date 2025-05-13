<?php

use App\Http\Controllers\authController;
use App\Http\Controllers\kisahController;
use App\Http\Controllers\userController;
use App\Http\Controllers\GoogleAuthController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/sanctum/token', [authController::class, 'login']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/user/{user}', function (User $user) {
    return $user;
});


Route::get('user', [userController::class, 'getbyName']);

Route::post('kisah/create', [kisahController::class, 'store']);
Route::get('kisah/search', [kisahController::class, 'getKisahSearch']);
Route::get('kisah/all', [kisahController::class, 'showAll'])->middleware('auth:sanctum');
Route::get('kisah/user/{id}', [kisahController::class, 'getUserKisah']);
Route::get('kisah/user/{id}/sort/{order}', [kisahController::class, 'getUserKisahSorted']);
Route::get('kisah/{id}', [kisahController::class, 'show']);
Route::delete('kisah/delete/{id}', [kisahController::class, 'destroy']);
Route::patch('kisah/update/{id}', [kisahController::class, 'update']);


// Route::get('/api/auth/google/redirect', [GoogleAuthController::class, 'redirect'])->name('auth.google.redirect');
// Route::get('/api/auth/google/callback', [GoogleAuthController::class, 'callback'])->name('auth.google.callback');
