<?php

use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.dashboard.')->middleware(['auth', 'user_type:Admin'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('index');
});
