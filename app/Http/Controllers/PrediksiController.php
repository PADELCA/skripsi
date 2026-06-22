<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StokObat;
use App\Services\PrediksiService;

class PrediksiController extends Controller
{
    public function index(
        Request $request,
        PrediksiService $service
    )
    {
        $obat = $request->get(
            'obat',
            'Paracetamol'
        );

        $daftarObat = [
            'Paracetamol',
            'Amoxicillin',
            'Vitamin C'
        ];

        $dataStok = StokObat::where(
                'nama_obat',
                $obat
            )
            ->orderByDesc('tanggal')
            ->take(14)
            ->get()
            ->reverse()
            ->pluck('jumlah_terjual')
            ->toArray();

        $prediksi = null;
        $rekomendasi = null;
        $error = null;

        if (count($dataStok) >= 14) {

            try {

                $hasil = $service->getPrediksi(
                    $obat,
                    $dataStok
                );

                $prediksi =
                    $hasil['prediction'];

                $rekomendasi =
                    $hasil['rekomendasi'];

            } catch (\Exception $e) {

                $error =
                    $e->getMessage();
            }

        } else {

            $error =
                'Data belum cukup (minimal 14 hari).';
        }

        return view(
            'modul-prediksi',
            compact(
                'obat',
                'daftarObat',
                'dataStok',
                'prediksi',
                'rekomendasi',
                'error'
            )
        );
    }
}