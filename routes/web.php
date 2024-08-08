<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\ComicController;
use App\Http\Controllers\ChapterController;
use App\Http\Controllers\PublisherController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SynopsisController;

Route::get('/', function () {
    return view('welcome');
});

// Resource routes for genres
Route::resource('genres', GenreController::class);
Route::resource('authors', AuthorController::class);
Route::resource('comics', ComicController::class);
Route::resource('chapters', ChapterController::class);
Route::resource('publishers', PublisherController::class);
Route::resource('reviews', ReviewController::class);
Route::resource('synopses', SynopsisController::class);



// Route for genre table, handled by GenreController
Route::get('/genre-table', [GenreController::class, 'index'])->name('genre.table');

// Route for creating genre, handled by GenreController
Route::get('/create-genre', [GenreController::class, 'create'])->name('genre.create');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
