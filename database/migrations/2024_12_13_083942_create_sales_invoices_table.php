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
        Schema::create('sales_invoices', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_invoice')->nullable();
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('quotation_id')->nullable();
            $table->unsignedBigInteger('sales_order_id')->nullable();
            $table->date('tanggal_invoice');
            $table->date('tanggal_pembayaran_invoice');
            $table->foreignId('pembayaran_id')->constrained('pembayarans')->onDelete('cascade');
            $table->enum('status', ['Draft', 'Not Paid', 'Paid'])->default('Draft'); 
            $table->timestamps();

            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->foreign('quotation_id')->references('id')->on('quotations')->onDelete('cascade');
            $table->foreign('sales_order_id')->references('id')->on('sales_orders')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_invoices');
    }
};
