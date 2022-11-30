<?php

use App\Http\Controllers\Frontend\ProfileController;
use Illuminate\Support\Facades\Route;

Route::prefix('mahasiswa/profile_umm')->name('mahasiswa.profile_umm.')->group(function () {
    Route::GET('/mahasiswa_umm', [ProfileController::class, 'mahasiswa_umm'])->name('umm');
});
