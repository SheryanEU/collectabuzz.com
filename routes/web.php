<?php

use App\Http\Controllers\CardController;
use App\Http\Controllers\PokemonController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SerieController;
use App\Http\Controllers\SetController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::post('/toggle-theme', function () {
    $theme = session('theme', 'dark') === 'dark' ? 'light' : 'dark';
    $color = session('theme', 'dark') === 'dark' ? 'black' : 'white';
    session(['theme' => $theme]);
    session(['color' => $color]);
    return response()->noContent();
});

Route::middleware('auth')->group(function () {
    // Pokemon
    Route::get('/pokedex', [PokemonController::class, 'browse'])->name('pokedex');
    Route::get('/api', [PokemonController::class, 'api'])->name('api');

    Route::get('/serie', [SerieController::class, 'browse'])->name('serie');
    Route::get('/serie/{serie:slug}', [SerieController::class, 'read'])->name('serie.set');
    Route::get('/serie/{serie:slug}/{set:slug}', [SetController::class, 'read'])->name('serie.set.read');

    Route::get('/set', [SetController::class, 'browse'])->name('set');
    Route::get('/set/{set:slug}', [SetController::class, 'read'])->name('set.read');

    Route::get('/card', [CardController::class, 'browse'])->name('card');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
