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
        Schema::create('cabang', function (Blueprint $table) {
            $table->id();
            $table->string('nama_cabang');
            $table->text('alamat');
            $table->string('telepon')->nullable();
            $table->string('email')->nullable();
            $table->string('manager')->nullable();
            $table->enum('status', ['aktif', 'tidak_aktif', 'maintenance', 'renovasi'])->default('aktif');
            $table->date('tanggal_buka')->nullable();
            $table->time('jam_operasional_buka')->nullable();
            $table->time('jam_operasional_tutup')->nullable();
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cabang');
    }
};
