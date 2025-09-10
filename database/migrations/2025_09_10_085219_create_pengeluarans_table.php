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
        Schema::create('pengeluarans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pengeluaran');
            $table->string('kategori');
            $table->decimal('jumlah', 12, 2);
            $table->date('tanggal_pengeluaran');
            $table->text('deskripsi')->nullable();
            $table->string('bukti_pengeluaran')->nullable(); // for file uploads
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengeluarans');
    }
};
