@extends('layouts.app')

@section('content')

<div class="content-box">

<div class="d-flex justify-content-between align-items-center mb-4">
<div>
<h2 class="fw-bold">Dashboard Forecasting Stok Obat</h2>
<p class="text-muted">Monitoring hasil Forecasting menggunakan metode Long Short-Term Memory (LSTM)</p>
</div>
<div>
<span class="badge bg-primary p-2">Update : {{ $tanggalForecast ?? '-' }}</span>
</div>
</div>

<div class="row g-4 mb-4">

<div class="col-md-3">
<div class="dashboard-card bg-primary text-white">
<div class="card-body">
<h6>Obat Penelitian</h6>
<h2>{{ $jumlahObat }}</h2>
</div>
</div>
</div>

<div class="col-md-3">
<div class="dashboard-card bg-success text-white">
<div class="card-body">
<h6>Total Forecast</h6>
<h2>{{ number_format($totalForecast) }}</h2>
</div>
</div>
</div>

<div class="col-md-3">
<div class="dashboard-card bg-warning">
<div class="card-body">
<h6>Forecast Tertinggi</h6>
<strong>{{ $forecastTertinggi->nama_obat ?? '-' }}</strong><br>
{{ round($forecastTertinggi->forecast ?? 0) }} Unit
</div>
</div>
</div>

<div class="col-md-3">
<div class="dashboard-card bg-info text-white">
<div class="card-body">
<h6>Forecast Terendah</h6>
<strong>{{ $forecastTerendah->nama_obat ?? '-' }}</strong><br>
{{ round($forecastTerendah->forecast ?? 0) }} Unit
</div>
</div>
</div>

</div>

<div class="row">

<div class="col-lg-8">
<div class="card-custom">
<h5>Grafik Forecast 10 Obat Penelitian</h5>
<canvas id="forecastChart"></canvas>
</div>
</div>

<div class="col-lg-4">
<div class="card-custom">
<h5>Insight Forecast</h5>
<table class="table">
<tr><td>Rata-rata Forecast</td><td>{{ $rataForecast }}</td></tr>
<tr><td>Total Rekomendasi</td><td>{{ number_format($totalRekomendasi) }}</td></tr>
<tr><td>Jumlah Obat</td><td>{{ $jumlahObat }}</td></tr>
<tr><td>Status Model</td><td><span class="badge bg-success">Aktif</span></td></tr>
</table>
<hr>
<p class="text-muted">
Dashboard ini menampilkan hasil forecasting 10 obat penelitian menggunakan model LSTM yang telah dilatih.
</p>
</div>
</div>

</div>

<div class="card-custom mt-4">
<h5>Ringkasan Forecast Bulan Berikutnya</h5>

<div class="table-responsive">

<table class="table table-hover align-middle">

<thead class="table-dark">

<tr>
<th>No</th>
<th>Nama Obat</th>
<th>Forecast</th>
<th>Safety Stock</th>
<th>Rekomendasi</th>
<th>Status</th>
</tr>

</thead>

<tbody>

@foreach($forecast as $item)

<tr>

<td>{{ $loop->iteration }}</td>

<td>{{ $item->nama_obat }}</td>

<td>{{ round($item->forecast) }}</td>

<td>{{ round($item->forecast*0.2) }}</td>

<td>{{ $item->rekomendasi }}</td>

<td>

@if($item->forecast>500)
<span class="badge bg-danger">Tinggi</span>
@elseif($item->forecast>300)
<span class="badge bg-warning text-dark">Sedang</span>
@else
<span class="badge bg-success">Rendah</span>
@endif

</td>

</tr>

@endforeach

</tbody>

</table>

</div>

</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

new Chart(document.getElementById('forecastChart'),{

type:'bar',

data:{

labels:@json($chartLabels),

datasets:[
{
label:'Forecast',
data:@json($chartForecast)
},
{
label:'Rekomendasi',
data:@json($chartRekomendasi)
}
]

},

options:{
responsive:true,
plugins:{
legend:{position:'bottom'}
},
scales:{
y:{beginAtZero:true}
}
}

});

</script>

@endsection
