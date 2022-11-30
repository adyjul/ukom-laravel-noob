<?php

use App\Http\Controllers\Prodi\Course\CourseController;
use App\Models\Master\Course;
use Illuminate\Support\Facades\Route;

Route::prefix('prodi/course')
    ->name('prodi.course.')->middleware(['auth', 'user_type:Prodi'])->group(function () {
        $permission = "Prodi_Menu_Course";

        //Course
        Route::middleware(['permission:view ' . $permission])->group(function () {
            Route::get('/', [CourseController::class, 'index'])->name('index');
            Route::get('/show/{id}', [CourseController::class, 'showById'])->name('show');
        });

        Route::middleware(['permission:update ' . $permission])->group(function () {

            Route::get('user/{id}/registration/accept', [CourseController::class, 'userRegistrationAccept'])->name('user.registration.accept');
            Route::get('user/{id}/registration/reject', [CourseController::class, 'userRegistrationReject'])->name('user.registration.reject');

            Route::post('user/batch/registration/accept/{id}', [CourseController::class, 'userBatchRegistrationAccept'])->name('user.batch.registration.accept');
            Route::post('user/batch/registration/reject/{id}', [CourseController::class, 'userBatchRegistrationReject'])->name('user.batch.registration.reject');
        });

        Route::middleware(['permission:delete ' . $permission])->group(function () {
            Route::delete('delete/{id}', [CourseController::class, 'deleteById'])->name('delete');
        });

    });
