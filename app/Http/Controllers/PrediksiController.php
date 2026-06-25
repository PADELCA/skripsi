<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\StokObat;
use App\Models\HasilPrediksi;

class PrediksiController extends Controller
{
    public function index(Request $request)
    {
        $daftarObat = [
            'Allopurinol 100 mg',
            'Andalan Pil KB',
            'Cetirizine 10 mg',
            'Dexaharsen 0.5 mg tab',
            'Dexaharsen 0.75 mg',
            'FG Troches tab',
            'Neuralgin tab',
            'Simvastatin 10 mg',
            'Teosal',
            'Voltadex 50 mg'
        ];

        $hasil = null;
        $obatDipilih = $request->obat;

        if ($request->filled('obat')) {

            $indexObat = array_search($obatDipilih, $daftarObat);

            if ($indexObat === false) {
                return back()->with('error', 'Obat tidak ditemukan.');
            }

            $histori = StokObat::where('nama_obat', $obatDipilih)
                ->orderBy('tanggal')
                ->pluck('jumlah_terjual');

            if ($histori->isEmpty()) {
                return back()->with('error', 'Data historis obat tidak ditemukan.');
            }

            $penjualanTerakhir = (int) $histori->last();

            $payload = [
                'input' => [
                    [
                        $indexObat,
                        $penjualanTerakhir
                    ]
                ]
            ];

            try {

                $response = Http::timeout(30)
                    ->post('http://127.0.0.1:5000/predict', $payload);

                if (!$response->successful()) {
                    return back()->with('error', 'Flask API tidak merespon.');
                }

                $json = $response->json();

                if (!isset($json['prediction'])) {
                    return back()->with('error', 'Response Flask tidak valid.');
                }

                $hasil = round($json['prediction']);

                HasilPrediksi::updateOrCreate(

                    [
                        'nama_obat' => $obatDipilih
                    ],

                    [
                        'forecast' => $hasil,
                        'rekomendasi' => ceil($hasil * 1.2),
                        'tanggal_prediksi' => now()
                    ]

                );

                return view('prediksi', [

                    'daftarObat' => $daftarObat,

                    'hasil' => $hasil,

                    'obatDipilih' => $obatDipilih,

                    'safetyStock' => round($hasil * 0.2),

                    'rekomendasi' => ceil($hasil * 1.2)

                ])->with('success', 'Forecast berhasil dibuat.');

            } catch (\Exception $e) {

                return back()->with(
                    'error',
                    'Gagal terhubung ke Flask : ' . $e->getMessage()
                );

            }

        }

        return view('prediksi', [

            'daftarObat' => $daftarObat,

            'hasil' => null,

            'obatDipilih' => null,

            'safetyStock' => null,

            'rekomendasi' => null

        ]);
    }
}