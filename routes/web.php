<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DataController;
use App\Http\Controllers\PrediksiController;
use App\Http\Controllers\LaporanController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect('/dashboard');
});

/*
|--------------------------------------------------------------------------
| Route yang harus login
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    // Dashboard Apotek
    Route::get(
        '/dashboard',
        [DashboardController::class, 'index']
    )->name('dashboard');

    // Manajemen Data
    Route::get(
        '/manajemen-data',
        [DataController::class, 'index']
    );

    Route::get(
        '/manajemen-data/create',
        [DataController::class, 'create']
    );

    Route::post(
        '/manajemen-data/store',
        [DataController::class, 'store']
    );

    Route::get(
        '/manajemen-data/edit/{id}',
        [DataController::class, 'edit']
    );

    Route::put(
        '/manajemen-data/update/{id}',
        [DataController::class, 'update']
    );

    Route::delete(
        '/manajemen-data/delete/{id}',
        [DataController::class, 'destroy']
    );

    Route::post(
        '/manajemen-data/import',
        [DataController::class, 'import']
    );

    // Prediksi
    Route::get(
        '/prediksi',
        [PrediksiController::class, 'index']
    );

    // Laporan
    Route::get(
        '/laporan',
        [LaporanController::class, 'index']
    );

    Route::get(
        '/laporan/pdf',
        [LaporanController::class, 'exportPdf']
    );

    // Profile Breeze
    Route::get(
        '/profile',
        [ProfileController::class, 'edit']
    )->name('profile.edit');

    Route::patch(
        '/profile',
        [ProfileController::class, 'update']
    )->name('profile.update');

    Route::delete(
        '/profile',
        [ProfileController::class, 'destroy']
    )->name('profile.destroy');
});

require __DIR__.'/auth.php';