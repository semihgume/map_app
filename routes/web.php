<?php

use App\Http\Controllers\LocationController;
use Illuminate\Support\Facades\Route;


Route::prefix('locations')->group(function () {
    Route::get('/create', [LocationController::class, 'create'])->name('locations.create');
    Route::get('/', [LocationController::class, 'index'])->name('locations.index');
    Route::post('/', [LocationController::class, 'store'])->name('locations.store');
    Route::get('/{id}', [LocationController::class, 'show'])->name('locations.show');
});