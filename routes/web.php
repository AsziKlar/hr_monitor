<?php

use App\Http\Controllers\AgencyController;
use App\Http\Controllers\AgencyMechanismPeriodController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DraftController;
use App\Http\Controllers\FieldOfficeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Models\AgencyMechanismPeriod;
use App\Models\Draft;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use App\Notifications\HRMOAccountCreated;

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


Route::middleware(['auth','prevent-back-history'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/mechanism', [DraftController::class, 'mechanism_filter'])->name('mechanisms');
    Route::get('/drafts/{id}', [DraftController::class, 'show'])->name('drafts.show');
    Route::post('/drafts/{id}/comment/store', [CommentController::class, 'store'])->name('drafts.comment.store');
    Route::patch('/comments/{comment}', [CommentController::class, 'update'])->name('comments.update');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

});

Route::middleware(['auth', 'prevent-back-history', 'role:Administrator'])->group(function () {
    
    Route::post('/admin/agency/store', [AgencyController::class, 'store'])->name('agency.store');
    
    Route::patch('/admin/agency/{agency}/update', [AgencyController::class, 'update'])->name('agency.update');

    Route::get('/admin/manage-account/index', [UserController::class, 'index'])->name('admin.account.index');
    Route::post('/admin/manage-account/store', [UserController::class, 'store'])->name('admin.account.store');

    Route::patch('/admin/profile', [UserController::class, 'admin_profile_update'])->name('admin.admin-profile.update');

    Route::get('/admin/other-settings/mechanism_filter', [AgencyMechanismPeriodController::class, 'mechanism_filter'])->name('admin.settings.mechanisms');
    Route::get('/admin/other-settings/{mechanism}/agencies', [AgencyMechanismPeriodController::class, 'agency_filter'])->name('admin.settings.agencies');
    Route::post('/admin/other-settings/{mechanism}/{agency}/mechanism-reset', [AgencyMechanismPeriodController::class, 'period_increment'])->name('admin.settings.period_increment');
    Route::post('/admin/other-settings/mechanism-reset/all//{mechanism}', [AgencyMechanismPeriodController::class, 'period_increment_all'])->name('admin.settings.period_increment_all');

    Route::get('/admin/field-office/index', [FieldOfficeController::class, 'field_office_index'])->name('admin.field-office.index');
    Route::patch('/admin/field-office/update/{agency}', [FieldOfficeController::class, 'field_office_update'])->name('admin.field-office.update');
    Route::patch('/admin/field-office/add', [FieldOfficeController::class, 'field_office_add'])->name('admin.field-office.add');

    Route::patch('/admin/manage-account/{user}/archive', [UserController::class, 'archive'])->name('admin.accounts.archive');
    Route::patch('/admin/manage-account/{user}/editAcc', [UserController::class, 'edit_acc_by_admin'])->name('admin.accounts.update');

    Route::delete('/announcements/{announcement}', [AnnouncementController::class, 'destroy'])->name('announcements.destroy');


   
});

Route::middleware(['auth', 'prevent-back-history','role:Administrator,Processor,Reviewer'])->group(function () {

    Route::get('/admin/agencies', [AgencyController::class, 'index'])->name('agencies.index');
    
    Route::get('/admin/agency/{agency}/show', [AgencyController::class, 'show'])->name('agency.show');

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

    Route::get('/agency/profile/show', [AgencyController::class, 'show_profile'])->name('agency.profile.show');
    Route::patch('/agency/profile/update', [AgencyController::class, 'update_profile'])->name('agency.profile.update');
    Route::patch('/hrmo/account/update', [UserController::class, 'hrmo_account_update'])->name('hrmo.account.update');

    Route::patch('/hrmo/self-archive', [UserController::class, 'self_archive_hrmo'])->name('hrmo.self-archive');
    
});









require __DIR__.'/auth.php';
