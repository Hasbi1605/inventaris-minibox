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
        Schema::create('inventory_movements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['in', 'out', 'adjustment']); // masuk, keluar, penyesuaian
            $table->integer('quantity');
            $table->integer('stock_before'); // stock sebelum perubahan
            $table->integer('stock_after'); // stock setelah perubahan
            $table->decimal('unit_cost', 10, 2)->nullable(); // untuk stock in
            $table->string('reference_type')->nullable(); // transaction, purchase, adjustment
            $table->unsignedBigInteger('reference_id')->nullable(); // ID referensi
            $table->text('notes')->nullable();
            $table->timestamp('movement_date');
            $table->timestamps();

            $table->index(['product_id', 'movement_date']);
            $table->index(['reference_type', 'reference_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_movements');
    }
};
