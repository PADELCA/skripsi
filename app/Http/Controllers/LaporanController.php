<?php

namespace App\Http\Controllers;

use App\Models\HasilPrediksi;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    public function index()
    {
        // Ambil hanya prediksi terbaru dari setiap obat
        $ids = HasilPrediksi::selectRaw('MAX(id) as id')
            ->groupBy('nama_obat')
            ->pluck('id');

        $laporan = HasilPrediksi::whereIn('id', $ids)
            ->orderBy('nama_obat')
            ->get();

        $jumlahObat = $laporan->count();
        $totalForecast = round($laporan->sum('forecast'));
        $totalRekomendasi = round($laporan->sum('rekomendasi'));
        $rataForecast = $jumlahObat > 0 ? round($laporan->avg('forecast'),2) : 0;

        $forecastTertinggi = $laporan->sortByDesc('forecast')->first();
        $forecastTerendah = $laporan->sortBy('forecast')->first();

        return view('laporan',[
            'data'=>$laporan,
            'jumlahObat'=>$jumlahObat,
            'totalForecast'=>$totalForecast,
            'totalRekomendasi'=>$totalRekomendasi,
            'rataForecast'=>$rataForecast,
            'forecastTertinggi'=>$forecastTertinggi,
            'forecastTerendah'=>$forecastTerendah,
            'chartLabels'=>$laporan->pluck('nama_obat'),
            'chartForecast'=>$laporan->pluck('forecast')
        ]);
    }

    public function pdf()
    {
        $ids = HasilPrediksi::selectRaw('MAX(id) as id')
            ->groupBy('nama_obat')
            ->pluck('id');

        $riwayat = HasilPrediksi::whereIn('id',$ids)
            ->orderBy('nama_obat')
            ->get();

        $summary = [
            'jumlahObat'=>$riwayat->count(),
            'totalForecast'=>round($riwayat->sum('forecast')),
            'totalRekomendasi'=>round($riwayat->sum('rekomendasi')),
            'rataForecast'=>$riwayat->count()?round($riwayat->avg('forecast'),2):0
        ];

        $pdf = Pdf::loadView('laporan-pdf',[
            'riwayat'=>$riwayat,
            'summary'=>$summary
        ])->setPaper('a4','portrait');

        return $pdf->download('Laporan_Forecasting_Stok_Obat.pdf');
    }
}
