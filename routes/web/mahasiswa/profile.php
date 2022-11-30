<?php

use App\Http\Controllers\Frontend\ProfileController;
use Illuminate\Support\Facades\Route;

Route::prefix('mahasiswa/profile')->name('mahasiswa.profile.')->middleware(['auth', 'user_type:Mahasiswa,Umum'])->group(function () {
    Route::GET('/', [ProfileController::class, 'index'])->name('index');
    Route::post('change/password', [ProfileController::class, 'changePassword'])->name('change.password');
});
