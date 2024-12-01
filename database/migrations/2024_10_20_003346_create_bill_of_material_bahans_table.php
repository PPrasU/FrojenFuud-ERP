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
        Schema::create('bill_of_material_bahan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bill_of_material_id');
            $table->unsignedBigInteger('bahan_id');
            $table->decimal('kuantitas', 8, 2);
            $table->string('satuan');
            $table->timestamps();        
        
            // Add foreign keys
            $table->foreign('bill_of_material_id')->references('id')->on('bill_of_materials')->onDelete('cascade');//untuk mengambil id dari bill of material
            $table->foreign('bahan_id')->references('id')->on('bahans')->onDelete('cascade');//untuk mengambil id bahan lewat bill of material
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bill_of_material_bahan');
    }
};
