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
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('device_id')->nullable()->constrained('devices')->onDelete('set null');            $table->string('jenis_barang');
            $table->integer('jumlah_barang')->default(1);
            $table->date('tanggal_peminjaman');
            $table->date('tanggal_pengembalian')->nullable();
            $table->enum('status', ['Menunggu Verifikasi', 'Disetujui', 'Ditolak', 'Menunggu Pengembalian', 'Dikembalikan'])->default('Menunggu Verifikasi');
            $table->text('catatan_admin')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};
