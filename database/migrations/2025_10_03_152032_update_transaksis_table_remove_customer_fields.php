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
        Schema::table('transaksis', function (Blueprint $table) {
            // Drop unnecessary columns
            $table->dropColumn(['nama_pelanggan', 'telepon_pelanggan', 'waktu_mulai', 'waktu_selesai']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaksis', function (Blueprint $table) {
            // Restore columns if needed
            $table->string('nama_pelanggan')->after('nomor_transaksi');
            $table->string('telepon_pelanggan')->nullable()->after('nama_pelanggan');
            $table->time('waktu_mulai')->nullable()->after('tanggal_transaksi');
            $table->time('waktu_selesai')->nullable()->after('waktu_mulai');
        });
    }
};
