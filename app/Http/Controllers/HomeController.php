<?php

namespace App\Http\Controllers;

use App\Models\BoardingHouse;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $query = BoardingHouse::where('status', 'approved')
        ->with(['user', 'rooms'])
        ->withAvg('reviews', 'rating');

        if ($request->filled('keyword')) {
            $query->where(function($q) use ($request) {
                $q->where('nama_kos', 'like', '%'.$request->keyword.'%')
                  ->orWhere('alamat', 'like', '%'.$request->keyword.'%');
            });
        }
 
        if ($request->filled('price')) {
            $query->whereHas('rooms', function($q) use ($request) {
                if($request->price == '1') { 
                    $q->whereBetween('harga_per_bulan', [500000, 1000000]);
                } elseif($request->price == '2') { 
                    $q->whereBetween('harga_per_bulan', [1000000, 2000000]);
                } elseif($request->price == '3') { 
                    $q->where('harga_per_bulan', '>', 2000000);
                }
            });
        }

        if ($request->filled('jenis') && $request->jenis != 'Semua') {
            $query->where('jenis_kos', $request->jenis);
        }

        if ($request->filled('sort')) {
            $query->join('rooms', 'boarding_houses.id', '=', 'rooms.boarding_house_id')
                  ->select('boarding_houses.*')
                  ->orderBy('rooms.harga_per_bulan', $request->sort == 'termurah' ? 'asc' : 'desc')
                  ->distinct();
        } else {
            $query->latest();
        }

        $isSearching = $request->anyFilled(['keyword', 'price', 'jenis', 'sort']);

        if ($isSearching) {
            $kos = $query->paginate(9)->withQueryString();
        } else {
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