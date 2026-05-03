<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DraftController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/drafts', [DraftController::class, 'index'])->name('drafts.index');
Route::get('/drafts/create', [DraftController::class, 'create']);
Route::post('/drafts', [DraftController::class, 'store']);
Route::get('/drafts/{id}', [DraftController::class, 'show'])->name('drafts.show');


require __DIR__.'/auth.php';
