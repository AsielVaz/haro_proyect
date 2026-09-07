<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AutoController;
use App\Http\Controllers\CatalogoController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GaleriaController;
use App\Http\Controllers\OperacionController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function (): void {
    Route::get('/login', [AuthController::class, 'create'])->name('login');
    Route::post('/login', [AuthController::class, 'store'])->name('login.store');
});

Route::middleware('haro.auth')->group(function (): void {
    Route::get('/', DashboardController::class)->name('dashboard');
    Route::post('/logout', [AuthController::class, 'destroy'])->name('logout');
    Route::resource('autos', AutoController::class);
    Route::patch('/autos/{auto}/pausa', [AutoController::class, 'togglePause'])->name('autos.pause');
    Route::patch('/autos/{auto}/banner', [AutoController::class, 'toggleBanner'])->name('autos.banner');
    Route::patch('/autos/{auto}/renovar', [AutoController::class, 'renew'])->name('autos.renew');
    Route::patch('/autos/{auto}/recuperar', [AutoController::class, 'restore'])->name('autos.restore');
    Route::get('/autos/{auto}/qr', [AutoController::class, 'qr'])->name('autos.qr');
    Route::patch('/autos/{auto}/portada/{imagen}', [AutoController::class, 'setCover'])->name('autos.cover');

    Route::get('/galeria', [GaleriaController::class, 'index'])->name('galeria.index');
    Route::post('/galeria', [GaleriaController::class, 'store'])->name('galeria.store');
    Route::patch('/galeria/asignaciones', [GaleriaController::class, 'assignBatch'])->name('galeria.assign-batch');
    Route::patch('/galeria/{imagen}/asignar', [GaleriaController::class, 'assign'])->name('galeria.assign');
    Route::delete('/galeria/{imagen}', [GaleriaController::class, 'destroy'])->name('galeria.destroy');

    Route::get('/catalogos', [CatalogoController::class, 'index'])->name('catalogos.index');
    Route::post('/catalogos/marcas', [CatalogoController::class, 'storeMarca'])->name('marcas.store');
    Route::delete('/catalogos/marcas/{marca}', [CatalogoController::class, 'destroyMarca'])->name('marcas.destroy');
    Route::post('/catalogos/modelos', [CatalogoController::class, 'storeModelo'])->name('modelos.store');
    Route::delete('/catalogos/modelos/{modelo}', [CatalogoController::class, 'destroyModelo'])->name('modelos.destroy');

    Route::get('/operaciones/{seccion}', [OperacionController::class, 'index'])->whereIn('seccion', ['clientes', 'ventas', 'pagos', 'almacenes', 'car-hunter', 'usuarios'])->name('operaciones.index');
    Route::post('/operaciones/{seccion}', [OperacionController::class, 'store'])->whereIn('seccion', ['clientes', 'ventas', 'pagos', 'almacenes', 'car-hunter', 'usuarios'])->name('operaciones.store');
    Route::patch('/operaciones/pagos/{pago}/aprobar', [OperacionController::class, 'approvePayment'])->name('pagos.approve');
    Route::patch('/operaciones/{seccion}/{registro}', [OperacionController::class, 'update'])->whereIn('seccion', ['clientes', 'almacenes', 'usuarios'])->whereNumber('registro')->name('operaciones.update');
    Route::delete('/operaciones/{seccion}/{registro}', [OperacionController::class, 'destroy'])->whereIn('seccion', ['clientes', 'almacenes', 'usuarios'])->whereNumber('registro')->name('operaciones.destroy');
});
