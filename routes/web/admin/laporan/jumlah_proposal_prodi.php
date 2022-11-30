<?php

use App\Http\Controllers\Admin\Laporan\JumlahProposalProdi;
use Illuminate\Support\Facades\Route;

Route::prefix('admin/laporan/jumlah-proposal-prodi')->name('admin.laporan.jumlah-proposal-prodi.')->middleware(['auth', 'user_type:Admin'])->group(function () {
    Route::middleware(['permission:Lihat-Laporan'])->group(function () {
        Route::get('/', [JumlahProposalProdi::class, 'index'])->name('index');
        // Route::get('get/count/by/year/{year}', [JumlahProposalProdi::class, 'getCountByYear'])->name('get.count.by.year');
        Route::get('year/{year}/data/has-been-upload', [JumlahProposalProdi::class, 'hasBeenUpload'])->name('has.been.upload');
        Route::get('year/{year}/data/not-upload-yet', [JumlahProposalProdi::class, 'notUploadYet'])->name('not.upload.yet');
        Route::get('data/year/{year}/validation-status/{valdiation_status}', [JumlahProposalProdi::class, 'getDataByValidationStatus'])->name('get.data.by.validation.status');
        Route::get('data/year/{year}/category/{category}', [JumlahProposalProdi::class, 'getDataByCategory'])->name('get.data.by.category');
    });
});
