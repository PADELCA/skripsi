<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\StokObat;

class StokObatSeeder extends Seeder
{
    public function run()
    {
        $file = base_path('database/dataset_penjualan_apotek.csv');
        $handle = fopen($file, 'r');
        fgetcsv($handle); // Lewati header

        $rows = [];
        while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
            // Kita pastikan $row adalah array dan punya 3 kolom
            if (is_array($row) && count($row) >= 3) {
                $rows[] = [
                    'tanggal'        => $row,
                    'nama_obat'      => $row,
                    'jumlah_terjual' => (int)$row,
                    'created_at'     => now(),
                    'updated_at'     => now(),
                ];
            }
        }
        fclose($handle);

        // Langsung insert ke database
        StokObat::insert($rows);
    }
}