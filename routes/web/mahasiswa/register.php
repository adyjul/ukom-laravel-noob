<?php

use App\Http\Controllers\Mahasiswa\Auth\RegistrationController;
use Illuminate\Support\Facades\Route;

Route::prefix('mahasiswa/')->name('mahasiswa.')->group(function () {
    Route::prefix('register/')->name('register.')->middleware(['guest'])->group(function () {
        Route::get('/', [RegistrationController::class, 'index'])->name('index');
        Route::post('/', [RegistrationController::class, 'store'])->name('store');
    });
});
