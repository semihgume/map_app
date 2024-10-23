<?php

use App\Http\Controllers\LocationController;
use Illuminate\Support\Facades\Route;

Route::prefix('locations')->middleware('throttle:30,1')->group(function () {
    Route::get('/', [LocationController::class, 'index'])->name('locations.index'); // Konumları Listele
    Route::get('/create', [LocationController::class, 'create'])->name('locations.create'); // Yeni Konum Ekleme Sayfası
    Route::post('/', [LocationController::class, 'store'])->name('locations.store'); // Yeni Konumu Kaydet
    Route::get('/routing', [LocationController::class, 'routing'])->name('locations.routing'); // Rota Çizme
    Route::get('/{id}', [LocationController::class, 'show'])->name('locations.show'); // Konum Detay
    Route::get('/{id}/edit', [LocationController::class, 'edit'])->name('locations.edit'); // Konum Güncelleme Sayfası
    Route::put('/{id}', [LocationController::class, 'update'])->name('locations.update'); // Konumu Güncelle
});