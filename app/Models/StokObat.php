<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StokObat extends Model
{
    // Nama tabel di database Anda (sesuaikan jika berbeda)
    protected $table = 'stok_obats'; 

    // Daftar kolom yang boleh diisi (mass assignment)
    protected $fillable = [
        'nama_obat', 
        'jumlah_terjual', 
        'tanggal'
    ];

    // Jika Anda tidak menggunakan timestamps (created_at, updated_at), 
    // tambahkan baris di bawah ini:
    // public $timestamps = false;
}