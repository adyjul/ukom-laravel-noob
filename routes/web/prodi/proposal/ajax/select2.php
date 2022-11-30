<?php

use App\Http\Controllers\Prodi\Proposal\AjaxController;
use Illuminate\Support\Facades\Route;

Route::prefix('prodi/proposal/ajax')
    ->name('prodi.proposal.ajax.')
    // ->middleware(['auth'])
    ->group(function () {
        Route::prefix('select2')
            ->name('select2.')
            ->group(function () {
                Route::post('dosen', [AjaxController::class, 'dosenProdi'])->name('dosen.prodi');
                Route::post('dudi', [AjaxController::class, 'dudi'])->name('dudi');
                Route::post('kolaborator', [AjaxController::class, 'kolaborator'])->name('kolaborator');
            });
    });
