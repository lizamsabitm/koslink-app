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
            $table->string('nama_kos');
            $table->string('jenis_kos');
            $table->string('slug')->nullable();
            
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); 
            
            $table->text('deskripsi'); 
            $table->text('alamat'); 
            $table->string('foto_utama')->nullable(); 
            
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('boarding_houses');
    }
};
