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
        Schema::create('kategoris', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kategori');
            $table->string('kode_kategori')->unique();
            $table->text('deskripsi')->nullable();
            $table->enum('jenis_kategori', ['inventaris', 'layanan', 'pengeluaran', 'cabang', 'transaksi']);
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->integer('urutan')->default(0);
            $table->boolean('status')->default(true);
            $table->string('warna', 7)->nullable()->comment('Hex color code');
            $table->string('ikon')->nullable()->comment('Icon class name');
            $table->timestamps();

            // Foreign key untuk parent kategori
            $table->foreign('parent_id')->references('id')->on('kategoris')->onDelete('cascade');

            // Index untuk performa
            $table->index(['jenis_kategori', 'status']);
            $table->index(['parent_id', 'urutan']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kategoris');
    }
};
