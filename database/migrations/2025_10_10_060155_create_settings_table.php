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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value');
            $table->string('group')->default('general'); // 'komisi', 'general', dll
            $table->string('type')->default('string'); // 'string', 'number', 'boolean'
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // Insert default komisi settings
        DB::table('settings')->insert([
            [
                'key' => 'komisi_potong_rambut',
                'value' => '40',
                'group' => 'komisi',
                'type' => 'number',
                'description' => 'Persentase komisi untuk layanan kategori Potong Rambut',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'komisi_layanan_lain',
                'value' => '25',
                'group' => 'komisi',
                'type' => 'number',
                'description' => 'Persentase komisi untuk layanan kategori selain Potong Rambut',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'komisi_produk',
                'value' => '25',
                'group' => 'komisi',
                'type' => 'number',
                'description' => 'Persentase komisi untuk penjualan produk retail',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
