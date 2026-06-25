<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<title>

Laporan Forecasting Stok Obat

</title>

<style>

body{

    font-family:DejaVu Sans;

    font-size:12px;

    color:#333;

}

.header{

    text-align:center;

    border-bottom:3px solid #0d6efd;

    padding-bottom:15px;

    margin-bottom:20px;

}

.header h2{

    margin:0;

    color:#0d6efd;

}

.header p{

    margin:3px;

}

.summary{

    width:100%;

    margin-bottom:20px;

}

.summary td{

    border:1px solid #ccc;

    padding:8px;

}

.summary-title{

    background:#0d6efd;

    color:white;

    font-weight:bold;

    width:220px;

}

table{

    width:100%;

    border-collapse:collapse;

}

th{

    background:#0d6efd;

    color:white;

    padding:8px;

    border:1px solid #ccc;

}

td{

    padding:8px;

    border:1px solid #ccc;

}

.text-center{

    text-align:center;

}

.text-right{

    text-align:right;

}

.footer{

    margin-top:30px;

    font-size:11px;

    color:#666;

    text-align:center;

    border-top:1px solid #ddd;

    padding-top:10px;

}

</style>

</head>

<body>

<div class="header">

<h2>

LAPORAN HASIL FORECASTING STOK OBAT

</h2>

<p>

Sistem Forecasting Menggunakan Long Short-Term Memory (LSTM)

</p>

<p>

Tanggal Cetak :
{{ now()->format('d F Y') }}

</p>

</div>

<table class="summary">

<tr>

<td class="summary-title">

Jumlah Obat

</td>

<td>

{{ $summary['jumlahObat'] }}

Obat

</td>

</tr>

<tr>

<td class="summary-title">

Total Forecast

</td>

<td>

{{ number_format($summary['totalForecast']) }}

Unit

</td>

</tr>

<tr>

<td class="summary-title">

Total Rekomendasi

</td>

<td>

{{ number_format($summary['totalRekomendasi']) }}

Unit

</td>

</tr>

<tr>

<td class="summary-title">

Rata-rata Forecast

</td>

<td>

{{ number_format($summary['rataForecast'],2) }}

Unit

</td>

</tr>

</table>

<table>

<thead>

<tr>

<th width="40">

No

</th>

<th>

Nama Obat

</th>

<th width="90">

Tanggal

</th>

<th width="90">

Forecast

</th>

<th width="90">

Safety Stock

</th>

<th width="100">

Rekomendasi

</th>

<th width="80">

Status

</th>

</tr>

</thead>

<tbody>

@forelse($riwayat as $item)

@php

$forecast = round($item->forecast);

$safety = round($forecast * 0.20);

$rekomendasi = $item->rekomendasi;

@endphp

<tr>

<td class="text-center">

{{ $loop->iteration }}

</td>

<td>

{{ $item->nama_obat }}

</td>

<td class="text-center">

{{ \Carbon\Carbon::parse($item->tanggal_prediksi)->format('d-m-Y') }}

</td>

<td class="text-right">

{{ number_format($forecast) }}

</td>

<td class="text-right">

{{ number_format($safety) }}

</td>

<td class="text-right">

{{ number_format($rekomendasi) }}

</td>

<td class="text-center">

@if($forecast >= 600)

Tinggi

@elseif($forecast >= 300)

Sedang

@else

Rendah

@endif

</td>

</tr>

@endforelse

@if($riwayat->count()==0)

<tr>

<td colspan="7" class="text-center">

Tidak ada data forecasting.

</td>

</tr>

@endif

</tbody>

</table>

<br>

<p>

<b>Keterangan :</b>

</p>

<ul>

<li>

Forecast merupakan hasil prediksi penjualan bulan berikutnya menggunakan algoritma Long Short-Term Memory (LSTM).

</li>

<li>

Safety Stock dihitung sebesar <b>20%</b> dari nilai forecast sebagai stok pengaman.

</li>

<li>

Rekomendasi merupakan jumlah stok yang disarankan untuk disediakan pada periode berikutnya.

</li>

</ul>

<hr>

<h4>

Kesimpulan

</h4>

<p style="text-align:justify; line-height:1.7;">

Berdasarkan hasil forecasting menggunakan metode
<b>Long Short-Term Memory (LSTM)</b>,
sistem berhasil menghasilkan prediksi kebutuhan stok
untuk 10 obat penelitian pada periode berikutnya.

Hasil forecasting ini diharapkan dapat membantu
Apotik Limas dalam menentukan jumlah persediaan obat
secara lebih efektif sehingga dapat mengurangi risiko
terjadinya kekurangan stok (<i>stockout</i>) maupun
kelebihan stok (<i>overstock</i>).

Nilai rekomendasi stok yang ditampilkan pada laporan
merupakan acuan awal dalam proses pengambilan keputusan
dan masih dapat disesuaikan dengan kondisi operasional
serta kebijakan apotek.

</p>

<br><br>

<table style="width:100%; border:none;">

<tr>

<td style="border:none; width:60%;">

</td>

<td style="border:none; text-align:center;">

Banjarbaru,

{{ now()->format('d F Y') }}

<br><br><br><br><br>

<b>

Administrator

</b>

<br>

_________________________

</td>

</tr>

</table>

<div class="footer">

<hr>

<div style="text-align:center;">

<b>

Sistem Forecasting Stok Obat Berbasis Long Short-Term Memory (LSTM)

</b>

<br>

APOTIK LIMAS

<br>

Laporan ini dibuat secara otomatis oleh sistem.

<br>

Dicetak pada

{{ now()->format('d F Y H:i') }}

</div>

</div>

</body>

</html>