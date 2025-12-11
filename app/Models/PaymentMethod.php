<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama_bank',
        'nomor_rekening',
        'atas_nama',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
