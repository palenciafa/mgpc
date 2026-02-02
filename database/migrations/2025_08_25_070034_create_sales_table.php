<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();

            // Matches: Sale::where('product_id', ...)
            $table->foreignId('product_id')
                  ->constrained()
                  ->cascadeOnDelete();

            // Used in export: $sale->customer_name
            $table->string('customer_name')->nullable();

            // Used in export: ->where('quantity', $log->quantity)
            $table->integer('quantity');

            // Used in export: $log->total_price
            $table->decimal('total_price', 10, 2);

            // Used in export: ->whereDate('created_at', ...)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
