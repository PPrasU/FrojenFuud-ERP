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
        Schema::create('sales_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quotation_id')->constrained('quotations')->onDelete('cascade'); 
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade'); 
            $table->foreignId('pembayaran_id')->constrained('pembayarans')->onDelete('cascade'); 
            
            $table->enum('status', ['To Invoiced', 'Fully Invoiced', 'Cancelled'])->default('To Invoiced'); 
            $table->enum('pengiriman', ['Belum', 'Tervalidasi', 'Tidak Memenuhi', 'Selesai'])->default('Belum'); 
            $table->enum('penagihan', ['Belum', 'Sudah Dibuat'])->default('Belum');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_orders');
    }
};
