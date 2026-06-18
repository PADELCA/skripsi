<?php

namespace App\Http\Controllers;

use App\Models\StokObat;
use App\Services\PrediksiService;

class PrediksiController extends Controller
{
    public function index(PrediksiService $service)
    {
        // Ambil data (Ambil 7 yang terakhir)
        $dataStok = StokObat::latest()->take(7)->get()->reverse()->pluck('jumlah_terjual')->toArray();
        
        $prediksi = null;
        $error = null;

        // Hanya panggil AI jika data cukup (7 hari)
        if (count($dataStok) >= 7) {
            try {
                $prediksi = $service->getPrediksi($dataStok);
            } catch (\Exception $e) {
                $error = $e->getMessage();
            }
        } else {
            $error = "Data belum cukup (butuh minimal 7 hari).";
        }

        return view('prediksi.index', compact('prediksi', 'dataStok', 'error'));
    }
}