<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Daftarkan seeder Anda di sini agar dipanggil saat migrate:fresh --seed
        $this->call([
            StokObatSeeder::class,
        ]);
    }
}