@extends('layouts.app')

@section('content')

<h2 class="mb-4">
    Dashboard Forecasting Stok Obat
</h2>

<div class="row g-4">

    <div class="col-md-3">

        <div class="card-custom">

            <h6>💊 Total Jenis Obat</h6>

            <div class="stat-number">

                {{ $totalObat }}

            </div>

        </div>

    </div>

    <div class="col-md-3">

        <div class="card-custom">

            <h6>📦 Total Penjualan</h6>

            <div class="stat-number">

                {{ number_format($totalPenjualan) }}

            </div>

        </div>

    </div>

    <div class="col-md-3">

        <div class="card-custom">

            <h6>🏆 Obat Terlaris</h6>

            <div
                class="stat-number"
                style="font-size:20px">

                {{ $obatTerlaris->nama_obat ?? '-' }}

            </div>

        </div>

    </div>

    <div class="col-md-3">

        <div class="card-custom">

            <h6>📅 Data Terbaru</h6>

            <div
                class="stat-number"
                style="font-size:20px">

                {{ $dataTerbaru->tanggal ?? '-' }}

            </div>

        </div>

    </div>

</div>

<div class="card-custom mt-4">

    <h5>
        Sistem Forecasting Stok Obat Menggunakan LSTM
    </h5>

    <p class="text-muted">

        Sistem ini digunakan untuk melakukan
        prediksi penjualan obat berdasarkan
        data historis menggunakan metode
        Long Short-Term Memory (LSTM).

    </p>

</div>

@endsection