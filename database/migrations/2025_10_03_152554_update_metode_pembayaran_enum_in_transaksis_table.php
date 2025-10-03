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
        DB::statement("ALTER TABLE transaksis MODIFY COLUMN metode_pembayaran ENUM('tunai', 'kartu_debit', 'kartu_kredit', 'transfer', 'ewallet') DEFAULT 'tunai'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert back to original enum values
        DB::statement("ALTER TABLE transaksis MODIFY COLUMN metode_pembayaran ENUM('tunai', 'transfer', 'e-wallet', 'kartu_kredit') DEFAULT 'tunai'");
    }
};
