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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            // 1. Siapa yang komen? (Relasi ke tabel users)
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // 2. Kos mana yang dikomen? (Relasi ke tabel boarding_houses)
            $table->foreignId('boarding_house_id')->constrained()->onDelete('cascade');
            
            // 3. Bintang berapa? (Integer 1-5)
            $table->integer('rating');
            
            // 4. Isi komentarnya apa? (Boleh kosong kalau cuma mau kasih bintang)
            $table->text('body')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
