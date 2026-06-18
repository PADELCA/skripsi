<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\StokObat;

class StokObatSeeder extends Seeder
{
    public function run()
    {
        $path = base_path('database/dataset_penjualan_apotek.csv');
        $handle = fopen($path, 'r');
        fgetcsv($handle); // Lewati header

        $data = [];
        while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
            // Cek jika baris kosong agar tidak error
            if (empty($row)) continue;

            $data[] = [
                'tanggal'        => $row,
                'nama_obat'      => $row[1],
                'jumlah_terjual' => (int)$row[2],
                'created_at'     => now(),
                'updated_at'     => now(),
            ];
        }
        fclose($handle);

        // Gunakan chunk agar tidak membebani memori jika data banyak
        foreach (array_chunk($data, 100) as $chunk) {
            StokObat::insert($chunk);
        }
    }
}