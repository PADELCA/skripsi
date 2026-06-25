<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\StokObat;

class DataController extends Controller
{
    public function index(Request $request)
    {
        $query = StokObat::query();

        if ($request->filled('search')) {
            $query->where('nama_obat','like','%'.$request->search.'%');
        }

        $data = $query->orderByDesc('tanggal')->paginate(20)->withQueryString();

        $totalObat = StokObat::distinct('nama_obat')->count('nama_obat');
        $totalPenjualan = StokObat::sum('jumlah_terjual');
        $totalData = StokObat::count();
        $dataTerbaru = StokObat::max('tanggal');
        $dataTerlama = StokObat::min('tanggal');
        $rataPenjualan = round(StokObat::avg('jumlah_terjual'),2);
        $penjualanMaks = StokObat::max('jumlah_terjual');
        $penjualanMin = StokObat::min('jumlah_terjual');

        $missingValue = StokObat::whereNull('tanggal')
            ->orWhereNull('nama_obat')
            ->orWhereNull('jumlah_terjual')
            ->count();

        $duplicateData = DB::table('stok_obats')
            ->select('tanggal','nama_obat')
            ->groupBy('tanggal','nama_obat')
            ->havingRaw('COUNT(*)>1')
            ->count();

        $chart = DB::table('stok_obats')
            ->select('nama_obat',DB::raw('SUM(jumlah_terjual) total'))
            ->groupBy('nama_obat')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        $chartLabels = $chart->pluck('nama_obat');
        $chartValues = $chart->pluck('total');
        $preview = StokObat::latest('tanggal')->take(5)->get();

        $statusDataset = ($missingValue==0 && $duplicateData==0)
            ? 'Dataset Siap Digunakan'
            : 'Perlu Validasi';

        return view('manajemen-data', compact(
            'data','totalObat','totalPenjualan','totalData',
            'dataTerbaru','dataTerlama','rataPenjualan',
            'penjualanMaks','penjualanMin','missingValue',
            'duplicateData','chartLabels','chartValues',
            'preview','statusDataset'
        ));
    }

    public function create(){ return view('data-create'); }

    public function store(Request $request)
    {
        $validated=$request->validate([
            'tanggal'=>'required|date',
            'nama_obat'=>'required|string|max:255',
            'jumlah_terjual'=>'required|integer|min:0'
        ]);

        StokObat::create($validated);

        return redirect('/manajemen-data')->with('success','Data historis berhasil ditambahkan.');
    }

    public function edit($id)
    {
        return view('data-edit',['data'=>StokObat::findOrFail($id)]);
    }

    public function update(Request $request,$id)
    {
        $validated=$request->validate([
            'tanggal'=>'required|date',
            'nama_obat'=>'required|string|max:255',
            'jumlah_terjual'=>'required|integer|min:0'
        ]);

        StokObat::findOrFail($id)->update($validated);

        return redirect('/manajemen-data')->with('success','Data historis berhasil diperbarui.');
    }

    public function destroy($id)
    {
        StokObat::findOrFail($id)->delete();
        return redirect('/manajemen-data')->with('success','Data historis berhasil dihapus.');
    }

    public function import(Request $request)
    {
        $request->validate(['file'=>'required|mimes:csv,txt']);

        $file=fopen($request->file('file')->getRealPath(),'r');
        fgetcsv($file);

        $berhasil=0;
        $duplikat=0;

        while(($row=fgetcsv($file))!==false){
            if(count($row)<3) continue;

            $tanggal=trim($row[0]);
            $nama=trim($row[1]);
            $jumlah=(int)trim($row[2]);

            if(StokObat::where('tanggal',$tanggal)->where('nama_obat',$nama)->exists()){
                $duplikat++;
                continue;
            }

            StokObat::create([
                'tanggal'=>$tanggal,
                'nama_obat'=>$nama,
                'jumlah_terjual'=>$jumlah
            ]);

            $berhasil++;
        }

        fclose($file);

        return redirect('/manajemen-data')
            ->with('success',"Import selesai. {$berhasil} data ditambahkan, {$duplikat} data duplikat dilewati.");
    }
}
