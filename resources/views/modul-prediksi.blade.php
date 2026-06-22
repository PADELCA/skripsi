@extends('layouts.app')

@section('content')

<div class="content-box">

```
<h2 class="mb-4">
    Forecasting Stok Obat Menggunakan LSTM
</h2>

<form method="GET" action="/prediksi" class="mb-4">

    <div class="row">

        <div class="col-md-4">

            <label class="form-label">
                Pilih Obat
            </label>

            <select
                name="obat"
                class="form-control"
                onchange="this.form.submit()"
            >

                @foreach($daftarObat as $item)

                    <option
                        value="{{ $item }}"
                        {{ $obat == $item ? 'selected' : '' }}
                    >
                        {{ $item }}
                    </option>

                @endforeach

            </select>

        </div>

    </div>

</form>

@if($error)

    <div class="alert alert-warning">
        {{ $error }}
    </div>

@endif

<div class="row mb-4">

    <div class="col-md-8">

        <div class="card-custom">

            <h5>
                Data Historis {{ $obat }}
                (14 Hari Terakhir)
            </h5>

            <canvas id="grafikStok"></canvas>

        </div>

    </div>

    <div class="col-md-4">

        <div class="card-custom">

            <h5>
                Forecast {{ $obat }}
            </h5>

            <hr>

            <h1 class="text-primary">

                {{ $prediksi ?? '-' }}

            </h1>

            <p>
                Prediksi penjualan
                periode berikutnya.
            </p>

            @if($rekomendasi)

                <div class="alert alert-success">

                    <strong>
                        Rekomendasi Stok:
                    </strong>

                    {{ $rekomendasi }}
                    Unit

                </div>

            @endif

            @if($prediksi)

                @if($prediksi >= 25)

                    <div class="alert alert-danger">

                        Stok Tinggi Dibutuhkan

                    </div>

                @elseif($prediksi >= 15)

                    <div class="alert alert-warning">

                        Persiapkan Restok

                    </div>

                @else

                    <div class="alert alert-info">

                        Stok Aman

                    </div>

                @endif

            @endif

        </div>

    </div>

</div>

<div class="card-custom">

    <h5>

        Data Historis yang Digunakan
        Model LSTM

    </h5>

    <table class="table table-bordered">

        <thead>

            <tr>

                <th>Hari</th>

                <th>Jumlah Terjual</th>

            </tr>

        </thead>

        <tbody>

        @foreach($dataStok as $index => $item)

            <tr>

                <td>

                    H-{{ count($dataStok) - $index }}

                </td>

                <td>

                    {{ $item }}

                </td>

            </tr>

        @endforeach

        </tbody>

    </table>

</div>
```

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

const dataStok =
{!! json_encode($dataStok) !!};

const labels = [];

for(let i = dataStok.length; i >= 1; i--)
{
    labels.push('H-' + i);
}

new Chart(
    document.getElementById('grafikStok'),
    {
        type:'line',

        data:{

            labels:labels,

            datasets:[{

                label:'{{ $obat }}',

                data:dataStok,

                borderWidth:3,

                tension:0.4,

                fill:false

            }]
        },

        options:{

            responsive:true,

            plugins:{

                legend:{
                    display:true
                }

            }

        }
    }
);

</script>

@endsection
