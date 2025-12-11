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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('boarding_house_id')->constrained()->onDelete('cascade');
            $table->string('nama_kamar'); 
            $table->integer('harga_per_bulan'); 
            $table->text('fasilitas'); 
            $table->integer('stok_kamar'); 
            $table->string('foto_kamar')->nullable();

            // 👇👇👇 TAMBAHKAN BARIS INI DI SINI 👇👇👇
            $table->boolean('is_available')->default(true); 

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
