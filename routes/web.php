<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnimeController;
use App\Http\Controllers\AnimeBrowseController;

// The main watch list page
Route::get('/', [AnimeController::class, 'index'])->name('anime-board.index');
Route::get('/browse', [AnimeBrowseController::class, 'index'])->name('anime-board.browse');
Route::post('/', [AnimeController::class, 'store'])->name('anime-board.store');
Route::put('/anime/{anime}', [AnimeController::class, 'update'])->name('anime-board.update');
Route::delete('/anime/{anime}', [AnimeController::class, 'destroy'])->name('anime-board.destroy');
Route::post('/anime/reorder', [AnimeController::class, 'reorder'])->name('anime-board.reorder');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
