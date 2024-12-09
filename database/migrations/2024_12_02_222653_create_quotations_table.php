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
        Schema::create('quotations', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_quotation')->unique(); 
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade'); 
            $table->date('tanggal_quotation'); 
            $table->date('berlaku_hingga')->nullable(); 
            $table->enum('status', ['Draft', 'Sent', 'Confirmed to Sales Order', 'Cancelled'])->default('Draft'); 
            $table->foreignId('pembayaran_id')->constrained('pembayarans')->onDelete('cascade'); 
            $table->decimal('total_sebelum_pajak', 15, 4)->default(0);
            $table->decimal('total_pajak', 15, 4)->default(0);
            $table->decimal('total_keseluruhan', 15, 4)->default(0);
            $table->timestamps(); 
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotations');
    }
};
