<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Transaction;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'boarding_house_id' => 'required|exists:boarding_houses,id',
            'rating' => 'required|integer|min:1|max:5',
            'body' => 'nullable|string|max:500',
        ]);

        $cekTransaksi = Transaction::where('user_id', auth()->id())
                        ->where('status', 'LUNAS')
                        ->whereHas('room', function($q) use ($request) {
                            $q->where('boarding_house_id', $request->boarding_house_id);
                        })
                        ->exists();

        if (!$cekTransaksi) {
            return back()->with('error', 'Eits! Kamu harus punya transaksi LUNAS di kos ini untuk memberi ulasan.');
        }
        Review::create([
            'user_id' => auth()->id(),
            'boarding_house_id' => $request->boarding_house_id,
            'rating' => $request->rating,
            'body' => $request->body,
        ]);

        return back()->with('success', 'Terima kasih! Ulasanmu berhasil dikirim.');
    }
}
