<?php

namespace App\Http\Controllers;

use App\Models\StokObat;

class StokObatController extends Controller
{
    public function index()
    {
        // 1. Ambil data
        $stokObat = StokObat::orderBy('tanggal', 'asc')->get();

        // 2. Siapkan data untuk grafik
        // Kita pisah tanggal dan jumlah agar mudah dibaca chart.js
        $labels = $stokObat->pluck('tanggal'); 
        $dataStok = $stokObat->pluck('jumlah_terjual');

        // Prediksi dummy (nanti diganti logic AI Anda)
        $prediksi = "25 Obat"; 

        return view('prediksi.index', compact('dataStok', 'labels', 'prediksi'));
    }
}