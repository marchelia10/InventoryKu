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
        Schema::create('devices', function (Blueprint $table) {
            $table->id();
            $table->string('nama_perangkat');
            $table->string('merek')->nullable();
            $table->enum('kondisi', ['Baik', 'Cukup Baik', 'Rusak Ringan', 'Rusak Berat'])->default('Baik');
            $table->date('tanggal_pengadaan')->nullable();
            $table->string('jenis_perangkat')->nullable();
            $table->string('nomor_seri')->unique();
            $table->enum('status', ['Tersedia', 'Dipinjam', 'Perbaikan'])->default('Tersedia');
            $table->string('foto')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devices');
    }
};
