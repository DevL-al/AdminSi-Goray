<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\RegulerController;
use App\Http\Controllers\Admin\PemesananController;
use App\Http\Controllers\Admin\PembayaranController;

Route::get('/', function () {
    return view('welcome');
});


Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::get('/reguler', [RegulerController::class, 'index'])
        ->name('reguler.index');

    Route::get('/reguler/{date}/edit', [RegulerController::class, 'edit'])
        ->name('reguler.edit');

    Route::put('/reguler/{date}', [RegulerController::class, 'update'])
        ->name('reguler.update');

    Route::get('/pemesanan', [PemesananController::class, 'index'])
        ->name('pemesanan.index');

    Route::get('/pemesanan/{bookingCode}', [PemesananController::class, 'show'])
        ->name('pemesanan.show');

    Route::get('/pembayaran', [PembayaranController::class, 'index'])
        ->name('payment.pembayaran');

    Route::get('/pembayaran/{id}', [PembayaranController::class, 'show'])
        ->name('payment.show');
});
