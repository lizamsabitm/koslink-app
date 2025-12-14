<?php

namespace App\Http\Controllers;

use App\Models\BoardingHouse;
use App\Models\Transaction;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    // 1. TAMPILKAN HALAMAN KASIR (CHECKOUT)
    public function showCheckout($slug)
    {
        // 1. Cari kos, tapi sekalian bawa data Pemilik & Rekening Bank-nya
        $kos = BoardingHouse::where('slug', $slug)
                ->with(['user.paymentMethods'])
                ->firstOrFail();
        
        // 2. Ambil kamar
        $kamar = $kos->rooms->first();

        // 3. Cek stok
        if($kamar->stok_kamar < 1) {
            return back()->with('error', 'Yah, kamar ini sudah penuh!');
        }
        
        // 4. Ambil daftar rekening milik juragan ini
        $rekeningJuragan = $kos->user->paymentMethods;

        // 5. Kirim semua data ke tampilan
        return view('transaction.checkout', compact('kos', 'kamar', 'rekeningJuragan'));
    }

    // 2. PROSES PEMBAYARAN (SIMPAN TRANSAKSI)
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'start_date' => 'required|date',
            'duration' => 'required|integer|min:1|max:12',
        ]);

        // Ambil data kamar untuk hitung harga
        $kamar = Room::find($request->room_id);

        // Cek stok lagi (double check biar aman)
        if($kamar->stok_kamar < 1) {
            return back()->with('error', 'Maaf, kamar baru saja habis terjual!');
        }

        // Hitung Total Harga
        $totalHarga = $kamar->harga_per_bulan * $request->duration;

        // SIMPAN KE DATABASE TRANSAKSI
        Transaction::create([
            'user_id' => Auth::id(),        
            'room_id' => $kamar->id,        
            'tanggal_mulai' => $request->start_date,
            'durasi_sewa' => $request->duration,
            'total_harga' => $totalHarga,
            'status' => 'MENUNGGU',       
        ]);

        // KURANGI STOK KAMAR OTOMATIS
        $kamar->decrement('stok_kamar');

        // Lempar ke halaman riwayat
        return redirect()->route('booking.history')
            ->with('success', 'Booking berhasil! Silakan lakukan pembayaran.');
    }

    // 3. HALAMAN RIWAYAT (TIKET SAYA)
    public function history()
    {
        // Ambil semua transaksi milik user yang sedang login
        $transaksi = Transaction::where('user_id', Auth::id())
                        ->with(['room.boardingHouse'])
                        ->latest()
                        ->get();

        return view('transaction.history', compact('transaksi'));
    }
    // FUNGSI UPLOAD BUKTI BAYAR
    public function uploadBukti(Request $request, $id)
    {
        // 1. Validasi (Harus ada file gambar)
        $request->validate([
            'bukti_bayar' => 'required|image|max:2048',
        ]);

        // 2. Cari transaksi milik user ini
        $transaksi = Transaction::where('id', $id)
                        ->where('user_id', Auth::id())
                        ->firstOrFail();

        // 3. Simpan foto ke folder 'public/storage/bukti-bayar'
        $path = $request->file('bukti_bayar')->store('bukti-bayar', 'public');

        // 4. Update database
        $transaksi->update([
            'bukti_bayar' => 'storage/' . $path,
            'status' => 'MENUNGGU VERIFIKASI'
        ]);

        return back()->with('success', 'Bukti bayar berhasil diupload! Tunggu konfirmasi pemilik kos.');
    }
}
