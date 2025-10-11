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
        Schema::table('kapster', function (Blueprint $table) {
            // Drop old komisi_persen if exists (optional)
            // $table->dropColumn('komisi_persen');

            // Add 3 new commission fields
            $table->decimal('komisi_potong_rambut', 5, 2)->default(40.00)->after('status')->comment('Komisi untuk layanan potong rambut (%)');
            $table->decimal('komisi_layanan_lain', 5, 2)->default(25.00)->after('komisi_potong_rambut')->comment('Komisi untuk layanan lain (%)');
            $table->decimal('komisi_produk', 5, 2)->default(25.00)->after('komisi_layanan_lain')->comment('Komisi untuk penjualan produk (%)');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kapster', function (Blueprint $table) {
            $table->dropColumn(['komisi_potong_rambut', 'komisi_layanan_lain', 'komisi_produk']);
        });
    }
};
