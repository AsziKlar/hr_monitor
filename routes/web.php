<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DraftController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('admin.dashboard');
    }

    return view('auth.login');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



Route::middleware(['auth', 'prevent-back-history','role:Administrator,Processor,Reviewer'])->group(function () {
   
    Route::get('/admin/dashboard', [DashboardController::class, 'index_admin'])->name('admin.dashboard');
    

});


Route::middleware(['auth', 'prevent-back-history', 'role:HRMO'])->group( function () {
    Route::get('/drafts', [DraftController::class, 'index'])->name('drafts.index');
    Route::get('/drafts/create/{mechanism}', [DraftController::class, 'create'])->name('drafts.create');
    Route::post('/drafts', [DraftController::class, 'store'])->name('drafts.store');
    Route::get('/drafts/{id}', [DraftController::class, 'show'])->name('drafts.show');
});









require __DIR__.'/auth.php';
