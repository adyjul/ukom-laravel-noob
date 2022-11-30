<?php

use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\PengumumanController;
use App\Http\Controllers\Frontend\DownloadController;
use App\Http\Controllers\Frontend\KurikulumController;
use App\Http\Controllers\Frontend\AlurController;
use App\Http\Controllers\Frontend\ProposalController;
use App\Http\Controllers\Frontend\ClassController;
use Illuminate\Support\Facades\Route;

Route::prefix('/')->name('home.')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('index');
    Route::get('/pengumuman', [PengumumanController::class, 'index'])->name('pengumuman');
    Route::get('/pengumuman/{id}', [PengumumanController::class, 'getDetailPengumuman'])->name('pengumuman.detail');
    Route::get('/download', [DownloadController::class, 'index'])->name('download');
    Route::get('/kurikulum', [KurikulumController::class, 'index'])->name('kurikulum');
    Route::get('/alur', [AlurController::class, 'index'])->name('alur');
    Route::middleware(['auth:web,mahasiswa_umm'])->group(function () {
        Route::get('/proposal', [ProposalController::class, 'index'])->name('proposal');
        Route::get('/course', [ProposalController::class, 'getCourse'])->name('getCourse');
        Route::get('/course/{id}', [ProposalController::class, 'detailCourse'])->name('course.detail');
        Route::get('/proposal/{id}', [ProposalController::class, 'detail'])->name('proposal.detail');
        Route::get('/proposal/detail/{id}', [ProposalController::class, 'detail_sementara'])->name('proposal.detail.sementara');
    });

    Route::middleware(['auth:web,mahasiswa_umm', 'user_type:Mahasiswa,Umum', 'mahasiswa_data_is_complete'])->group(function () {
        Route::get('/class', [ClassController::class, 'index'])->name('kelas');
    });
});
