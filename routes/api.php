<?php

use App\Http\Controllers\authController;
use App\Http\Controllers\kisahController;
use App\Http\Controllers\userController;
use App\Http\Controllers\followController;
use App\Http\Controllers\komenController;
use App\Http\Controllers\GoogleAuthController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/sanctum/token', [authController::class, 'login']);


Route::middleware('auth:sanctum')->group(function () {
    Route::get('user', [userController::class, 'getbyName']);
    Route::get('user/all', [userController::class, 'showAll']);
    Route::post('user/uploadAvatar', [userController::class, 'storeAvatar']);
    Route::get('user/getAvatar', [userController::class, 'getAvatar']);

    Route::post('user/addBookmark', [userController::class, 'addBookmark']);
    Route::get('user/getBookmark', [userController::class, 'getBookmark']);
});

Route::get('/user/{user}', function (User $user) {
    return $user;
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('kisah/create', [kisahController::class, 'store']);

    Route::get('kisah/search', [kisahController::class, 'getKisahSearch']);
    Route::get('kisah/all', [kisahController::class, 'showAll']);

    Route::get('kisah/user/{id}', [kisahController::class, 'getUserKisah']);
    Route::get('kisah/user/{id}/sort/{order}', [kisahController::class, 'getUserKisahSorted']);
    Route::get('kisah/{id}', [kisahController::class, 'show']);

    Route::delete('kisah/delete/{id}', [kisahController::class, 'destroy']);
    Route::patch('kisah/update/{id}', [kisahController::class, 'update']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/follow/{id}', [FollowController::class, 'follow']);
    Route::delete('/unfollow/{id}', [FollowController::class, 'unfollow']);

    Route::get('/followers', [FollowController::class, 'myFollowers']);
    Route::get('/followings', [FollowController::class, 'myFollowings']);

    Route::get('/user/{id}/followers', [FollowController::class, 'followersOf']);
    Route::get('/user/{id}/followings', [FollowController::class, 'followingsOf']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/komen', [komenController::class, 'store']);
    Route::get('/komen/kisah/{id}', [komenController::class, 'getByKisah']);
    Route::delete('/komen/{id}', [komenController::class, 'destroy']);
});

// Route::get('/api/auth/google/redirect', [GoogleAuthController::class, 'redirect'])->name('auth.google.redirect');
// Route::get('/api/auth/google/callback', [GoogleAuthController::class, 'callback'])->name('auth.google.callback');
