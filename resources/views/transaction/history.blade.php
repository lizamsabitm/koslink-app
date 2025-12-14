<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Booking - KosLink</title>
    <link rel="icon" href="{{ asset('img/logobrowser.png') }}" type="image/png">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <style>
        body { background-color: #f8f9fa; font-family: 'Figtree', sans-serif; }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold text-primary" href="{{ url('/') }}">
                <img src="{{ asset('img/logo.png') }}" alt="Logo" height="30">
            </a>
            <div class="d-flex gap-2">
                <a href="{{ route('profile.edit') }}" class="btn btn-outline-primary btn-sm rounded-pill px-3">
                    <i class="fas fa-user me-1"></i> Profil
                </a>
                <a href="{{ url('/') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
            </div>
        </div>
    </nav>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-9">
                
                <h3 class="fw-bold mb-4">📅 Riwayat Booking Saya</h3>

                @if(session('success'))
                    <div class="alert alert-success rounded-4 mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                @if($transaksi->isEmpty())
                    <div class="text-center py-5">
                        <img src="https://cdn-icons-png.flaticon.com/512/2038/2038854.png" width="100" class="mb-3 opacity-50">
                        <p class="text-muted fs-5">Kamu belum pernah menyewa kos.</p>
                        <a href="{{ url('/') }}" class="btn btn-primary rounded-pill px-4 fw-bold">Cari Kos Dulu Yuk!</a>
                    </div>
                @else
                    <div class="d-flex flex-column gap-3">
                        @foreach($transaksi as $item)
                        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                            <div class="card-body p-4">
                                <div class="row align-items-center">
                                    
                                    <div class="col-md-8 d-flex align-items-center gap-3 mb-3 mb-md-0">
                                        <img src="{{ asset($item->room->boardingHouse->foto_utama) }}" class="rounded-3 object-fit-cover bg-light" width="90" height="90">
                                        <div>
                                            <h5 class="fw-bold mb-1">{{ $item->room->boardingHouse->nama_kos }}</h5>
                                            <p class="text-muted small mb-1">{{ $item->room->nama_kamar }} • {{ $item->durasi_sewa }} Bulan</p>
                                            <p class="text-secondary small mb-0">
                                                Check-in: <span class="fw-bold">{{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d M Y') }}</span>
                                            </p>
                                        </div>
                                    </div>

                                    <div class="col-md-4 text-md-end">
                                        @if($item->status == 'MENUNGGU')
                                            <span class="badge bg-warning text-dark mb-2">Belum Bayar</span>
                                        @elseif($item->status == 'MENUNGGU VERIFIKASI')
                                            <span class="badge bg-info text-dark mb-2">Menunggu Konfirmasi</span>
                                        @elseif($item->status == 'LUNAS')
                                            <span class="badge bg-success mb-2">LUNAS / AKTIF</span>
                                        @elseif($item->status == 'DITOLAK')
                                            <span class="badge bg-danger mb-2">DITOLAK</span>
                                        @endif

                                        <h5 class="fw-bold text-primary mb-2">Rp {{ number_format($item->total_harga, 0, ',', '.') }}</h5>

                                        @if($item->status == 'MENUNGGU')
                                            <form action="{{ route('booking.upload', $item->id) }}" method="POST" enctype="multipart/form-data" class="d-flex gap-2 justify-content-md-end">
                                                @csrf
                                                <input type="file" name="bukti_bayar" class="form-control form-control-sm" required style="max-width: 150px;">
                                                <button type="submit" class="btn btn-primary btn-sm rounded-pill">Kirim Bukti</button>
                                            </form>
                                        @elseif($item->status == 'LUNAS')
                                            <button class="btn btn-success btn-sm rounded-pill disabled">Tiket Kost Aktif</button>
                                        @endif
                                    </div>
                                </div>

                                @if($item->status == 'LUNAS')
                                <div class="mt-3 pt-3 border-top bg-light p-3 rounded-3">
                                    <h6 class="fw-bold text-dark mb-2"><i class="fas fa-star text-warning"></i> Beri Ulasan</h6>
                                    <form action="{{ route('reviews.store') }}" method="POST" class="d-flex flex-wrap gap-2">
                                        @csrf
                                        <input type="hidden" name="boarding_house_id" value="{{ $item->room->boarding_house_id }}">
                                        
                                        <select name="rating" class="form-select form-select-sm" style="width: auto;" required>
                                            <option value="" disabled selected>Bintang...</option>
                                            <option value="5">⭐⭐⭐⭐⭐ Puas Sekali</option>
                                            <option value="4">⭐⭐⭐⭐ Puas</option>
                                            <option value="3">⭐⭐⭐ Biasa</option>
                                            <option value="2">⭐⭐ Kurang</option>
                                            <option value="1">⭐ Buruk</option>
                                        </select>
                                        
                                        <input type="text" name="body" class="form-control form-control-sm flex-grow-1" placeholder="Ceritakan pengalamanmu..." style="min-width: 200px;">
                                        
                                        <button type="submit" class="btn btn-dark btn-sm rounded-pill fw-bold px-3">Kirim</button>
                                    </form>
                                </div>
                                @endif
                                </div>
                        </div>
                        @endforeach
                    </div>
                @endif

            </div>
        </div>
    </div>

</body>
</html>