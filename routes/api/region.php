<?php

use App\Http\Controllers\Api\RegionController;
use Illuminate\Support\Facades\Route;

Route::prefix('region')->name('api.region.')->middleware(['web', 'auth'])->group(function () {
    Route::get('province', [RegionController::class, 'province'])->name('get.province');
    Route::get('regency/{id}', [RegionController::class, 'regency'])->name('get.regency');
    Route::get('district/{id}', [RegionController::class, 'district'])->name('get.district');
    Route::get('village/{id}', [RegionController::class, 'villages'])->name('get.village');

    Route::get('select2/regency/{keyword?}', [RegionController::class, 'select2Regency'])->name('select2.regency');
});
