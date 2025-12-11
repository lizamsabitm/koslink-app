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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Penyewa
            $table->foreignId('room_id')->constrained()->onDelete('cascade'); // Kamar
            $table->date('tanggal_mulai');
            $table->integer('durasi_sewa'); // Berapa bulan
            $table->integer('total_harga');
            $table->string('bukti_bayar')->nullable(); // Sesuai PDF (Upload Bukti)
            // Status Booking
            $table->enum('status', ['pending', 'paid', 'approved', 'rejected'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
