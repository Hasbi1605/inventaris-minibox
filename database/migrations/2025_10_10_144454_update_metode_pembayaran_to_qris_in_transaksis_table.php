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
        $driver = Schema::getConnection()->getDriverName();
        if (in_array($driver, ['mysql', 'mariadb'])) {
            DB::statement("ALTER TABLE transaksis MODIFY COLUMN metode_pembayaran ENUM('tunai', 'transfer', 'qris') DEFAULT 'tunai'");
        } else {
            // Skip for sqlite
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Rollback ke enum sebelumnya
        $driver = Schema::getConnection()->getDriverName();
        if (in_array($driver, ['mysql', 'mariadb'])) {
            DB::statement("ALTER TABLE transaksis MODIFY COLUMN metode_pembayaran ENUM('tunai', 'kartu_debit', 'kartu_kredit', 'transfer', 'ewallet') DEFAULT 'tunai'");
        } else {
            // Skip for sqlite
        }
    }
};
