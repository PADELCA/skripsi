@extends('layouts.app')

@section('content')

<div class="content-box">

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h2 class="fw-bold">

            Forecasting Stok Obat

        </h2>

        <p class="text-muted">

            Prediksi kebutuhan stok obat menggunakan algoritma
            <strong>Long Short-Term Memory (LSTM)</strong>

        </p>

    </div>

    <span class="badge bg-success p-2">

        <i class="fa-solid fa-circle-check"></i>

        Model AI Aktif

    </span>

</div>

@if(session('success'))

<div class="alert alert-success">

    <i class="fa-solid fa-circle-check"></i>

    {{ session('success') }}

</div>

@endif

@if(session('error'))

<div class="alert alert-danger">

    <i class="fa-solid fa-circle-xmark"></i>

    {{ session('error') }}

</div>

@endif

<div class="row g-4 mb-4">

    <div class="col-md-3">

        <div class="dashboard-card bg-primary text-white">

            <div class="card-body">

                <h6>

                    Obat Penelitian

                </h6>

                <h2>

                    {{ count($daftarObat) }}

                </h2>

            </div>

        </div>

    </div>

    <div class="col-md-3">

        <div class="dashboard-card bg-success text-white">

            <div class="card-body">

                <h6>

                    Metode

                </h6>

                <h3>

                    LSTM

                </h3>

            </div>

        </div>

    </div>

    <div class="col-md-3">

        <div class="dashboard-card bg-warning">

            <div class="card-body">

                <h6>

                    Forecast

                </h6>

                <h3>

                    1 Bulan

                </h3>

            </div>

        </div>

    </div>

    <div class="col-md-3">

        <div class="dashboard-card bg-info text-white">

            <div class="card-body">

                <h6>

                    Status Model

                </h6>

                <h3>

                    Ready

                </h3>

            </div>

        </div>

    </div>

</div>

<div class="row">

<div class="col-lg-5">

<div class="card-custom">

<h4 class="mb-4">

Input Forecast

</h4>

<form method="GET" action="{{ url('/prediksi') }}">

<div class="mb-3">

<label class="form-label">

Pilih Obat

</label>

<select
class="form-select"
name="obat"
required>

<option value="">

-- Pilih Obat --

</option>

@foreach($daftarObat as $obat)

<option
value="{{ $obat }}"
{{ $obatDipilih==$obat ? 'selected':'' }}>

{{ $obat }}

</option>

@endforeach

</select>

</div>

<button
type="submit"
class="btn btn-primary w-100">

<i class="fa-solid fa-brain"></i>

Generate Forecast

</button>

</form>

<hr>

<div class="validation-box">

<h6>

Pipeline Forecasting

</h6>

<div class="mt-3">

✔ Dataset Historis Valid <br>

✔ Normalisasi Data <br>

✔ Model LSTM Aktif <br>

✔ Forecast Siap Diproses

</div>

</div>

</div>

</div>

<div class="col-lg-7">

<div class="card-custom">

<h4 class="mb-4">

Hasil Forecast

</h4>

@if($hasil)

<div class="row mb-4">

<div class="col-md-6">

<div class="info-box">

<i class="fa-solid fa-capsules"></i>

<div>

<small class="text-muted">

Nama Obat

</small>

<h5 class="mb-0">

{{ $obatDipilih }}

</h5>

</div>

</div>

</div>

<div class="col-md-6">

<div class="info-box">

<i class="fa-solid fa-chart-line"></i>

<div>

<small class="text-muted">

Forecast Bulan Berikutnya

</small>

<h4 class="mb-0 text-primary">

{{ number_format($hasil) }} Unit

</h4>

</div>

</div>

</div>

</div>

<table class="table table-bordered align-middle">

<tbody>

<tr>

<th width="35%">

Nama Obat

</th>

<td>

{{ $obatDipilih }}

</td>

</tr>

<tr>

<th>

Forecast

</th>

<td>

<strong class="text-primary">

{{ number_format($hasil) }}

Unit

</strong>

</td>

</tr>

<tr>

<th>

Safety Stock (20%)

</th>

<td>

{{ number_format($safetyStock) }}

Unit

</td>

</tr>

<tr>

<th>

Rekomendasi Stok

</th>

<td>

<strong class="text-success">

{{ number_format($rekomendasi) }}

Unit

</strong>

</td>

</tr>

<tr>

<th>

Status Forecast

</th>

<td>

@if($hasil>=600)

<span class="badge bg-danger">

Permintaan Tinggi

</span>

@elseif($hasil>=300)

<span class="badge bg-warning text-dark">

Permintaan Sedang

</span>

@else

<span class="badge bg-success">

Permintaan Rendah

</span>

@endif

</td>

</tr>

</tbody>

</table>

<div class="alert alert-info mt-4">

<b>Interpretasi Forecast</b>

<br><br>

Forecast menunjukkan estimasi jumlah obat yang diperkirakan
akan terjual pada periode berikutnya berdasarkan model
Long Short-Term Memory (LSTM).

Safety Stock dihitung sebesar
<b>20%</b>
dari nilai forecast sebagai stok pengaman.

Jumlah rekomendasi merupakan stok yang disarankan untuk
dipersiapkan oleh apotek.

</div>

<canvas
id="forecastChart"
height="120">

</canvas>

@else

<div class="text-center py-5">

<i class="fa-solid fa-chart-line fa-4x text-primary mb-3"></i>

<h5>

Belum Ada Forecast

</h5>

<p class="text-muted">

Silakan pilih salah satu obat kemudian tekan tombol
<b>Generate Forecast</b>.

</p>

</div>

@endif

</div>

</div>

</div>

</div>

@if($hasil)

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

const ctx = document.getElementById('forecastChart');

if(ctx){

new Chart(ctx,{

type:'bar',

data:{

labels:[

'Forecast',

'Safety Stock',

'Rekomendasi'

],

datasets:[{

label:'Jumlah Unit',

data:[

{{ $hasil }},

{{ $safetyStock }},

{{ $rekomendasi }}

],

backgroundColor:[

'#0d6efd',

'#ffc107',

'#198754'

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

text:'Visualisasi Hasil Forecast'

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

<div class="card-custom mt-4">

<div class="row">

<div class="col-md-8">

<h5>

Rekomendasi Sistem

</h5>

<p class="text-muted">

Sistem telah berhasil melakukan forecasting menggunakan
algoritma <b>Long Short-Term Memory (LSTM)</b>.
Nilai rekomendasi stok dapat dijadikan acuan dalam
pengadaan obat pada periode berikutnya untuk membantu
mengurangi risiko kekurangan maupun kelebihan stok.

</p>

</div>

<div class="col-md-4">

<div class="d-grid gap-2">

<a
href="{{ route('dashboard') }}"
class="btn btn-primary">

<i class="fa-solid fa-chart-column"></i>

Dashboard

</a>

<a
href="{{ url('/laporan') }}"
class="btn btn-success">

<i class="fa-solid fa-file-lines"></i>

Lihat Laporan

</a>

<a
href="{{ url('/laporan/pdf') }}"
class="btn btn-danger">

<i class="fa-solid fa-file-pdf"></i>

Export PDF

</a>

</div>

</div>

</div>

</div>

@endif

@endsection