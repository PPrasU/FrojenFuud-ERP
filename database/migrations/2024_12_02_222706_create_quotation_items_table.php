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
        Schema::create('quotation_items', function (Blueprint $table) {
            $table->id(); 
            $table->foreignId('quotation_id')->constrained('quotations')->onDelete('cascade'); 
            $table->foreignId('produk_id')->constrained('produks')->onDelete('cascade');
            $table->integer('kuantitas');
            $table->decimal('harga', 15, 4); 
            $table->decimal('tax', 15, 4)->default(0.00); 
            $table->decimal('subtotal', 15, 4); 
            $table->timestamps(); 
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotation_items');
    }
};
