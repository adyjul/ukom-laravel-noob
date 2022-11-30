<?php

use App\Http\Controllers\Prodi\DashboardController;
use Illuminate\Support\Facades\Route;

Route::prefix('prodi')
    ->name('prodi.dashboard.')
    ->middleware(['auth', 'user_type:Prodi'])
    ->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('index');
    });
