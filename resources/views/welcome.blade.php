<!DOCTYPE html>
<html lang="id">
<head>
    <title>KosLink - Cari Kos Nyaman</title>
    <link rel="icon" href="img/logobrowser.png" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <style>
        /* Gaya Kustom KosLink */
        .hero-section {
            background: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)), url('img/banner-bg.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            padding: 100px 0 60px;
            color: white;
            border-radius: 0 0 25px 25px;
            margin-bottom: 40px;
            position: relative;
        }
        
        .search-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 17px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        .city-img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid white;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            margin-bottom: 10px;
        }

        .kos-card {
            border: none;
            border-radius: 15px;
            overflow: hidden;
            transition: all 0.3s;
        }
        .kos-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
        }

        .feature-icon {
            width: 60px;
            height: 60px;
            background: #e7f1ff;
            color: #0d6efd;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin: 0 auto 20px;
        }

        .owner-banner {
            background: #212529;
            color: white;
            padding: 60px 0;
            border-radius: 20px;
        }

        footer {
            background: #1a1e21;
            color: #adb5bd;
            padding: 60px 0 20px;
        }
        footer a { color: #adb5bd; text-decoration: none; }
        footer a:hover { color: white; }
    </style>
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark fixed-top" style="background: #203FE5; padding-top: 10px; padding-bottom: 10px;">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="img/logo.png" alt="Logo KosLink" style="height: 22px; width: auto;">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('about') }}">Tentang Kami</a></li>
                    <li class="nav-item ms-lg-3">
                        @auth
                            @if(Auth::user()->role === 'owner')
                                <a href="{{ url('/dashboard') }}" class="btn btn-light text-primary fw-bold btn-sm px-4 rounded-pill">Dashboard</a>
                            @elseif(Auth::user()->role === 'admin')
                                <a href="{{ url('/dashboard') }}" class="btn btn-light text-danger fw-bold btn-sm px-4 rounded-pill">Admin Panel</a>
                            @else
                                <div class="d-flex align-items-center gap-3">
                                    <a href="{{ route('booking.history') }}" class="text-decoration-none text-white fw-bold small hover-opacity">
                                        <i class="fas fa-history me-1"></i> Riwayat
                                    </a>
                                    <span class="text-white opacity-50">|</span>
                                    <a href="{{ route('profile.edit') }}" class="text-white fw-bold small text-decoration-none me-2 border border-white px-3 py-1 rounded-pill hover-bg-white hover-text-blue transition">
                                        <i class="fas fa-user-circle me-1"></i> {{ explode(' ', Auth::user()->name)[0] }}
                                    </a>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-light btn-sm px-3 rounded-pill" style="font-size: 12px; border: 1px solid rgba(255,255,255,0.5);">Keluar</button>
                                    </form>
                                </div>
                            @endif
                        @else
                            <div class="d-flex gap-2">
                                <a href="{{ route('login') }}" class="btn btn-outline-light fw-bold btn-sm px-3 rounded-pill" style="border: 1px solid rgba(255,255,255,0.5);">Masuk</a>
                                <a href="{{ route('register') }}" class="btn btn-light text-primary fw-bold btn-sm px-4 rounded-pill">Daftar</a>
                            </div>
                        @endauth
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <header class="hero-section text-center">
        <div class="container">
            <h1 class="fw-bold display-4 mb-3">Temukan Kos Impianmu</h1>
            <p class="lead mb-5 opacity-100">Kenyamanan kos terbaik hanya tinggal klik. Temukan sekarang!</p>
            
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <form action="{{ url('/') }}" method="GET" class="search-card text-start">
                        <div class="row g-2 align-items-center">
                            <div class="col-md-5">
                                <label class="small text-muted mb-1 fw-bold">Lokasi / Nama Kos</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-0 ps-0"><i class="fas fa-search text-muted"></i></span>
                                    <input type="text" name="keyword" value="{{ request('keyword') }}" class="form-control border-0 ps-1" placeholder="Mau kos di mana?">
                                </div>
                            </div>
                            <div class="col-md-4 border-start">
                                <label class="small text-muted mb-1 fw-bold">Range Harga</label>
                                <select name="price" class="form-select border-0 ps-0 fw-bold text-dark">
                                    <option value="" selected>Semua Harga</option>
                                    <option value="1" {{ request('price') == '1' ? 'selected' : '' }}>Rp 500rb - 1jt</option>
                                    <option value="2" {{ request('price') == '2' ? 'selected' : '' }}>Rp 1jt - 2jt</option>
                                    <option value="3" {{ request('price') == '3' ? 'selected' : '' }}>> Rp 2jt</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-primary w-100 h-100 fw-bold rounded-3">Cari Kos</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </header>

    @if(!$isSearching)
    <div class="container mb-5">
        <div class="text-center mb-4">
            <h4 class="fw-bold">Kota Populer</h4>
            <p class="text-muted small">Kota yang paling banyak dicari</p>
        </div>
        <div class="row justify-content-center text-center">
            <div class="col-4 col-md-2 city-item">
                <img src="img/ikonkota/jakarta.jpg" class="city-img" alt="Jakarta">
                <h6 class="fw-bold small">Jakarta</h6>
            </div>
            <div class="col-4 col-md-2 city-item">
                <img src="img/ikonkota/bandung.png" class="city-img" alt="Bandung">
                <h6 class="fw-bold small">Bandung</h6>
            </div>
            <div class="col-4 col-md-2 city-item">
                <img src="img/ikonkota/jogja.jpg" class="city-img" alt="Yogyakarta">
                <h6 class="fw-bold small">Yogyakarta</h6>
            </div>
            <div class="col-4 col-md-2 city-item">
                <img src="img/ikonkota/surabaya.jpg" class="city-img" alt="Surabaya">
                <h6 class="fw-bold small">Surabaya</h6>
            </div>
            <div class="col-4 col-md-2 city-item">
                <img src="img/ikonkota/bali.jpg" class="city-img" alt="Bali">
                <h6 class="fw-bold small">Bali</h6>
            </div>
        </div>
    </div>
    @endif

    <div class="container mb-5">
        
        <div class="d-flex flex-wrap justify-content-between align-items-end mb-4">
            <div>
                @if($isSearching)
                    <h3 class="fw-bold mb-0 text-primary">🔍 Hasil Pencarian</h3>
                    <p class="text-muted small mb-0">Menampilkan kos yang cocok dengan kriteriamu</p>
                @else
                    <h3 class="fw-bold mb-0">Rekomendasi Terbaru</h3>
                    <p class="text-muted small mb-0">Kos pilihan yang baru saja bergabung</p>
                @endif
            </div>

            @if($isSearching)
                <form action="{{ url('/') }}" method="GET" class="d-flex gap-2 mt-2 mt-md-0">
                    <input type="hidden" name="keyword" value="{{ request('keyword') }}">
                    <input type="hidden" name="price" value="{{ request('price') }}">

                    <select name="jenis" class="form-select form-select-sm border-secondary fw-bold" onchange="this.form.submit()">
                        <option value="Semua">Semua Tipe</option>
                        <option value="Putra" {{ request('jenis') == 'Putra' ? 'selected' : '' }}>Khusus Putra</option>
                        <option value="Putri" {{ request('jenis') == 'Putri' ? 'selected' : '' }}>Khusus Putri</option>
                        <option value="Campur" {{ request('jenis') == 'Campur' ? 'selected' : '' }}>Campur</option>
                    </select>

                    <select name="sort" class="form-select form-select-sm border-secondary fw-bold" onchange="this.form.submit()">
                        <option value="terbaru">Paling Baru</option>
                        <option value="termurah" {{ request('sort') == 'termurah' ? 'selected' : '' }}>Harga Terendah</option>
                        <option value="termahal" {{ request('sort') == 'termahal' ? 'selected' : '' }}>Harga Tertinggi</option>
                    </select>
                </form>
            @else
                <a href="#" class="text-decoration-none fw-bold">Lihat Semua &rarr;</a>
            @endif
        </div>

        @if($kos->isEmpty())
            <div class="text-center py-5 border rounded bg-white">
                <h3 class="text-muted">Yah, Kos tidak ditemukan 😔</h3>
                <p>Coba ganti kata kunci atau reset filter.</p>
                <a href="{{ url('/') }}" class="btn btn-outline-primary rounded-pill">Reset Pencarian</a>
            </div>
        @else
            <div class="row">
                @foreach($kos as $data)
                <div class="col-md-4 mb-4">
                    <div class="card kos-card shadow-sm h-100">
                        <div class="position-relative">
                            <img src="{{ asset($data->foto_utama) }}" class="card-img-top" alt="Foto Kos" style="height: 200px; object-fit: cover;">
                            
                            <div class="position-absolute top-0 start-0 m-3">
                                @if($data->jenis_kos == 'Putra')
                                    <span class="badge bg-primary rounded-pill px-3 py-2 shadow"><i class="fas fa-male me-1"></i> Putra</span>
                                @elseif($data->jenis_kos == 'Putri')
                                    <span class="badge bg-danger rounded-pill px-3 py-2 shadow"><i class="fas fa-female me-1"></i> Putri</span>
                                @else
                                    <span class="badge bg-success rounded-pill px-3 py-2 shadow"><i class="fas fa-venus-mars me-1"></i> Campur</span>
                                @endif
                            </div>

                            <span class="position-absolute top-0 end-0 bg-white text-primary badge m-2 shadow-sm rounded-pill px-3 py-2">
                            <i class="fas fa-star text-warning"></i> 
                            @if($data->reviews_avg_rating)
                                {{ number_format($data->reviews_avg_rating, 1) }}
                            @else
                                <span class="small text-muted">Baru</span>
                            @endif
                        </span>
                        </div>
                        
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="badge bg-light text-primary border border-primary text-uppercase" style="font-size: 10px;">{{ $data->rooms->first()->nama_kamar ?? 'Umum' }}</span>
                                <small class="text-success fw-bold"><i class="fas fa-check-circle"></i> Tersedia</small>
                            </div>

                            <h5 class="fw-bold text-dark mb-1">{{ Str::limit($data->nama_kos, 25) }}</h5>
                            <p class="text-muted small mb-3"><i class="fas fa-map-marker-alt me-1"></i> {{ Str::limit($data->alamat, 30) }}</p>
                            
                            <div class="d-flex flex-wrap gap-2 mb-3">
                                @php
                                    $fasilitasMentah = $data->rooms->first()->fasilitas ?? '';
                                    $daftarFasilitas = array_filter(explode(',', $fasilitasMentah)); // array_filter untuk hapus yg kosong
                                    $fasilitasTeratas = array_slice($daftarFasilitas, 0, 3);
                                @endphp

                                @foreach($fasilitasTeratas as $item)
                                    @php
                                        $item = trim($item);
                                        $icon = 'fa-check-circle';
                                        if(stripos($item, 'WiFi') !== false) $icon = 'fa-wifi';
                                        elseif(stripos($item, 'AC') !== false) $icon = 'fa-snowflake';
                                        elseif(stripos($item, 'TV') !== false) $icon = 'fa-tv';
                                        elseif(stripos($item, 'Mandi') !== false) $icon = 'fa-bath';
                                        elseif(stripos($item, 'Kasur') !== false) $icon = 'fa-bed';
                                    @endphp
                                    <span class="badge bg-light text-secondary fw-normal border">
                                        <i class="fas {{ $icon }} me-1"></i> {{ $item }}
                                    </span>
                                @endforeach
                            </div>

                            <hr class="my-2">
                            
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <div>
                                    <small class="text-muted d-block" style="font-size: 10px;">Mulai dari</small>
                                    <span class="text-primary fw-bold fs-5">
                                        Rp {{ number_format(($data->rooms->first()->harga_per_bulan ?? 0) / 1000, 0) }} rb
                                    </span>
                                    <small class="text-muted">/bln</small>
                                </div>
                                <a href="{{ route('kos.show', $data->slug) }}" class="btn btn-outline-primary rounded-pill px-4 btn-sm fw-bold">Detail</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            @if($isSearching && $kos instanceof \Illuminate\Pagination\LengthAwarePaginator)
                <div class="mt-4 d-flex justify-content-center">
                    {{ $kos->links('pagination::bootstrap-5') }}
                </div>
            @endif
        @endif
    </div>

    <div class="bg-white py-5 mb-5">
        <div class="container">
            <div class="text-center mb-5">
                <h3 class="fw-bold">Kenapa Memilih KosLink?</h3>
                <p class="text-muted">Kami menjamin kenyamanan pencarian kosmu</p>
            </div>
            <div class="row text-center">
                <div class="col-md-4 mb-4">
                    <div class="feature-icon"><i class="fas fa-shield-alt"></i></div>
                    <h5 class="fw-bold">Terverifikasi Aman</h5>
                    <p class="text-muted small px-4">Setiap kos yang terdaftar telah melalui proses survei dan verifikasi tim kami.</p>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="feature-icon"><i class="fas fa-bolt"></i></div>
                    <h5 class="fw-bold">Booking Instan</h5>
                    <p class="text-muted small px-4">Tidak perlu tunggu lama. Pesan kamar langsung dari HP, konfirmasi cepat.</p>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="feature-icon"><i class="fas fa-coins"></i></div>
                    <h5 class="fw-bold">Harga Transparan</h5>
                    <p class="text-muted small px-4">Apa yang kamu lihat adalah yang kamu bayar. Tidak ada biaya tersembunyi.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="container mb-5">
        <div class="owner-banner text-center position-relative overflow-hidden">
            <div class="position-absolute top-0 start-0 bg-primary opacity-25 rounded-circle" style="width: 200px; height: 200px; transform: translate(-50%, -50%);"></div>
            <div class="position-relative z-1">
                <h2 class="fw-bold mb-3">Punya Kos Kosong?</h2>
                <p class="mb-4 text-white-50">Bergabunglah dengan 10+ Juragan Kos lainnya dan nikmati kemudahan kelola bisnis kos.</p>
                <a href="{{ route('register') }}" class="btn btn-warning fw-bold text-dark px-5 py-2 rounded-pill shadow">Daftar Jadi Juragan</a>
            </div>
        </div>
    </div>

    <footer>
        <div class="container">
            <div class="row gy-4">
                <div class="col-md-4">
                    <img src="img/logo.png" alt="KosLink Logo" height="30" class="mb-3">
                    <p class="small">Platform pencarian kos nomor 1 di Indonesia. Kami membantu anak rantau menemukan hunian nyaman semudah belanja online.</p>
                    <div class="d-flex gap-3 mt-3">
                        <a href=""><i class="fab fa-instagram fa-lg"></i></a>
                        <a href=""><i class="fab fa-facebook fa-lg"></i></a>
                        <a href=""><i class="fab fa-twitter fa-lg"></i></a>
                    </div>
                </div>
                <div class="col-md-2">
                    <h6 class="fw-bold text-white mb-3">Perusahaan</h6>
                    <ul class="list-unstyled small d-flex flex-column gap-2">
                        <li><a href="{{ route('about') }}">Tentang Kami</a></li>
                        <li><a href="">Karir</a></li>
                        <li><a href="">Blog</a></li>
                    </ul>
                </div>
                <div class="col-md-2">
                    <h6 class="fw-bold text-white mb-3">Bantuan</h6>
                    <ul class="list-unstyled small d-flex flex-column gap-2">
                        <li><a href="">Pusat Bantuan</a></li>
                        <li><a href="{{ route('terms') }}">Syarat & Ketentuan</a></li>
                        <li><a href="">Kebijakan Privasi</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h6 class="fw-bold text-white mb-3">Hubungi Kami</h6>
                    <ul class="list-unstyled small d-flex flex-column gap-2">
                        <li><i class="fas fa-envelope me-2"></i> cs@koslink.com</li>
                        <li><i class="fas fa-phone me-2"></i> +62 812-3456-7890</li>
                        <li><i class="fas fa-map-marker-alt me-2"></i> Surabaya, Indonesia</li>
                    </ul>
                </div>
            </div>
            <hr class="border-secondary my-4">
            <div class="text-center small">
                &copy; 2025 KosLink Indonesia. All rights reserved.
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>