<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('stok_obats', function (Blueprint $table) {
            $table->id();
            $table->string('nama_obat');
            // jumlah_stok sudah dihapus
            $table->integer('jumlah_terjual'); // Ini adalah variabel yang dibutuhkan AI
            $table->date('tanggal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stok_obats');
    }
};