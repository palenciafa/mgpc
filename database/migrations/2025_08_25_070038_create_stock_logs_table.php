<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('stock_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->enum('type', ['in', 'out']); // stock in or out
            $table->integer('quantity');
            $table->unsignedBigInteger('supplier_id')->nullable(); // supplier for this stock batch
            $table->unsignedBigInteger('sale_id')->nullable();
            $table->decimal('buying_price', 10, 2)->nullable(); // price per unit for stock IN
            $table->decimal('total_price', 10, 2)->nullable(); // total price for stock OUT (sales)
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamps();

            // Foreign keys
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('supplier_id')->references(columns: 'id')->on('suppliers')->onDelete('set null');
            $table->foreign('sale_id')->references('id')->on('sales')->onDelete('set null');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_logs');
    }
};
