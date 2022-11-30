<?php

use App\Http\Controllers\Admin\Master\SliderController;
use Illuminate\Support\Facades\Route;

$permission = "master_slider";
Route::prefix('admin/master')->name('admin.master.')->middleware(['auth', 'user_type:Admin'])->group(function () use ($permission) {
    Route::prefix('slider')->name('slider.')->group(function () use ($permission) {
        Route::middleware(['permission:view ' . $permission])->group(function () {
            Route::get('/', [SliderController::class, 'index'])->name('index');
            Route::get('show/{id}', [SliderController::class, 'show'])->name('show');
        });
        Route::middleware(['permission:update ' . $permission])->group(function () {
            Route::get('edit/{id}', [SliderController::class, 'edit'])->name('edit');
            Route::post('update/{id}', [SliderController::class, 'update'])->name('update');
        });
        Route::middleware(['permission:delete ' . $permission])->group(function () {
            Route::delete('delete', [SliderController::class, 'delete'])->name('delete');
        });
        Route::middleware(['permission:restore ' . $permission])->group(function () {
            Route::delete('restore', [SliderController::class, 'restore'])->name('restore');
        });
        Route::middleware(['permission:create ' . $permission])->group(function () {
            Route::get('create', [SliderController::class, 'createGet'])->name('createGet');
            Route::post('create', [SliderController::class, 'createPost'])->name('createPost');
        });
    });
});
