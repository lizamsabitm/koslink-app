<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    // 1. Izinkan kolom-kolom ini diisi
    protected $fillable = [
        'user_id',
        'room_id',
        'tanggal_mulai',
        'durasi_sewa',
        'total_harga',
        'bukti_bayar',
        'status', // (MENUNGGU, LUNAS, DITOLAK)
    ];

    // 2. Relasi: Transaksi ini milik Siapa? (User)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 3. Relasi: Transaksi ini sewa Kamar apa? (Room)
    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
