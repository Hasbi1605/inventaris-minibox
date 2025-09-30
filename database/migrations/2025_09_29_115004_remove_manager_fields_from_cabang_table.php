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
        Schema::table('cabang', function (Blueprint $table) {
            // Remove fields yang sudah tidak diperlukan
            $table->dropColumn(['manager', 'telepon', 'email', 'tanggal_buka']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cabang', function (Blueprint $table) {
            // Restore fields jika rollback
            $table->string('manager')->nullable();
            $table->string('telepon')->nullable();
            $table->string('email')->nullable();
            $table->date('tanggal_buka')->nullable();
        });
    }
};
