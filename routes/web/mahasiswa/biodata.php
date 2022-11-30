<?php

use App\Http\Controllers\Mahasiswa\Biodata\BiodataController;
use Illuminate\Support\Facades\Route;

Route::prefix('mahasiswa/biodata')->name('mahasiswa.biodata.')->middleware(['auth', 'user_type:Mahasiswa,Umum'])->group(function () {
    Route::get('/', [BiodataController::class, 'index'])->name('index');
    Route::post('/', [BiodataController::class, 'store'])->name('store');
    Route::post('/store_umum', [BiodataController::class, 'store_umum'])->name('store_umum');
});
