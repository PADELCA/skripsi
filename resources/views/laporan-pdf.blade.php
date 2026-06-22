<!DOCTYPE html>

<html>

<head>

```
<title>
    Laporan Forecast Stok Obat
</title>

<style>

    body{
        font-family: Arial;
    }

    table{
        width:100%;
        border-collapse:collapse;
    }

    th,td{
        border:1px solid black;
        padding:8px;
    }

    th{
        background:#f0f0f0;
    }

</style>
```

</head>

<body>

<h2>

```
Laporan Forecast Stok Obat
```
<a
    href="/laporan/pdf"
    class="btn btn-danger mb-3">

    Export PDF

</a>

</h2>

<p>

```
Tanggal Cetak:
{{ now()->format('d-m-Y') }}
```

</p>

<table>

```
<thead>

    <tr>

        <th>Tanggal</th>

        <th>Nama Obat</th>

        <th>Forecast</th>

        <th>Rekomendasi</th>

    </tr>

</thead>

<tbody>

@foreach($riwayat as $item)

    <tr>

        <td>

            {{ $item->tanggal_prediksi }}

        </td>

        <td>

            {{ $item->nama_obat }}

        </td>

        <td>

            {{ $item->forecast }}

        </td>

        <td>

            {{ $item->rekomendasi }}

        </td>

    </tr>

@endforeach

</tbody>
```

</table>

</body>
</html>
