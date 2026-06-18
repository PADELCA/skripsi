<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PrediksiController;

// Pastikan baris di bawah ini ada
Route::get('/prediksi', [PrediksiController::class, 'index']);