<?php

use App\Http\Controllers\authController;
use App\Http\Controllers\kisahController;
use App\Http\Controllers\userController;
use App\Http\Controllers\GoogleAuthController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/sanctum/token', [authController::class, 'login']);


Route::get('user', [userController::class, 'getbyName'])->middleware('auth:sanctum');
Route::get('user/all', [userController::class, 'showAll'])->middleware('auth:sanctum');
Route::post('user/uploadAvatar', [userController::class, 'storeAvatar'])->middleware('auth:sanctum');
Route::get('user/getAvatar', [userController::class, 'getAvatar'])->middleware('auth:sanctum');

Route::get('/user/{user}', function (User $user) {
    return $user;
});


Route::post('kisah/create', [kisahController::class, 'store'])->middleware('auth:sanctum');
Route::get('kisah/search', [kisahController::class, 'getKisahSearch'])->middleware('auth:sanctum');
Route::get('kisah/all', [kisahController::class, 'showAll'])->middleware('auth:sanctum');
Route::get('kisah/user/{id}', [kisahController::class, 'getUserKisah'])->middleware('auth:sanctum');
Route::get('kisah/user/{id}/sort/{order}', [kisahController::class, 'getUserKisahSorted'])->middleware('auth:sanctum');
Route::get('kisah/{id}', [kisahController::class, 'show'])->middleware('auth:sanctum');
Route::delete('kisah/delete/{id}', [kisahController::class, 'destroy'])->middleware('auth:sanctum');
Route::patch('kisah/update/{id}', [kisahController::class, 'update'])->middleware('auth:sanctum');


// Route::get('/api/auth/google/redirect', [GoogleAuthController::class, 'redirect'])->name('auth.google.redirect');
// Route::get('/api/auth/google/callback', [GoogleAuthController::class, 'callback'])->name('auth.google.callback');
