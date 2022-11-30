<?php

use App\Http\Controllers\Prodi\DudiController;
use Illuminate\Support\Facades\Route;

Route::prefix('prodi/dudi')
    ->name('prodi.dudi.')
    ->middleware(['auth', 'user_type:Prodi'])
    ->group(function () {
        $permission = "Prodi_Menu_Proposal";
        Route::middleware(['permission:view ' . $permission])->group(function () {
            Route::get('/', [DudiController::class, 'index'])->name('index');
            Route::get('show/{id}', [DudiController::class, 'show'])->name('show');
        });

        Route::middleware(['permission:create ' . $permission])->group(function () {
            Route::get('create', [DudiController::class, 'create'])->name('create');
            Route::post('store', [DudiController::class, 'store'])->name('store');
        });

        Route::middleware(['permission:update ' . $permission])->group(function () {
            Route::get('edit/{id}', [DudiController::class, 'edit'])->name('edit');
            Route::put('update/{id}', [DudiController::class, 'update'])->name('update');
        });

        Route::middleware(['permission:delete ' . $permission])->group(function () {
            Route::delete('delete', [DudiController::class, 'delete'])->name('delete');
        });

        Route::middleware(['permission:restore ' . $permission])->group(function () {
            Route::delete('restore', [DudiController::class, 'restore'])->name('restore');
        });
    });
