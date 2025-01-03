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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('nama'); 
            $table->string('no_hp');
            $table->string('alamat_1');
            $table->string('alamat_2');
            $table->string('email');
            $table->string('kategori');
            $table->bigInteger('pesanan')->default(0);
            $table->bigInteger('pembelian')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
