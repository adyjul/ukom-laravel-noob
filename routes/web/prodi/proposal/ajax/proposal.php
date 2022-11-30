<?php

use App\Http\Controllers\Prodi\ProposalController;
use App\Http\Controllers\Prodi\Proposal\AjaxController;
use App\Http\Controllers\Prodi\Proposal\DatatableController;
use App\Http\Controllers\Prodi\Proposal\DeleteController;
use App\Http\Controllers\Prodi\Proposal\InsertDetailController;
use App\Http\Controllers\Prodi\Proposal\UpdateController;
use Illuminate\Support\Facades\Route;

Route::prefix('prodi/proposal/ajax/')
    ->name('prodi.proposal.ajax')
    ->middleware(['auth'])
    ->group(function () {
        $permission = "Prodi_Menu_Proposal";
        Route::prefix('store')
            ->name('store.')
            ->middleware('permission:create ' . $permission)
            ->group(function () {
                // store file proposal dan rps
                Route::post('/file/proposal', [InsertDetailController::class, 'storeDataProposal'])->name('file.proposal');

                // store dosen
                Route::post('/dosen', [InsertDetailController::class, 'storeDosen'])->name('dosen');

                // store dudi
                Route::post('/dudi', [InsertDetailController::class, 'storeDudi'])->name('dudi');

                // store dosen praktisi
                Route::post('/dosen-praktisi', [InsertDetailController::class, 'storeDosenPraktisi'])->name('dosen.praktisi');

                // store kolaborator
                Route::post('/kolaborator', [InsertDetailController::class, 'storeKolaborator'])->name('kolaborator');
            });

        Route::prefix('delete')
            ->name('delete.')
            ->middleware('permission:create ' . $permission)
            ->group(function () {
                // delete dosen
                Route::post('/dosen', [DeleteController::class, 'deleteDosen'])->name('dosen');

                // delete dudi
                Route::post('/dudi', [DeleteController::class, 'deleteDudi'])->name('dudi');

                // delete dosen
                Route::post('/dosen-praktisi', [DeleteController::class, 'deleteDosenPraktisi'])->name('dosen.praktisi');

                // delete kolaborator
                Route::post('/kolaborator', [DeleteController::class, 'deleteKolaborator'])->name('kolaborator');
            });

        Route::prefix('datatable')
            ->name('datatable.')
            ->group(function () {
                // datatable dosen
                Route::get('/{proposal_id}/dosen', [DatatableController::class, 'dosen'])->name('dosen');

                // datatable dudi
                Route::get('/{proposal_id}/dudi', [DatatableController::class, 'dudi'])->name('dudi');

                // datatable dosen praktisi
                Route::get('/{proposal_id}/dosen-praktisi', [DatatableController::class, 'dosenPraktisi'])->name('dosen.praktisi');

                // datatable kolaborator per proposal
                Route::get('/{proposal_id}/kolaborator', [DatatableController::class, 'kolaborator'])->name('kolaborator');

                // datatable proposals invited as colaborator
                Route::get('/kolaborator', [DatatableController::class, 'listCollabProposal'])->name('list.collab.proposal');
        });

        Route::prefix('detail')
            ->name('detail.')
            ->group(function () {
                // detail dosen praktisi
                Route::get('/dosen-praktisi/{id}', [AjaxController::class, 'detailDosenPraktisi'])->name('dosen.praktisi');
                Route::get('/pendaftar/{id}', [AjaxController::class, 'detailPendaftar'])->name('pendaftar');
            });

        Route::prefix('update')
            ->name('update.')
            ->middleware('permission:create ' . $permission)
            ->group(function () {
                // update dosen praktisi
                Route::put('/dosen-praktisi', [UpdateController::class, 'updateDosenPraktisi'])->name('dosen.praktisi');

                Route::post('update/registration-config', [ProposalController::class, 'updateDeskripsikelas'])->name('deskripsi.proposal');
            });
    });
