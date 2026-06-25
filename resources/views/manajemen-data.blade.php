@extends('layouts.app')

@section('content')

<div class="content-box">

<div class="d-flex justify-content-between align-items-center mb-4">
<div>
<h2 class="fw-bold">Dataset Historis Forecasting</h2>
<p class="text-muted">Kelola dataset historis yang digunakan sebagai dasar proses Forecasting menggunakan LSTM.</p>
</div>
<div>
<span class="badge bg-success p-2">{{ $statusDataset }}</span>
</div>
</div>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="row g-4 mb-4">
<div class="col-md-3"><div class="dashboard-card bg-primary text-white"><div class="card-body"><h6>Total Record</h6><h2>{{ number_format($totalData) }}</h2></div></div></div>
<div class="col-md-3"><div class="dashboard-card bg-success text-white"><div class="card-body"><h6>Jenis Obat</h6><h2>{{ $totalObat }}</h2></div></div></div>
<div class="col-md-3"><div class="dashboard-card bg-warning"><div class="card-body"><h6>Periode</h6><small>{{ $dataTerlama }}<br>s/d<br>{{ $dataTerbaru }}</small></div></div></div>
<div class="col-md-3"><div class="dashboard-card bg-info text-white"><div class="card-body"><h6>Rata-rata</h6><h2>{{ $rataPenjualan }}</h2></div></div></div>
</div>

<div class="row">
<div class="col-lg-8">
<div class="card-custom">
<h5>Distribusi Total Penjualan per Obat</h5>
<canvas id="datasetChart"></canvas>
</div>
</div>

<div class="col-lg-4">
<div class="card-custom">
<h5>Validasi Dataset</h5>
<table class="table">
<tr><td>Missing Value</td><td><span class="badge bg-success">{{ $missingValue }}</span></td></tr>
<tr><td>Duplicate</td><td><span class="badge bg-success">{{ $duplicateData }}</span></td></tr>
<tr><td>Penjualan Maks</td><td>{{ $penjualanMaks }}</td></tr>
<tr><td>Penjualan Min</td><td>{{ $penjualanMin }}</td></tr>
<tr><td>Status</td><td><span class="badge bg-primary">{{ $statusDataset }}</span></td></tr>
</table>

<hr>

<p class="text-muted mb-1"><strong>Insight Dataset</strong></p>

<ul>
<li>{{ number_format($totalData) }} record historis.</li>
<li>{{ $totalObat }} jenis obat.</li>
<li>Tidak ditemukan missing value maupun duplicate apabila bernilai 0.</li>
<li>Dataset siap digunakan untuk proses Forecasting LSTM.</li>
</ul>

</div>
</div>
</div>

<div class="card-custom mt-4">

<div class="row align-items-center">

<div class="col-md-4">

<form method="GET">

<input class="form-control" name="search" value="{{ request('search') }}" placeholder="Cari nama obat...">

</form>

</div>

<div class="col-md-8 text-end">

<a href="/manajemen-data/create" class="btn btn-primary">
Tambah Data
</a>

<form class="d-inline" action="/manajemen-data/import" method="POST" enctype="multipart/form-data">
@csrf
<input type="file" name="file" required>
<button class="btn btn-success">Import Dataset CSV</button>
</form>

</div>

</div>

</div>

<div class="card-custom">

<h5 class="mb-3">Preview Dataset Historis</h5>

<div class="table-responsive">

<table class="table table-hover align-middle">

<thead class="table-dark">

<tr>
<th>No</th>
<th>Tanggal</th>
<th>Nama Obat</th>
<th>Jumlah Terjual</th>
<th>Aksi</th>
</tr>

</thead>

<tbody>

@forelse($data as $item)

<tr>

<td>{{ $loop->iteration + (($data->currentPage()-1)*$data->perPage()) }}</td>

<td>{{ $item->tanggal }}</td>

<td>{{ $item->nama_obat }}</td>

<td><span class="badge bg-success">{{ $item->jumlah_terjual }}</span></td>

<td>
<a href="/manajemen-data/edit/{{ $item->id }}" class="btn btn-warning btn-sm">Edit</a>

<form action="/manajemen-data/delete/{{ $item->id }}" method="POST" class="d-inline">
@csrf
@method('DELETE')
<button onclick="return confirm('Hapus data?')" class="btn btn-danger btn-sm">Hapus</button>
</form>

</td>

</tr>

@empty

<tr>

<td colspan="5" class="text-center">

Belum ada dataset.

</td>

</tr>

@endforelse

</tbody>

</table>

</div>

{{ $data->links() }}

</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

new Chart(document.getElementById('datasetChart'),{

type:'bar',

data:{

labels:@json($chartLabels),

datasets:[{

label:'Total Penjualan',

data:@json($chartValues)

}]

},

options:{

responsive:true,

plugins:{

legend:{display:false}

}

}

});

</script>

@endsection
