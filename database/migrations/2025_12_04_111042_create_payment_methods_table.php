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
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            
            // PENTING: Rekening ini milik siapa?
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Detail Rekening
            $table->string('nama_bank');      // Misal: BCA, BRI, DANA
            $table->string('nomor_rekening'); // Misal: 1234567890
            $table->string('atas_nama');      // Misal: Budi Santoso
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_methods');
    }
};
