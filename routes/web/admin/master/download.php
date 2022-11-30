<?php

use App\Http\Controllers\Admin\Master\DownloadController;
use Illuminate\Support\Facades\Route;

$permission = "master_download";
Route::prefix('admin/master')->name('admin.master.')->middleware(['auth', 'user_type:Admin'])->group(function () use ($permission) {
    Route::prefix('download')->name('download.')->group(function () use ($permission) {
        Route::middleware(['permission:view ' . $permission])->group(function () {
            Route::get('/', [DownloadController::class, 'index'])->name('index');
            Route::get('show/{id}', [DownloadController::class, 'show'])->name('show');
        });
        Route::middleware(['permission:update ' . $permission])->group(function () {
            Route::get('edit/{id}', [DownloadController::class, 'edit'])->name('edit');
            Route::post('update/{id}', [DownloadController::class, 'update'])->name('update');
        });
        Route::middleware(['permission:delete ' . $permission])->group(function () {
            Route::delete('delete', [DownloadController::class, 'delete'])->name('delete');
        });
        Route::middleware(['permission:restore ' . $permission])->group(function () {
            Route::delete('restore', [DownloadController::class, 'restore'])->name('restore');
        });
        Route::middleware(['permission:create ' . $permission])->group(function () {
            Route::get('create', [DownloadController::class, 'createGet'])->name('createGet');
            Route::post('create', [DownloadController::class, 'createPost'])->name('createPost');
        });
    });
});
