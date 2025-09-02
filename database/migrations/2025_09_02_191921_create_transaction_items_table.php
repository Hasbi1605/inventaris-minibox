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
        Schema::create('transaction_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaction_id')->constrained()->onDelete('cascade');
            $table->enum('item_type', ['service', 'product']);
            $table->unsignedBigInteger('item_id'); // service_id atau product_id
            $table->string('item_name'); // snapshot nama item saat transaksi
            $table->decimal('unit_price', 10, 2);
            $table->decimal('unit_cost', 10, 2)->default(0); // untuk hitung profit
            $table->integer('quantity');
            $table->decimal('subtotal', 10, 2);
            $table->decimal('profit', 10, 2)->default(0); // keuntungan per item
            $table->timestamps();

            $table->index(['transaction_id', 'item_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_items');
    }
};
