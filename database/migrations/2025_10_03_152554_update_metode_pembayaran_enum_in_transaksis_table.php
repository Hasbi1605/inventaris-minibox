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
        // Change metode_pembayaran enum to include all payment methods
        // SQLite does not support MODIFY/ALTER for ENUM columns, so only run for MySQL/MariaDB
        $driver = Schema::getConnection()->getDriverName();
        if (in_array($driver, ['mysql', 'mariadb'])) {
            DB::statement("ALTER TABLE transaksis MODIFY COLUMN metode_pembayaran ENUM('tunai', 'kartu_debit', 'kartu_kredit', 'transfer', 'ewallet') DEFAULT 'tunai'");
        } else {
            // For sqlite, altering enum is not supported. Skip or implement a table-recreation if necessary.
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert back to original enum values
        $driver = Schema::getConnection()->getDriverName();
        if (in_array($driver, ['mysql', 'mariadb'])) {
            DB::statement("ALTER TABLE transaksis MODIFY COLUMN metode_pembayaran ENUM('tunai', 'transfer', 'e-wallet', 'kartu_kredit') DEFAULT 'tunai'");
        } else {
            // For sqlite, skip.
        }
    }
};
