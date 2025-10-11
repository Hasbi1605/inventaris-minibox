<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update enum metode_pembayaran: hapus kartu_debit, kartu_kredit, ewallet; tambah qris
        DB::statement("ALTER TABLE transaksis MODIFY COLUMN metode_pembayaran ENUM('tunai', 'transfer', 'qris') DEFAULT 'tunai'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Rollback ke enum sebelumnya
        DB::statement("ALTER TABLE transaksis MODIFY COLUMN metode_pembayaran ENUM('tunai', 'kartu_debit', 'kartu_kredit', 'transfer', 'ewallet') DEFAULT 'tunai'");
    }
};
