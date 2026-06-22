@extends('layouts.app')

@section('content')

<div class="content-box">

    <h3>Tambah Data Obat</h3>

    <form
        action="/manajemen-data/store"
        method="POST">

        @csrf

        <div class="mb-3">

            <label>Tanggal</label>

            <input
                type="date"
                name="tanggal"
                class="form-control">

        </div>

        <div class="mb-3">

            <label>Nama Obat</label>

            <input
                type="text"
                name="nama_obat"
                class="form-control">

        </div>

        <div class="mb-3">

            <label>Jumlah Terjual</label>

            <input
                type="number"
                name="jumlah_terjual"
                class="form-control">

        </div>

        <button
            class="btn btn-success">

            Simpan

        </button>

    </form>

</div>

@endsection