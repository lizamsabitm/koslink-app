<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\BoardingHouse;
use App\Models\Transaction;

class AdminController extends Controller
{
    public function users()
    {

        if (auth()->user()->role !== 'admin') {
            abort(403, 'Anda bukan Admin!');
        }

        $users = User::where('role', '!=', 'admin')->latest()->get();

        return view('admin.users', compact('users'));
    }

    public function destroyUser($id)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Akses Ditolak');
        }

        $user = User::findOrFail($id);

        $user->delete();

        return back()->with('success', 'User berhasil dihapus dari sistem.');
    }

    public function kosValidation()
    {
        $pendingKos = BoardingHouse::where('status', 'pending')
                        ->with(['user', 'rooms']) 
                        ->latest()
                        ->get();

        return view('admin.kos_validation', compact('pendingKos'));
    }


    public function approveKos(Request $request, $slug)
    {
        $kos = BoardingHouse::where('slug', $slug)->firstOrFail();


        if ($request->action == 'approve') {
            $kos->update(['status' => 'approved']);
            $message = 'Kos berhasil disetujui dan tayang di halaman depan!';
        } else {
            $kos->update(['status' => 'rejected']);
            $message = 'Kos ditolak dan dikembalikan ke Juragan.';
        }

        return back()->with('success', $message);
    }

 
    public function transactions()
    {
        $transaksi = Transaction::with(['user', 'room.boardingHouse.user'])->latest()->get();

        return view('admin.transactions', compact('transaksi'));
    }
}
