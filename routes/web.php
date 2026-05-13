<?php

use App\Http\Controllers\AgencyController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DraftController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\UserController;
use App\Models\Draft;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check()) {
        if (auth()->user()->role->id === 4){
            return redirect()->route('hrmo.dashboard');
        }else {
            return redirect()->route('dashboard');
        }
    }

    return view('auth.login');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth','prevent-back-history'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/mechanism', [DraftController::class, 'mechanism_filter'])->name('mechanisms');
    Route::get('/drafts/{id}', [DraftController::class, 'show'])->name('drafts.show');
});

Route::middleware(['auth', 'prevent-back-history', 'role:Administrator'])->group(function () {
    Route::get('/admin/agencies', [AgencyController::class, 'index'])->name('agencies.index');
    Route::post('/admin/agency/store', [AgencyController::class, 'store'])->name('agency.store');
    Route::get('/admin/agency/{agency}/show', [AgencyController::class, 'show'])->name('agency.show');
    Route::patch('/admin/agency/{agency}/update', [AgencyController::class, 'update'])->name('agency.update');

    Route::get('/admin/manage-account/index', [UserController::class, 'index'])->name('admin.account.index');
});

Route::middleware(['auth', 'prevent-back-history','role:Administrator,Processor,Reviewer'])->group(function () {
   
    Route::get('/admin/dashboard', [DashboardController::class, 'index_admin'])->name('dashboard');
    Route::get('/admin/announcements', [AnnouncementController::class, 'index'])->name('announcements');
    Route::post('/admin/announcements/store', [AnnouncementController::class, 'store'])->name('store.announcements');
    // Route::get('/admin/statuses/{mechanism}', [DraftController::class, 'status_filter'])->name('admin.statuses');
    Route::get('/admin/drafts/{mechanism}/index', [DraftController::class, 'index_admin'])->name('admin.drafts.index');

    // Route::get('admin/drafts/{status}/{mechanism}', [DraftController::class, 'index_by_status'])->name('admin.drafts.index');


    Route::get('/admin/draft/{id}', [DraftController::class, 'show'])->name('admin.drafts.show');
    Route::patch('/admin/approve/{id}', [DraftController::class, 'approve'])->name('draft.approve');
    Route::patch('/admin/revision/{id}', [DraftController::class, 'revision'])->name('draft.revision');
    

});



Route::middleware(['auth', 'prevent-back-history', 'role:HRMO'])->group( function () {
    Route::get('/agency/dashboard', [DashboardController::class, 'index_hrmo'])->name('hrmo.dashboard');
    Route::get('/drafts/index/{mechanism}', [DraftController::class, 'index_hrmo'])->name('hrmo.drafts.index');
    Route::get('/drafts/create/{mechanism}', [DraftController::class, 'create'])->name('drafts.create');
    

    Route::post('/drafts/store', [DraftController::class, 'store'])->name('drafts.store');

    Route::patch('/drafts/update/{draft}', [DraftController::class, 'updateFile'])->name('draft.update');
});









require __DIR__.'/auth.php';
