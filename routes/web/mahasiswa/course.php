<?php

use App\Http\Controllers\Mahasiswa\CourseController;
use Illuminate\Support\Facades\Route;

Route::prefix('mahasiswa/course')->name('mahasiswa.course.')->middleware(['auth:web,mahasiswa_umm', 'user_type:Mahasiswa,Umum', 'mahasiswa_data_is_complete'])->group(function () {
    Route::post('/register', [CourseController::class, 'register'])->name('register');
});
