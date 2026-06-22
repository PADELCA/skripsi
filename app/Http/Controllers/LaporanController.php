<?php

namespace App\Http\Controllers;

use App\Models\StokObat;
use App\Models\HasilPrediksi;
use App\Services\PrediksiService;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    public function index(
        PrediksiService $service
    )
    
    {
        $obatList = [

            'Paracetamol',

            'Amoxicillin',

            'Vitamin C'

        ];

        $hasilForecast = [];

        foreach ($obatList as $obat)
        {
            $data = StokObat::where(
                    'nama_obat',
                    $obat
                )
                ->orderByDesc('tanggal')
                ->take(14)
                ->get()
                ->reverse()
                ->pluck('jumlah_terjual')
                ->toArray();

            if (
                count($data) < 14
            ) {
                continue;
            }

            try {

                $hasil = $service->getPrediksi(
                    $obat,
                    $data
                );

                HasilPrediksi::updateOrCreate(

                    [
                        'nama_obat' => $obat,
                        'tanggal_prediksi' =>
                            now()->toDateString()
                    ],

                    [
                        'forecast' =>
                            $hasil['prediction'],

                        'rekomendasi' =>
                            $hasil['rekomendasi']
                    ]

                );

                $hasilForecast[] = [

                    'nama_obat' =>
                        $obat,

                    'forecast' =>
                        $hasil['prediction'],

                    'rekomendasi' =>
                        $hasil['rekomendasi']

                ];

            } catch (\Exception $e) {

                //
            }
        }

        $riwayat = HasilPrediksi::latest()
            ->paginate(10);

        return view(
            'laporan',
            compact(
                'hasilForecast',
                'riwayat'
            )
        );
    }
        public function exportPdf()
        {
            $riwayat = HasilPrediksi::latest()
                ->get();

            $pdf = Pdf::loadView(
                'laporan-pdf',
                compact('riwayat')
            );

            return $pdf->download(
                'laporan_forecast_obat.pdf'
            );
        }

}
