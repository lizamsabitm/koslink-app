<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'boarding_house_id', 'rating', 'body'];

    // Relasi: Review ini milik siapa?
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi: Review ini untuk kos mana?
    public function boardingHouse()
    {
        return $this->belongsTo(BoardingHouse::class);
    }
}
