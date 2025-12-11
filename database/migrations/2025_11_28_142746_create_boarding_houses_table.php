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
        Schema::create('boarding_houses', function (Blueprint $table) {
            $table->id();
            // --- INI KOLOM BARU UNTUK PROFIL KOS ---
            $table->string('nama_kos'); // Nama Kos (Sesuai PDF)
            $table->string('slug')->nullable(); // Untuk link URL
            
            // Ini menghubungkan Kos dengan Pemiliknya (User ID)
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); 
            
            $table->text('deskripsi'); // Penjelasan kos
            $table->text('alamat'); // Lokasi (Sesuai PDF)
            $table->string('foto_utama')->nullable(); // Foto Depan (Sesuai PDF)
            
            // Kolom Status untuk Admin memvalidasi kos (Pending/Approved)
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('boarding_houses');
    }
};
