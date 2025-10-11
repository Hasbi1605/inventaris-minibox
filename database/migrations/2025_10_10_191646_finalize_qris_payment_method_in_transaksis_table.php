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
        // This migration runs AFTER the enum has been changed to include 'qris'
        // We don't need to do anything here since we already converted to 'transfer'
        // Users can manually change to 'qris' if needed, or we keep them as 'transfer'
        echo "Payment methods finalized. Old digital payments (kartu_debit, kartu_kredit, ewallet) are now 'transfer'.\n";
        echo "Users can use 'qris' for new digital payments.\n";
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Nothing to rollback
    }
};
