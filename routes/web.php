<?php

use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\kisahController;
use App\Http\Controllers\komenController;
use App\Http\Controllers\userController;
use App\Http\Controllers\SearchController;
use App\Livewire\Search;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;


Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

Route::get('/auth/google/redirect', [GoogleAuthController::class, 'redirect'])->name('auth.google.redirect');
Route::get('/api/auth/google/callback', [GoogleAuthController::class, 'callback'])->name('auth.google.callback');

Route::middleware(['auth'])->group(function () {
    Route::get('kisah/create', [KisahController::class, 'web_create'])->name('kisah.create');
    Route::post('kisah', [KisahController::class, 'web_store'])->name('kisah.store');
});

Route::get('/search', \App\Livewire\Search::class)->name('search');


Route::get('/dashboard', [kisahController::class, 'index'])->middleware(['auth'])->name('dashboard');
Route::get('/kisah/{id}', [KisahController::class, 'web_show'])->name('kisah.show');
Route::post('/komen', [komenController::class, 'web_store'])->name('komen.store');

Route::get('/profile/{id}', [userController::class, 'profile'])->middleware('auth')->name('profile');

Route::get('/users/{user}/followers', [userController::class, 'followers'])
    ->name('profile.followers');

Route::get('/users/{user}/following', [userController::class, 'following'])
    ->name('profile.following');

Route::get('/kisah/{kisah}/edit', \App\Livewire\Kisah\EditKisah::class)
    ->name('kisah.edit')
    ->middleware('auth');

require __DIR__ . '/auth.php';
