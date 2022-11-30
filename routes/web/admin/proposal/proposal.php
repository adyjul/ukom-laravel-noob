<?php

use App\Http\Controllers\Admin\Proposal\ProposalController;
use Illuminate\Support\Facades\Route;

$permission = "Validasi-Proposal";

Route::prefix('admin/proposal')
    ->name('admin.proposal.')
    ->middleware(['auth', 'user_type:Admin', 'permission:' . $permission])
    ->group(function () {
        Route::get('/', [ProposalController::class, 'index'])->name('index');
        Route::get('show/{id}', [ProposalController::class, 'show'])->name('show');

        Route::post('{id}/update/status', [ProposalController::class, 'updateStatus'])->name('update.status');
    });
