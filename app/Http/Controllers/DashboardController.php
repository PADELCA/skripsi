<?php

namespace App\Http\Controllers;

use App\Models\HasilPrediksi;

class DashboardController extends Controller
{
    public function index()
    {
        $forecast = HasilPrediksi::orderBy('nama_obat')->get();

        $jumlahObat = $forecast->count();

        $totalForecast = round($forecast->sum('forecast'));

        $forecastTertinggi = $forecast->sortByDesc('forecast')->first();

        $forecastTerendah = $forecast->sortBy('forecast')->first();

        $rataForecast = $forecast->count() > 0
            ? round($forecast->avg('forecast'),2)
            : 0;

        $totalRekomendasi = round($forecast->sum('rekomendasi'));

        $tanggalForecast = optional(
            $forecast->sortByDesc('tanggal_prediksi')->first()
        )->tanggal_prediksi;

        return view('dashboard',[
            'forecast'=>$forecast,
            'jumlahObat'=>$jumlahObat,
            'totalForecast'=>$totalForecast,
            'forecastTertinggi'=>$forecastTertinggi,
            'forecastTerendah'=>$forecastTerendah,
            'rataForecast'=>$rataForecast,
            'totalRekomendasi'=>$totalRekomendasi,
            'tanggalForecast'=>$tanggalForecast,
            'chartLabels'=>$forecast->pluck('nama_obat'),
            'chartForecast'=>$forecast->pluck('forecast'),
            'chartRekomendasi'=>$forecast->pluck('rekomendasi')
        ]);
    }
}
