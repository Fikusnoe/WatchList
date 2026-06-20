<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\GitHubController;
use Illuminate\Http\Request;
use App\Http\Controllers\WorkController;

// Главная страница
Route::get('/', [WorkController::class, 'index'])->name('home');
//Route::get('/', function () {
//    return view('welcome');
//});

// Тематические страницы
Route::get('/movies', [WorkController::class, 'movies'])->name('works.movies');
Route::get('/series', [WorkController::class, 'series'])->name('works.series');
Route::get('/games', [WorkController::class, 'games'])->name('works.games');
Route::get('/books', [WorkController::class, 'books'])->name('works.books');

// Каталог всех произведений
Route::prefix('catalog')->name('catalog.')->group(function () {
    // Страница выбора
    Route::get('/', [WorkController::class, 'catalogIndex'])->name('index');

    // Подразделы каталога со списками
    Route::get('/movies', [WorkController::class, 'catalogMovies'])->name('movies');
    Route::get('/series', [WorkController::class, 'catalogSeries'])->name('series');
    Route::get('/games', [WorkController::class, 'catalogGames'])->name('games');
    Route::get('/books', [WorkController::class, 'catalogBooks'])->name('books');
});

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