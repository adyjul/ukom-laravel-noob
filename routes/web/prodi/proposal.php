<?php

use App\Http\Controllers\Prodi\ProposalController;
use Illuminate\Support\Facades\Route;

Route::prefix('prodi/proposal')
    ->name('prodi.proposal.')->middleware(['auth', 'user_type:Prodi'])->group(function () {
        $permission = "Prodi_Menu_Proposal";

        //proposal saya view
        Route::middleware(['permission:view ' . $permission])->group(function () {
            Route::get('/', [ProposalController::class, 'index'])->name('index');
            Route::get('show/{id}', [ProposalController::class, 'show'])->name('show');
            Route::get('showProposal/{id}', [ProposalController::class, 'noticeView'])->name('noticeView');
            Route::get('download/pdf/{id}', [ProposalController::class, 'createPDF'])->name('createPDF');
        });

        //proposal kolaborator
        Route::middleware(['permission:view ' . $permission])->group(function () {
            Route::get('/kolaborator/{id}', [ProposalController::class, 'kolaborator'])->name('kolaborator.view');

        });


        Route::middleware(['permission:create ' . $permission])->group(function () {
            Route::post('storeName', [ProposalController::class, 'storeName'])->name('storeName');
            Route::get('create', [ProposalController::class, 'create'])->name('create');
            Route::post('store', [ProposalController::class, 'store'])->name('store');
        });

        Route::middleware(['permission:update ' . $permission])->group(function () {
            Route::get('edit/{id}', [ProposalController::class, 'edit'])->name('edit');
            Route::put('update/{id}', [ProposalController::class, 'update'])->name('update');
            Route::put('updateName/{id}', [ProposalController::class, 'updateName'])->name('updateName');

            Route::get('user/{id}/registration/accept', [ProposalController::class, 'userRegistrationAccept'])->name('user.registration.accept');
            Route::get('user/{id}/registration/reject', [ProposalController::class, 'userRegistrationReject'])->name('user.registration.reject');

            Route::post('user/batch/registration/accept/{id}', [ProposalController::class, 'userBatchRegistrationAccept'])->name('user.batch.registration.accept');
            Route::post('user/batch/registration/reject/{id}', [ProposalController::class, 'userBatchRegistrationReject'])->name('user.batch.registration.reject');
        });

        Route::middleware(['permission:delete ' . $permission])->group(function () {
            Route::delete('delete/{id}', [ProposalController::class, 'delete'])->name('delete');
        });

        Route::middleware(['permission:restore ' . $permission])->group(function () {
            Route::delete('restore/{id}', [ProposalController::class, 'restore'])->name('restore');
        });
    });
