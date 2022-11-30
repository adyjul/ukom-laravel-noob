<?php

use App\Http\Controllers\Prodi\Course\UpdateController;
use App\Http\Controllers\Prodi\Course\CourseController;
use App\Http\Controllers\Prodi\Course\DatatableController;
use App\Http\Controllers\Prodi\Course\DeleteDataControler;
use App\Http\Controllers\Prodi\Course\InsertDataAjaxController;
use App\Http\Controllers\Prodi\Course\Select2Controller;
use Illuminate\Support\Facades\Route;


Route::prefix('prodi/course/ajax/')->name('prodi.course.ajax.')->middleware(['auth','user_type:Prodi'])->group(function () {

    $permission = "Prodi_Menu_Course";


    Route::prefix('store')->name('store.')->middleware('permission:create ' . $permission)->group(function () {
        Route::post('/nameCourse', [CourseController::class, 'storeNameCourse'])->name('nameCourse');
        Route::post('/courseValidation', [CourseController::class, 'storeCourseValidation'])->name('courseValidation');
        Route::post('/courseDetail', [CourseController::class, 'storeDetailCourse'])->name('courseDetail');

        // store dosen
        Route::post('/dosen', [InsertDataAjaxController::class, 'storeDosen'])->name('dosen');

        // store dudi
        Route::post('/dudi', [InsertDataAjaxController::class, 'storeDudi'])->name('dudi');

        // store dosen praktisi
        Route::post('/dosen-dudi', [InsertDataAjaxController::class, 'storeDosenDudi'])->name('dosen.dudi');

    });

    Route::prefix('datatable')->name('datatable.')->group(function () {
        // datatable dosen
        Route::get('/{course_id}/dosen', [DatatableController::class, 'dosen'])->name('dosen');

        // datatable dudi
        Route::get('/{course_id}/dudi', [DatatableController::class, 'dudi'])->name('dudi');

        // datatable dosen praktisi
        Route::get('/{course_id}/dosen-dudi', [DatatableController::class, 'dosenDudi'])->name('dosen.dudi');
    });


    Route::prefix('select2')->name('select2.')->group(function () {
        Route::post('dosen', [Select2Controller::class, 'dosenProdi'])->name('dosen.prodi');
        Route::post('dudi', [Select2Controller::class, 'dudi'])->name('dudi');
    });


    Route::prefix('update')->name('update.')->middleware('permission:create ' . $permission)->group(function () {
        // update dosen praktisi
        Route::post('/dosen-dudi', [UpdateController::class, 'updateDosenDudi'])->name('dosen.dudi');

    });


    Route::prefix('delete')->name('delete.')->middleware('permission:create ' . $permission)->group(function () {
        // delete dosen
        Route::post('/dosen', [DeleteDataControler::class, 'deleteDosen'])->name('dosen');

        // delete dudi
        Route::post('/dudi', [DeleteDataControler::class, 'deleteDudi'])->name('dudi');

        // delete dosen
        Route::post('/dosen-dudi', [DeleteDataControler::class, 'deleteDosenDudi'])->name('dosen.dudi');

    });

    Route::prefix('detail')->name('detail.')->group(function () {
        // detail dosen praktisi
        Route::get('/dosen-dudi/{id}', [CourseController::class, 'detailDosenDudi'])->name('dosen.dudi');
    });



});
