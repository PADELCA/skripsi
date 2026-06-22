<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HasilPrediksi extends Model
{
    protected $fillable = [

        'nama_obat',

        'forecast',

        'rekomendasi',

        'tanggal_prediksi'

    ];
}