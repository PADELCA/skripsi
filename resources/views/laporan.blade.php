@extends('layouts.app')

@section('content')

<div class="content-box">

    {{-- ========================= --}}
    {{-- HEADER --}}
    {{-- ========================= --}}

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold">

                Laporan Forecasting Stok Obat

            </h2>

            <p class="text-muted">

                Ringkasan hasil forecasting menggunakan metode
                <strong>Long Short-Term Memory (LSTM)</strong>

            </p>

        </div>

        <div>

            <a
                href="/laporan/pdf"
                class="btn btn-danger">

                <i class="fa-solid fa-file-pdf"></i>

                Export PDF

            </a>

        </div>

    </div>

    {{-- ========================= --}}
    {{-- KPI --}}
    {{-- ========================= --}}

    <div class="row g-4 mb-4">

        <div class="col-lg-3">

            <div class="dashboard-card bg-primary text-white">

                <div class="card-body">

                    <h6>

                        Jumlah Obat

                    </h6>

                    <h2>

                        {{ $jumlahObat }}

                    </h2>

                    <small>

                        Obat Penelitian

                    </small>

                </div>

            </div>

        </div>

        <div class="col-lg-3">

            <div class="dashboard-card bg-success text-white">

                <div class="card-body">

                    <h6>

                        Total Forecast

                    </h6>

                    <h2>

                        {{ number_format($totalForecast) }}

                    </h2>

                    <small>

                        Unit

                    </small>

                </div>

            </div>

        </div>

        <div class="col-lg-3">

            <div class="dashboard-card bg-warning">

                <div class="card-body">

                    <h6>

                        Forecast Tertinggi

                    </h6>

                    <h5>

                        {{ $forecastTertinggi->nama_obat }}

                    </h5>

                    <strong>

                        {{ round($forecastTertinggi->forecast) }}

                        Unit

                    </strong>

                </div>

            </div>

        </div>

        <div class="col-lg-3">

            <div class="dashboard-card bg-info text-white">

                <div class="card-body">

                    <h6>

                        Rata-rata Forecast

                    </h6>

                    <h2>

                        {{ $rataForecast }}

                    </h2>

                    <small>

                        Unit

                    </small>

                </div>

            </div>

        </div>

    </div>
        {{-- ========================= --}}
    {{-- GRAFIK & INSIGHT --}}
    {{-- ========================= --}}

    <div class="row mb-4">

        <div class="col-lg-8">

            <div class="card-custom">

                <h5 class="mb-4">

                    Grafik Forecast 10 Obat Penelitian

                </h5>

                <canvas id="forecastChart"></canvas>

            </div>

        </div>

        <div class="col-lg-4">

            <div class="card-custom">

                <h5 class="mb-4">

                    Insight Forecast

                </h5>

                <div class="validation-box">

                    <div class="validation-item">

                        <span>

                            Total Forecast

                        </span>

                        <strong>

                            {{ number_format($totalForecast) }}

                        </strong>

                    </div>

                    <div class="validation-item">

                        <span>

                            Total Rekomendasi

                        </span>

                        <strong>

                            {{ number_format($totalRekomendasi) }}

                        </strong>

                    </div>

                    <div class="validation-item">

                        <span>

                            Forecast Tertinggi

                        </span>

                        <strong>

                            {{ $forecastTertinggi->nama_obat }}

                        </strong>

                    </div>

                    <div class="validation-item">

                        <span>

                            Nilai Forecast

                        </span>

                        <strong>

                            {{ round($forecastTertinggi->forecast) }}

                        </strong>

                    </div>

                    <div class="validation-item">

                        <span>

                            Forecast Terendah

                        </span>

                        <strong>

                            {{ $forecastTerendah->nama_obat }}

                        </strong>

                    </div>

                    <div class="validation-item">

                        <span>

                            Nilai Forecast

                        </span>

                        <strong>

                            {{ round($forecastTerendah->forecast) }}

                        </strong>

                    </div>

                </div>

                <hr>

                <h6>

                    Kesimpulan Sistem

                </h6>

                <p class="text-muted">

                    Berdasarkan hasil prediksi menggunakan model
                    <strong>Long Short-Term Memory (LSTM)</strong>,
                    sistem berhasil menghasilkan estimasi kebutuhan
                    stok untuk 10 obat penelitian.
                    Nilai forecast digunakan sebagai dasar
                    rekomendasi stok yang akan disediakan
                    pada periode berikutnya.

                </p>

            </div>

        </div>

    </div>
        {{-- ========================= --}}
    {{-- TABEL LAPORAN --}}
    {{-- ========================= --}}

    <div class="card-custom">

        <div class="d-flex justify-content-between align-items-center mb-3">

            <h5>

                Ringkasan Hasil Forecasting

            </h5>

            <span class="badge bg-primary">

                {{ $jumlahObat }} Obat Penelitian

            </span>

        </div>

        <div class="table-responsive">

            <table class="table table-hover align-middle">

                <thead class="table-dark">

                    <tr>

                        <th width="60">

                            No

                        </th>

                        <th>

                            Nama Obat

                        </th>

                        <th class="text-center">

                            Forecast

                        </th>

                        <th class="text-center">

                            Safety Stock

                        </th>

                        <th class="text-center">

                            Rekomendasi

                        </th>

                        <th class="text-center">

                            Status

                        </th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($data as $item)

                    @php

                        $forecast = round($item->forecast);

                        $safety = round($forecast * 0.20);

                        $rekomendasi = $item->rekomendasi;

                    @endphp

                    <tr>

                        <td>

                            {{ $loop->iteration }}

                        </td>

                        <td>

                            <strong>

                                {{ $item->nama_obat }}

                            </strong>

                            <br>

                            <small class="text-muted">

                                Prediksi:
                                {{ \Carbon\Carbon::parse($item->tanggal_prediksi)->format('d M Y') }}

                            </small>

                        </td>

                        <td class="text-center">

                            <span class="badge bg-primary">

                                {{ number_format($forecast) }}

                            </span>

                        </td>

                        <td class="text-center">

                            {{ number_format($safety) }}

                        </td>

                        <td class="text-center">

                            <strong>

                                {{ number_format($rekomendasi) }}

                            </strong>

                        </td>

                        <td class="text-center">

                            @if($forecast >= 600)

                                <span class="badge bg-danger">

                                    Tinggi

                                </span>

                            @elseif($forecast >= 300)

                                <span class="badge bg-warning text-dark">

                                    Sedang

                                </span>

                            @else

                                <span class="badge bg-success">

                                    Rendah

                                </span>

                            @endif

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="6" class="text-center py-5">

                            <i class="fa-solid fa-circle-info fa-2x mb-3"></i>

                            <br>

                            Belum terdapat data hasil forecasting.

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>
    {{-- ========================= --}}
{{-- CHART.JS --}}
{{-- ========================= --}}

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

