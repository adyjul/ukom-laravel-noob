<?php

use App\Http\Controllers\Prodi\Course\UpdateController;
use App\Http\Controllers\Prodi\Course\CourseController;
use App\Http\Controllers\Prodi\Course\DatatableController;
use App\Http\Controllers\Prodi\Course\DeleteDataControler;
use App\Http\Controllers\Prodi\Course\InsertDataAjaxController;
use App\Http\Controllers\Prodi\Course\Select2Controller;
use Illuminate\Support\Facades\Route;


Route::prefix('admin/course/ajax/')->name('admin.course.ajax.')->middleware(['auth','user_type:Admin'])->group(function () {

    $permission = "Admin_Menu_Course";


    Route::prefix('datatable')->name('datatable.')->group(function () {
        // datatable dosen
        Route::get('/{course_id}/dosen', [DatatableController::class, 'dosen'])->name('dosen');

        // datatable dudi
        Route::get('/{course_id}/dudi', [DatatableController::class, 'dudi'])->name('dudi');

        // datatable dosen praktisi
        Route::get('/{course_id}/dosen-dudi', [DatatableController::class, 'dosenDudi'])->name('dosen.dudi');
    });


});
