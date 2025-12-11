<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    // IZINKAN KOLOM INI DIISI
    protected $fillable = [
        'boarding_house_id',
        'nama_kamar',
        'fasilitas',
        'harga_per_bulan',
        'stok_kamar',
        'is_available',
    ];

    public function boardingHouse()
    {
        return $this->belongsTo(BoardingHouse::class);
    }
}
