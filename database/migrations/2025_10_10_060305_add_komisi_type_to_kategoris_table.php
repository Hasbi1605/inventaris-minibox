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
        Schema::table('kategoris', function (Blueprint $table) {
            $table->enum('komisi_type', ['potong_rambut', 'layanan_lain'])
                ->default('layanan_lain')
                ->after('tipe_penggunaan')
                ->comment('Tipe komisi: potong_rambut = 40%, layanan_lain = 25%');
        });

        // Update existing data - set "Potong Rambut" kategori
        DB::table('kategoris')
            ->where('nama_kategori', 'LIKE', '%Potong%')
            ->orWhere('nama_kategori', 'LIKE', '%Rambut%')
            ->orWhere('nama_kategori', 'LIKE', '%Haircut%')
            ->orWhere('nama_kategori', 'LIKE', '%Gunting%')
            ->update(['komisi_type' => 'potong_rambut']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kategoris', function (Blueprint $table) {
            $table->dropColumn('komisi_type');
        });
    }
};
