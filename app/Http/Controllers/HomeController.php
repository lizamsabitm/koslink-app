<?php

namespace App\Http\Controllers;

use App\Models\BoardingHouse;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // Hanya yang Approved
        $query = BoardingHouse::where('status', 'approved')
        ->with(['user', 'rooms'])
        ->withAvg('reviews', 'rating');

        // PENCARIAN KEYWORD 
        if ($request->filled('keyword')) {
            $query->where(function($q) use ($request) {
                $q->where('nama_kos', 'like', '%'.$request->keyword.'%')
                  ->orWhere('alamat', 'like', '%'.$request->keyword.'%');
            });
        }

        // FILTER RANGE HARGA (Dari Banner) 
        if ($request->filled('price')) {
            $query->whereHas('rooms', function($q) use ($request) {
                if($request->price == '1') { // 500rb - 1jt
                    $q->whereBetween('harga_per_bulan', [500000, 1000000]);
                } elseif($request->price == '2') { // 1jt - 2jt
                    $q->whereBetween('harga_per_bulan', [1000000, 2000000]);
                } elseif($request->price == '3') { // > 2jt
                    $q->where('harga_per_bulan', '>', 2000000);
                }
            });
        }

        // FILTER JENIS KOS (Putra/Putri/Campur)
        if ($request->filled('jenis') && $request->jenis != 'Semua') {
            $query->where('jenis_kos', $request->jenis);
        }

        // SORTING (Termurah/Termahal) 
        if ($request->filled('sort')) {
            // Kita perlu join tabel rooms untuk sorting berdasarkan harga
            $query->join('rooms', 'boarding_houses.id', '=', 'rooms.boarding_house_id')
                  ->select('boarding_houses.*') // Ambil data kos saja agar tidak bentrok
                  ->orderBy('rooms.harga_per_bulan', $request->sort == 'termurah' ? 'asc' : 'desc')
                  ->distinct();
        } else {
            // Default: Urutkan dari yang terbaru
            $query->latest();
        }

        // PENENTUAN TAMPILAN (SEARCH vs DEFAULT) 
        // Cek apakah user sedang mencari sesuatu?
        $isSearching = $request->anyFilled(['keyword', 'price', 'jenis', 'sort']);

        if ($isSearching) {
            // Mode Pencarian: Tampilkan 9 per halaman (Pagination)
            $kos = $query->paginate(9)->withQueryString();
        } else {
            // Mode Default: Tampilkan 3 kos terbaru saja
            $kos = $query->take(3)->get();
        }

        return view('welcome', compact('kos', 'isSearching'));
    }

    public function show($slug)
    {
        $kos = BoardingHouse::where('slug', $slug)
        ->with(['user', 'rooms', 'reviews.user'])
        ->withAvg('reviews', 'rating')
        ->firstOrFail();
        return view('kos.show', compact('kos'));
    }
}