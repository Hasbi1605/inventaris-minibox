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
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_transaksi')->unique();
            $table->string('nama_pelanggan');
            $table->string('telepon_pelanggan')->nullable();
            $table->foreignId('layanan_id')->constrained('layanans')->onDelete('cascade');
            $table->date('tanggal_transaksi');
            $table->time('waktu_mulai')->nullable();
            $table->time('waktu_selesai')->nullable();
            $table->decimal('total_harga', 10, 2);
            $table->enum('metode_pembayaran', ['tunai', 'transfer', 'e-wallet', 'kartu_kredit'])->default('tunai');
            $table->enum('status', ['pending', 'sedang_proses', 'selesai', 'dibatalkan'])->default('pending');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
