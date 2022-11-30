<?php

use App\Http\Controllers\Mahasiswa\ProposalController;
use Illuminate\Support\Facades\Route;

Route::prefix('mahasiswa/proposal')->name('mahasiswa.proposal.')->middleware(['auth:web,mahasiswa_umm', 'user_type:Mahasiswa,Umum', 'mahasiswa_data_is_complete'])->group(function () {
    Route::post('/register', [ProposalController::class, 'register'])->name('register');
});
