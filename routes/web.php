<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\ComicController;
use App\Http\Controllers\ChapterController;
use App\Http\Controllers\PublisherController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SynopsisController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ComicWizardController;


// Public routes
Route::get('/', function () {
    return view('welcome');
});

// Resource routes with authentication middleware
Route::middleware('auth')->group(function () {
    Route::resource('genres', GenreController::class);
    Route::resource('authors', AuthorController::class);
    Route::resource('comics', ComicController::class);
    Route::resource('chapters', ChapterController::class);
    Route::resource('publishers', PublisherController::class);
    Route::resource('reviews', ReviewController::class);
    Route::resource('synopses', SynopsisController::class);

    // Additional routes that need authentication
    Route::get('/genre-table', [GenreController::class, 'index'])->name('genre.table');
    Route::get('/create-genre', [GenreController::class, 'create'])->name('genre.create');


    
    Route::get('/comics/{comic}', [ComicController::class, 'show'])->name('comics.show');
    Route::get('/chapters/{chapter}', [ChapterController::class, 'show'])->name('chapters.show');

    Route::get('/comics/{comic}/review', [ReviewController::class, 'create'])->name('review.create');
    Route::post('/comics/{comic}/review', [ReviewController::class, 'store'])->name('review.store');
});

// Dashboard route with middleware
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard')
    ->middleware(['auth', 'verified']);

// Profile routes with authentication middleware
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// Authentication routes
require __DIR__.'/auth.php';
