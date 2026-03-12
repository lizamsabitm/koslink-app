<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\PaymentMethod;
use App\Models\BoardingHouse;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OwnerController extends Controller
{
    public function create()
    {
        if (auth()->user()->role !== 'owner') {
            abort(403, 'Hanya Juragan yang boleh masuk sini!');
        }
        return view('owner.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kos' => 'required|string|max:255',
            'jenis_kos' => 'required|string|in:Putra,Putri,Campur',
            'harga_per_bulan' => 'required|numeric',
            'foto_utama' => 'required|image|max:2048',
            'alamat' => 'required|string',
            'stok_kamar' => 'required|integer|min:1',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $uploadedFileUrl = cloudinary()->upload($request->file('foto_utama')->getRealPath(), ['folder' => 'koslink/kos-images'])->getSecurePath();

        $kos = BoardingHouse::create([
    'user_id' => auth()->id(),
    'nama_kos' => $request->nama_kos,
    'jenis_kos' => $request->jenis_kos,
    'slug' => Str::slug($request->nama_kos) . '-' . time(),
    'alamat' => $request->alamat,
    'deskripsi' => $request->deskripsi,
    'foto_utama' => $uploadedFileUrl,
    'status' => 'pending',
    'latitude' => $request->latitude,
    'longitude' => $request->longitude,
            ]);

    
        $fasilitasString = implode(', ', $request->fasilitas ?? []);

        Room::create([
            'boarding_house_id' => $kos->id,
            'nama_kamar' => 'Kamar Standar',
            'harga_per_bulan' => $request->harga_per_bulan,
            'fasilitas' => $fasilitasString,
            'stok_kamar' => $request->stok_kamar,
            'is_available' => true,
        ]);

        return redirect()->route('owner.kos.index')->with('success', 'Kos berhasil diterbitkan! Tunggu verifikasi Admin.');
    }

    public function transactions()
    {
        $transaksi = Transaction::whereHas('room.boardingHouse', function($query) {
            $query->where('user_id', auth()->id());
        })->with(['user', 'room.boardingHouse'])->latest()->get();

        return view('owner.transactions', compact('transaksi'));
    }

    public function updateStatus(Request $request, $id)
    {
        $transaksi = Transaction::findOrFail($id);
        $transaksi->update(['status' => $request->status]);
        return back()->with('success', 'Status pesanan berhasil diperbarui!');
    }

    public function banks()
    {
        $rekening = PaymentMethod::where('user_id', auth()->id())->get();
        return view('owner.banks', compact('rekening'));
    }

    public function storeBank(Request $request)
    {
        $request->validate([
            'nama_bank' => 'required|string|max:50',
            'nomor_rekening' => 'required|numeric',
            'atas_nama' => 'required|string|max:100',
        ]);

        PaymentMethod::create([
            'user_id' => auth()->id(),
            'nama_bank' => $request->nama_bank,
            'nomor_rekening' => $request->nomor_rekening,
            'atas_nama' => $request->atas_nama,
        ]);

        return back()->with('success', 'Rekening berhasil ditambahkan!');
    }

    public function destroyBank($id)
    {
        $rekening = PaymentMethod::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        $rekening->delete();
        return back()->with('success', 'Rekening berhasil dihapus.');
    }

    public function myKos()
    {
        $allKos = BoardingHouse::where('user_id', auth()->id())->get();
        return view('owner.kos.index', compact('allKos'));
    }

    public function edit($slug)
    {
        $kos = BoardingHouse::where('slug', $slug)
                ->where('user_id', auth()->id())
                ->firstOrFail();
                
        return view('owner.kos.edit', compact('kos'));
    }

    public function update(Request $request, $slug)
    {
        $kos = BoardingHouse::where('slug', $slug)->where('user_id', auth()->id())->firstOrFail();
        $kamar = $kos->rooms->first();

        $request->validate([
            'nama_kos' => 'required|string|max:255',
            'jenis_kos' => 'required|string|in:Putra,Putri,Campur',
            'harga_per_bulan' => 'required|numeric',
            'stok_kamar' => 'required|integer',
            'alamat' => 'required|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        $dataUpdate = [
            'nama_kos' => $request->nama_kos,
            'jenis_kos' => $request->jenis_kos,
            'alamat' => $request->alamat,
            'deskripsi' => $request->deskripsi,
        ];

        if($request->filled('latitude') && $request->filled('longitude')) {
            $dataUpdate['latitude'] = $request->latitude;
            $dataUpdate['longitude'] = $request->longitude;
        }
        $kos->update($dataUpdate);

        if ($request->hasFile('foto_utama')) {
    $uploadedFileUrl = cloudinary()->upload($request->file('foto_utama')->getRealPath(), ['folder' => 'koslink/kos-images'])->getSecurePath();
    $kos->update(['foto_utama' => $uploadedFileUrl]);
        }

        $fasilitasString = implode(', ', $request->fasilitas ?? []);
        
        $kamar->update([
            'harga_per_bulan' => $request->harga_per_bulan,
            'stok_kamar' => $request->stok_kamar,
            'fasilitas' => $fasilitasString,
        ]);

        return redirect()->route('owner.kos.index')->with('success', 'Data kos berhasil diperbarui!');
    }

    public function destroy($slug)
    {
        $kos = BoardingHouse::where('slug', $slug)->where('user_id', auth()->id())->firstOrFail();
        $kos->delete();
        
        return back()->with('success', 'Kos berhasil dihapus.');
    }
}
