<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\StokObat;
use Illuminate\Support\Facades\File;

class StokObatSeeder extends Seeder
{
    public function run(): void
    {
        $file = database_path('dataset_penjualan_apotek.csv');

        if (!File::exists($file)) {
            $this->command->error("File CSV tidak ditemukan!");
            return;
        }

        $handle = fopen($file, 'r');

        // Lewati header
        fgetcsv($handle);

        $rows = [];

        while (($row = fgetcsv($handle, 1000, ",")) !== false) {

            if (!is_array($row) || count($row) < 3) {
                continue;
            }

            $tanggal = trim($row[0]);
            $namaObat = trim($row[1]);
            $jumlah = (int) trim($row[2]);

            $rows[] = [
                'tanggal'        => $tanggal,
                'nama_obat'      => $namaObat,
                'jumlah_terjual' => $jumlah,
                'created_at'     => now(),
                'updated_at'     => now(),
            ];
        }

        fclose($handle);

        if (!empty($rows)) {



            StokObat::insert($rows);

            $this->command->info(
                "Berhasil mengimpor " . count($rows) . " data."
            );
        }
    }
}