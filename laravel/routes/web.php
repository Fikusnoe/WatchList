<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\GitHubController;
use Illuminate\Http\Request;
use App\Http\Controllers\WorkController;

Route::get('/', [WorkController::class, 'index'])->name('home');
//Route::get('/', function () {
//    return view('welcome');
//});

// Тематические страницы
Route::get('/movies', [WorkController::class, 'movies'])->name('works.movies');
Route::get('/series', [WorkController::class, 'series'])->name('works.series');
Route::get('/games', [WorkController::class, 'games'])->name('works.games');
Route::get('/books', [WorkController::class, 'books'])->name('works.books');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// GitHub 
Route::get('/auth/github', [GitHubController::class, 'redirect'])->name('auth.github');
Route::get('/auth/github/callback', [GitHubController::class, 'callback']);

// JWT
Route::get('/dashboard', function (Request $request) {
    $user = $request->user();
    $token = $user->createToken('Watchlist Personal Access Token')->accessToken;

    return view('dashboard', [
        'apiToken' => $token
    ]);
})->middleware(['auth'])->name('dashboard');