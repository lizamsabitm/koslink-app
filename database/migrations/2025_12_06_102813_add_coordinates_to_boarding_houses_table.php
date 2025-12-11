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
        Schema::table('boarding_houses', function (Blueprint $table) {
            // Tambahkan kolom Latitude & Longitude setelah kolom alamat
            // Kita buat 'nullable' supaya kos lama yang belum punya peta tidak error
            $table->double('latitude')->nullable()->after('alamat');
            $table->double('longitude')->nullable()->after('latitude');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('boarding_houses', function (Blueprint $table) {
            // Kalau di-rollback, hapus kolomnya
            $table->dropColumn(['latitude', 'longitude']);
        });
    }
};
