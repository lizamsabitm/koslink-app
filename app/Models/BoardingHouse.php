<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BoardingHouse extends Model
{
    use HasFactory;

    // IZINKAN KOLOM INI DIISI
    protected $fillable = [
        'user_id',
        'nama_kos',
        'jenis_kos',
        'slug',
        'alamat',
        'latitude',  // <--- TAMBAHAN BARU
        'longitude',
        'deskripsi',
        'foto_utama',
        'status',
    ];

    // Relasi ke User (Pemilik)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Kamar
    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    // Relasi: Kos punya banyak Review
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
