<?php

use App\Http\Controllers\Admin\Master\AnnouncementController;
use Illuminate\Support\Facades\Route;

$permission = "master_announcement";
Route::prefix('admin/master')->name('admin.master.')->middleware(['auth', 'user_type:Admin'])->group(function () use ($permission) {
    Route::prefix('pengumuman')->name('announcement.')->group(function () use ($permission) {
        Route::middleware(['permission:view ' . $permission])->group(function () {
            Route::get('/', [AnnouncementController::class, 'index'])->name('index');
            Route::get('show/{id}', [AnnouncementController::class, 'show'])->name('show');
        });
        Route::middleware(['permission:update ' . $permission])->group(function () {
            Route::get('edit/{id}', [AnnouncementController::class, 'edit'])->name('edit');
            Route::post('update/{id}', [AnnouncementController::class, 'update'])->name('update');
        });
        Route::middleware(['permission:delete ' . $permission])->group(function () {
            Route::delete('delete', [AnnouncementController::class, 'delete'])->name('delete');
        });
        Route::middleware(['permission:restore ' . $permission])->group(function () {
            Route::delete('restore', [AnnouncementController::class, 'restore'])->name('restore');
        });
        Route::middleware(['permission:create ' . $permission])->group(function () {
            Route::get('create', [AnnouncementController::class, 'createGet'])->name('createGet');
            Route::post('create', [AnnouncementController::class, 'createPost'])->name('createPost');
        });
    });
});
