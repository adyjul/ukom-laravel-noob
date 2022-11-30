<?php

use App\Http\Controllers\Admin\Course\CourseController;
use Illuminate\Support\Facades\Route;

$permission = "Validasi_Course";

Route::prefix('admin/course')
    ->name('admin.course.')
    ->middleware(['auth', 'user_type:Admin', 'permission:' . $permission])
    ->group(function () {
        Route::get('/', [CourseController::class, 'index'])->name('index');
        Route::get('show/{id}', [CourseController::class, 'showById'])->name('show');
        Route::post('update/status', [CourseController::class, 'updateStatus'])->name('update.status');

    });
