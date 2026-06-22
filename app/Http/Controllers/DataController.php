<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StokObat;

class DataController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Tampilkan Data
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $query = StokObat::query();

        if ($request->search) {

            $query->where(
                'nama_obat',
                'like',
                '%' . $request->search . '%'
            );
        }

        $data = $query
            ->latest('tanggal')
            ->paginate(20);

        return view(
            'manajemen-data',
            compact('data')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Form Tambah Data
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        return view('data-create');
    }

    /*
    |--------------------------------------------------------------------------
    | Simpan Data Baru
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $request->validate([

            'tanggal' => 'required|date',

            'nama_obat' => 'required',

            'jumlah_terjual' => 'required|numeric'

        ]);

        StokObat::create([

            'tanggal' => $request->tanggal,

            'nama_obat' => $request->nama_obat,

            'jumlah_terjual' => $request->jumlah_terjual

        ]);

        return redirect('/manajemen-data')
            ->with(
                'success',
                'Data berhasil ditambahkan'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | Form Edit
    |--------------------------------------------------------------------------
    */

    public function edit($id)
    {
        $data = StokObat::findOrFail($id);

        return view(
            'data-edit',
            compact('data')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Update Data
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        $id
    )
    {
        $request->validate([

            'tanggal' => 'required|date',

            'nama_obat' => 'required',

            'jumlah_terjual' => 'required|numeric'

        ]);

        $data = StokObat::findOrFail($id);

        $data->update([

            'tanggal' => $request->tanggal,

            'nama_obat' => $request->nama_obat,

            'jumlah_terjual' => $request->jumlah_terjual

        ]);

        return redirect('/manajemen-data')
            ->with(
                'success',
                'Data berhasil diperbarui'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | Hapus Data
    |--------------------------------------------------------------------------
    */

    public function destroy($id)
    {
        $data = StokObat::findOrFail($id);

        $data->delete();

        return redirect('/manajemen-data')
            ->with(
                'success',
                'Data berhasil dihapus'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | Import CSV
    |--------------------------------------------------------------------------
    */

    public function import(Request $request)
    {
        $request->validate([

            'file' => 'required|mimes:csv,txt'

        ]);

        $file = fopen(
            $request
                ->file('file')
                ->getRealPath(),
            'r'
        );

        /*
        | Skip Header CSV
        */

        fgetcsv($file);

        while (
            ($row = fgetcsv($file))
            !== false
        ) {

            if (
                count($row) < 3
            ) {
                continue;
            }

            StokObat::create([

                'tanggal' => trim($row[0]),

                'nama_obat' => trim($row[1]),

                'jumlah_terjual' =>
                    (int) trim($row[2])

            ]);
        }

        fclose($file);

        return redirect()
            ->back()
            ->with(
                'success',
                'CSV berhasil diimport'
            );
    }
}
