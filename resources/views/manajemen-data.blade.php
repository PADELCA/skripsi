@extends('layouts.app')

@section('content')

<div class="content-box">

```
<h2 class="mb-4">
    Manajemen Data Obat
</h2>

@if(session('success'))

    <div class="alert alert-success">

        {{ session('success') }}

    </div>

@endif

<div class="row mb-3">

    <div class="col-md-6">

<div class="col-md-6">

    <form method="GET"
          action="/manajemen-data">

        <input
            type="text"
            name="search"
            value="{{ request('search') }}"
            class="form-control"
            placeholder="Cari Data Obat...">

    </form>

</div>

    </div>

    <div class="col-md-6 text-end">

        <a
            href="/manajemen-data/create"
            class="btn btn-primary">

            Tambah Data

        </a>

    <form
        action="/manajemen-data/import"
        method="POST"
        enctype="multipart/form-data"
        style="display:inline">

        @csrf

        <input
            type="file"
            name="file"
            accept=".csv"
            required>

        <button
            type="submit"
            class="btn btn-success">

            Import CSV

        </button>

    </form>

    </div>

</div>

<table class="table table-bordered table-striped table-hover">

    <thead class="table-dark">

        <tr>

            <th>Tanggal</th>

            <th>Nama Obat</th>

            <th>Jumlah Terjual</th>

            <th width="180">
                Aksi
            </th>

        </tr>

    </thead>

    <tbody>

    @forelse($data as $item)

        <tr>

            <td>

                {{ $item->tanggal }}

            </td>

            <td>

                {{ $item->nama_obat }}

            </td>

            <td>

                {{ $item->jumlah_terjual }}

            </td>

            <td>

                <a
                    href="/manajemen-data/edit/{{ $item->id }}"
                    class="btn btn-warning btn-sm">

                    Edit

                </a>

                <form
                    action="/manajemen-data/delete/{{ $item->id }}"
                    method="POST"
                    style="display:inline;">

                    @csrf

                    @method('DELETE')

                    <button
                        type="submit"
                        class="btn btn-danger btn-sm"
                        onclick="return confirm('Yakin ingin menghapus data ini?')">

                        Hapus

                    </button>

                </form>

            </td>

        </tr>

    @empty

        <tr>

            <td
                colspan="4"
                class="text-center">

                Tidak ada data

            </td>

        </tr>

    @endforelse

    </tbody>

</table>

<div class="d-flex justify-content-center mt-4">

    {{ $data->links() }}

</div>
```

</div>

@endsection
