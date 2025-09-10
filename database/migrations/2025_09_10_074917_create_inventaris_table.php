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
        Schema::create('inventaris', function (Blueprint $table) {
            $table->id();
            $table->string('nama_barang');
            $table->text('deskripsi')->nullable();
            $table->enum('kategori', ['alat_cukur', 'produk_perawatan', 'furniture', 'elektronik', 'lainnya']);
            $table->integer('stok_minimal');
            $table->integer('stok_saat_ini');
            $table->decimal('harga_satuan', 12, 2);
            $table->string('satuan'); // pcs, botol, tube, dll
            $table->string('merek')->nullable();
            $table->date('tanggal_kadaluarsa')->nullable();
            $table->enum('status', ['tersedia', 'habis', 'hampir_habis', 'kadaluarsa'])->default('tersedia');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventaris');
    }
};