const ctx = document.getElementById('forecastChart');

if(ctx){

new Chart(ctx,{

type:'bar',

data:{

labels:@json($chartLabels),

datasets:[{

label:'Forecast',

data:@json($chartForecast),

backgroundColor:[
'#0d6efd',
'#198754',
'#ffc107',
'#dc3545',
'#20c997',
'#6f42c1',
'#fd7e14',
'#6610f2',
'#17a2b8',
'#6c757d'
],

borderRadius:10,

borderWidth:0

}]

},

options:{

responsive:true,

maintainAspectRatio:false,

plugins:{

legend:{

display:false

},

title:{

display:true,

text:'Grafik Forecast 10 Obat Penelitian'

}

},

scales:{

y:{

beginAtZero:true,

ticks:{

precision:0

}

},

x:{

grid:{

display:false

}

}

}

}

});

}

</script>

{{-- ========================= --}}
{{-- FOOTER CARD --}}
{{-- ========================= --}}

<div class="card-custom mt-4">

    <div class="row">

        <div class="col-lg-8">

            <h5>

                Kesimpulan Forecasting

            </h5>

            <p class="text-muted">

                Berdasarkan hasil prediksi menggunakan algoritma
                <strong>Long Short-Term Memory (LSTM)</strong>,
                sistem berhasil menghasilkan estimasi kebutuhan
                stok untuk setiap obat penelitian.
                Nilai forecast dapat dijadikan acuan dalam
                menentukan jumlah persediaan agar mengurangi
                risiko kekurangan maupun kelebihan stok.

            </p>

        </div>

        <div class="col-lg-4">

            <div class="alert alert-success mb-0">

                <strong>

                    Status Sistem

                </strong>

                <hr>

                ✔ Dataset Valid

                <br>

                ✔ Model LSTM Aktif

                <br>

                ✔ Forecast Berhasil

                <br>

                ✔ Laporan Siap Diekspor

            </div>

        </div>

    </div>

</div>

</div>

@endsection