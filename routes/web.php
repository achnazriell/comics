<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\ComicController;
use App\Http\Controllers\ChapterController;
use App\Http\Controllers\PublisherController;
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
    Route::resource('synopses', SynopsisController::class);

});

// Dashboard route with middleware
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard')
    ->middleware(['auth', 'verified']);
// Profile routes with authentication middleware
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update'); //patch unutuk update tapi hanya sebagian yang di update
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Authentication routes
require __DIR__ . '/auth.php';
