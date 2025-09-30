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
        Schema::create('kapster', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kapster');
            $table->foreignId('cabang_id')->constrained('cabang')->onDelete('cascade');
            $table->string('spesialisasi')->nullable(); // potongan rambut, beard, dll
            $table->enum('status', ['aktif', 'tidak_aktif'])->default('aktif');
            $table->string('telepon')->nullable();
            $table->decimal('komisi_persen', 5, 2)->default(0); // untuk perhitungan komisi
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kapster');
    }
};
