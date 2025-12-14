<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\BoardingHouse;
use App\Models\Transaction;

class AdminController extends Controller
{
    // 1. LIHAT SEMUA USER
    public function users()
    {
        // Cek apakah yang akses beneran Admin?
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Anda bukan Admin!');
        }

        // Ambil semua user KECUALI admin itu sendiri (biar gak sengaja hapus diri sendiri)
        $users = User::where('role', '!=', 'admin')->latest()->get();

        return view('admin.users', compact('users'));
    }

    // 2. HAPUS USER (BANNED)
    public function destroyUser($id)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Akses Ditolak');
        }

        // Cari user
        $user = User::findOrFail($id);

        // Hapus user
        $user->delete();

        return back()->with('success', 'User berhasil dihapus dari sistem.');
    }

    // 3. DAFTAR KOS MENUNGGU PERSETUJUAN
    public function kosValidation()
    {
        // Ambil hanya yang statusnya PENDING
        $pendingKos = BoardingHouse::where('status', 'pending')
                        ->with(['user', 'rooms']) // Bawa data pemilik & harga
                        ->latest()
                        ->get();

        return view('admin.kos_validation', compact('pendingKos'));
    }

    // 4. SETUJUI / TOLAK KOS
    public function approveKos(Request $request, $slug)
    {
        $kos = BoardingHouse::where('slug', $slug)->firstOrFail();

        // Cek tombol mana yang diklik (Approve / Reject)
        if ($request->action == 'approve') {
            $kos->update(['status' => 'approved']);
            $message = 'Kos berhasil disetujui dan tayang di halaman depan!';
        } else {
            $kos->update(['status' => 'rejected']);
            $message = 'Kos ditolak dan dikembalikan ke Juragan.';
        }

        return back()->with('success', $message);
    }

    // 5. MONITORING SEMUA TRANSAKSI
    public function transactions()
    {
        // Ambil SEMUA transaksi, urutkan dari yang terbaru
        $transaksi = Transaction::with(['user', 'room.boardingHouse.user'])->latest()->get();

        return view('admin.transactions', compact('transaksi'));
    }
}
