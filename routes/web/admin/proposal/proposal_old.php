<?php

use App\Http\Controllers\Admin\Proposal\ProposalController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin/proposal')
    ->name('admin.proposal.')
    ->middleware(['auth', 'user_type:Admin', 'permission:Validasi-Proposal'])
    ->group(function () {
        Route::get('/', [ProposalController::class, 'index'])->name('index');
        Route::get('show/{id}', [ProposalController::class, 'show'])->name('show');
        Route::get('edit/{id}', [ProposalController::class, 'edit'])->name('edit');
        Route::put('update/{id}', [ProposalController::class, 'update'])->name('update');

        Route::put('validation', [ProposalController::class, 'validation'])->name('validation');
    });
