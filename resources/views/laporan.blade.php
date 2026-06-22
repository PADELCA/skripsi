@extends('layouts.app')

@section('content')

<div class="content-box">

<h2 class="mb-4">

    Laporan Forecast Stok Obat

</h2>

<a
    href="/laporan/pdf"
    class="btn btn-danger mb-3">

    Export PDF

</a>

    
    <table
        class="table table-bordered table-striped">

        <thead class="table-dark">

            <tr>

                <th>Nama Obat</th>

                <th>Forecast</th>

                <th>Rekomendasi Stok</th>

            </tr>

        </thead>

        <tbody>

        @forelse($hasilForecast as $item)

            <tr>

                <td>

                    {{ $item['nama_obat'] }}

                </td>

                <td>

                    {{ $item['forecast'] }}

                </td>

                <td>

                    {{ $item['rekomendasi'] }}

                </td>

            </tr>

        @empty

            <tr>

                <td
                    colspan="3"
                    class="text-center">

                    Belum ada data

                </td>

            </tr>

        @endforelse

        </tbody>

    </table>

    <hr>

    <h4 class="mt-4">

        Riwayat Forecast

    </h4>

    <table
        class="table table-bordered">

        <thead class="table-secondary">

            <tr>

                <th>Tanggal Prediksi</th>

                <th>Nama Obat</th>

                <th>Forecast</th>

                <th>Rekomendasi</th>

            </tr>

        </thead>

        <tbody>

        @forelse($riwayat as $item)

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

        @empty

            <tr>

                <td
                    colspan="4"
                    class="text-center">

                    Belum ada riwayat forecast

                </td>

            </tr>

        @endforelse

        </tbody>

    </table>

    <div
        class="d-flex justify-content-center">

        {{ $riwayat->links() }}

    </div>

</div>

@endsection