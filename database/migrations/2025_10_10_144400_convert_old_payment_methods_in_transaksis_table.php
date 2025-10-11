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
        // Convert old payment methods to 'transfer' first (since qris doesn't exist in enum yet)
        // kartu_debit, kartu_kredit, ewallet -> transfer (temporary)
        DB::table('transaksis')
            ->whereIn('metode_pembayaran', ['kartu_debit', 'kartu_kredit', 'ewallet'])
            ->update(['metode_pembayaran' => 'transfer']);

        echo "Temporarily converted old payment methods (kartu_debit, kartu_kredit, ewallet) to transfer\n";
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Rollback: convert qris back to tunai (safe default)
        // Note: We can't know which qris was originally kartu_debit/kartu_kredit/ewallet
        DB::table('transaksis')
            ->where('metode_pembayaran', 'qris')
            ->update(['metode_pembayaran' => 'tunai']);
    }
};
