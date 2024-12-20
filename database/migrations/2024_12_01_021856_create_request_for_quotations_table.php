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
        Schema::create('request_for_quotations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vendor_id');
            $table->string('reference');
            $table->string('vendor_reference');
            $table->date('tanggal');
            $table->decimal('total', 15, 2)->default(0);
            $table->string('company');
            $table->enum('status', ['RFQ', 'RFQ Sent', 'PO', 'Cancelled'])->default('RFQ');
            $table->enum('status_po', ['Nothing to bill', 'Waiting to bill', 'Fully billed', 'Cancelled'])->default('Nothing to bill');
            $table->enum('status_bill', ['Draft', 'Not Paid', 'Paid', 'Cancelled'])->default('Draft');
            $table->enum('received', ['Belum', 'Sudah', 'Cancelled'])->default('Belum');
            $table->enum('billed', ['Belum', 'Sudah', 'Cancelled'])->default('Belum');
            $table->timestamps();

            $table->foreign('vendor_id')->references('id')->on('produks')->onDelete('cascade');
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('request_for_quotations');
    }
};
