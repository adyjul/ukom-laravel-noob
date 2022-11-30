<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;


Route::prefix('auth/register')->middleware(['guest'])->name('auth.register.')->group(function () {
    Route::get('/', [RegisterController::class, 'index'])->name('get.index');
    Route::post('/', [RegisterController::class, 'store'])->name('post.store');
});
