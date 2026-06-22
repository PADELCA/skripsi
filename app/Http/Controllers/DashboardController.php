<?php

namespace App\Http\Controllers;

use App\Models\StokObat;

class DashboardController extends Controller
{
    public function index()
    {
        $totalObat = StokObat::distinct('nama_obat')->count();

        $totalPenjualan = StokObat::sum('jumlah_terjual');

        $obatTerlaris = StokObat::selectRaw('nama_obat, SUM(jumlah_terjual) as total')
            ->groupBy('nama_obat')
            ->orderByDesc('total')
            ->first();

        $dataTerbaru = StokObat::latest('tanggal')
            ->first();

        return view('dashboard', compact(
            'totalObat',
            'totalPenjualan',
            'obatTerlaris',
            'dataTerbaru'
        ));
    }
}