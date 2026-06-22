<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hasil_prediksis', function (Blueprint $table) {

            $table->id();

            $table->string('nama_obat');

            $table->integer('forecast');

            $table->integer('rekomendasi');

            $table->date('tanggal_prediksi');

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hasil_prediksis');
    }
};