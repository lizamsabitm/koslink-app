<?php

namespace App\Http\Controllers;

use App\Models\BoardingHouse;
use App\Models\Transaction;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function showCheckout($slug)
    {
        $kos = BoardingHouse::where('slug', $slug)
                ->with(['user.paymentMethods'])
                ->firstOrFail();
        
        $kamar = $kos->rooms->first();

        if($kamar->stok_kamar < 1) {
            return back()->with('error', 'Yah, kamar ini sudah penuh!');
        }
        
        $rekeningJuragan = $kos->user->paymentMethods;

        return view('transaction.checkout', compact('kos', 'kamar', 'rekeningJuragan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'start_date' => 'required|date',
            'duration' => 'required|integer|min:1|max:12',
        ]);

        $kamar = Room::find($request->room_id);

        if($kamar->stok_kamar < 1) {
            return back()->with('error', 'Maaf, kamar baru saja habis terjual!');
        }

        $totalHarga = $kamar->harga_per_bulan * $request->duration;

        Transaction::create([
            'user_id' => Auth::id(),        
            'room_id' => $kamar->id,        
            'tanggal_mulai' => $request->start_date,
            'durasi_sewa' => $request->duration,
            'total_harga' => $totalHarga,
            'status' => 'MENUNGGU',       
        ]);

        $kamar->decrement('stok_kamar');

        return redirect()->route('booking.history')
            ->with('success', 'Booking berhasil! Silakan lakukan pembayaran.');
    }

    public function history()
    {

        $transaksi = Transaction::where('user_id', Auth::id())
                        ->with(['room.boardingHouse'])
                        ->latest()
                        ->get();

        return view('transaction.history', compact('transaksi'));
    }

    public function uploadBukti(Request $request, $id)
    {
        $request->validate([
            'bukti_bayar' => 'required|image|max:2048',
        ]);

        $transaksi = Transaction::where('id', $id)
                        ->where('user_id', Auth::id())
                        ->firstOrFail();

        $uploadedFileUrl = cloudinary()->upload($request->file('bukti_bayar')->getRealPath(), ['folder' => 'koslink/bukti-bayar'])->getSecurePath();

            $transaksi->update([
             'bukti_bayar' => $uploadedFileUrl,
                'status' => 'MENUNGGU VERIFIKASI'
                    ]);

        return back()->with('success', 'Bukti bayar berhasil diupload! Tunggu konfirmasi pemilik kos.');
    }
}
