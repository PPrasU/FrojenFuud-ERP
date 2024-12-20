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
        Schema::create('request_for_quotation_bahans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('request_for_quotation_id');
            $table->unsignedBigInteger('bahan_id');
            $table->decimal('kuantitas', 8, 2);
            $table->string('satuan');
            $table->enum('received', ['Belum', 'Sudah'])->default('Belum')->change();
            $table->timestamps();
        
            // Add foreign keys
            $table->foreign('request_for_quotation_id')->references('id')->on('request_for_quotations')->onDelete('cascade');//untuk mengambil id dari bill of material
            $table->foreign('bahan_id')->references('id')->on('bahans')->onDelete('cascade');//untuk mengambil id bahan lewat bill of material
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('request_for_quotation_bahans');
    }
};
