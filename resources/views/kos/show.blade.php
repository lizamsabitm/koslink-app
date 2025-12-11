<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KosLink - Detail Kos</title>
    
    <link rel="icon" href="{{ asset('img/logobrowser.png') }}" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    <style>
        /* Paksa tinggi peta agar muncul */
        #map-detail { height: 300px; width: 100%; border-radius: 12px; z-index: 1; }
    </style>
</head>
<body class="bg-light">

    <nav class="navbar navbar-light bg-white shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold text-primary" href="{{ url('/') }}">
                <i class="fas fa-arrow-left me-2"></i> Kembali ke Pencarian
            </a>
        </div>
    </nav>

    <div class="container py-5">
        <div class="row">
            
            <div class="col-lg-8">
                
                <div class="card border-0 shadow-sm overflow-hidden rounded-4 mb-4">
                    <img src="{{ asset($kos->foto_utama) }}" class="img-fluid w-100" style="height: 400px; object-fit: cover;" alt="{{ $kos->nama_kos }}">
                </div>

                <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
                    <h1 class="fw-bold mb-2">{{ $kos->nama_kos }}</h1>
                    
                    <div class="mb-2">
                        @if($kos->jenis_kos == 'Putra')
                            <span class="badge bg-primary rounded-pill"><i class="fas fa-male me-1"></i> Khusus Putra</span>
                        @elseif($kos->jenis_kos == 'Putri')
                            <span class="badge bg-danger rounded-pill"><i class="fas fa-female me-1"></i> Khusus Putri</span>
                        @else
                            <span class="badge bg-success rounded-pill"><i class="fas fa-venus-mars me-1"></i> Campur</span>
                        @endif
                        
                        @if($kos->reviews_avg_rating)
                            <span class="badge bg-warning text-dark rounded-pill ms-2">
                                <i class="fas fa-star text-white"></i> {{ number_format($kos->reviews_avg_rating, 1) }}
                            </span>
                        @endif
                    </div>

                    <p class="text-muted mb-3"><i class="fas fa-map-marker-alt me-2 text-danger"></i> {{ $kos->alamat }}</p>
                    
                    <hr>

                    <h5 class="fw-bold mb-3">Deskripsi Kos</h5>
                    <p class="text-secondary" style="line-height: 1.8;">
                        {{ $kos->deskripsi }}
                    </p>

                    <h5 class="fw-bold mt-4 mb-3">Fasilitas</h5>
                    <div class="d-flex flex-wrap gap-2 mb-4">
                        @php
                            $fasilitas = explode(',', $kos->rooms->first()->fasilitas ?? '');
                        @endphp
                        @foreach($fasilitas as $item)
                            <span class="badge bg-light text-primary border px-3 py-2 rounded-pill">
                                <i class="fas fa-check-circle me-1"></i> {{ trim($item) }}
                            </span>
                        @endforeach
                    </div>

                    @if($kos->latitude && $kos->longitude)
                        <hr>
                        <h5 class="fw-bold mt-4 mb-3">📍 Lokasi Kos</h5>
                        <div id="map-detail" class="border"></div>
                        <a href="https://www.google.com/maps/search/?api=1&query={{ $kos->latitude }},{{ $kos->longitude }}" target="_blank" class="btn btn-outline-primary btn-sm mt-2 rounded-pill fw-bold">
                            <i class="fas fa-map-marked-alt me-1"></i> Buka di Google Maps
                        </a>
                    @endif
                    </div>

                <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
                    <h5 class="fw-bold mb-4 d-flex align-items-center">
                        <i class="fas fa-star text-warning me-2"></i> Ulasan Penyewa
                        <span class="text-muted fw-normal ms-2 fs-6">({{ $kos->reviews->count() }} ulasan)</span>
                    </h5>

                    @if($kos->reviews->isEmpty())
                        <div class="text-center py-4 bg-light rounded-3">
                            <p class="text-muted mb-0">Belum ada ulasan. Jadilah penyewa pertama yang memberikan nilai!</p>
                        </div>
                    @else
                        <div class="d-flex flex-column gap-3">
                            @foreach($kos->reviews as $review)
                            <div class="border-bottom pb-3">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center fw-bold" style="width: 40px; height: 40px;">
                                            {{ substr($review->user->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <h6 class="fw-bold mb-0 text-dark" style="font-size: 14px;">{{ $review->user->name }}</h6>
                                            <small class="text-muted" style="font-size: 11px;">{{ $review->created_at->diffForHumans() }}</small>
                                        </div>
                                    </div>
                                    <div class="text-warning small">
                                        @for($i = 0; $i < $review->rating; $i++)
                                            <i class="fas fa-star"></i>
                                        @endfor
                                        <span class="text-muted ms-1">({{ $review->rating }}.0)</span>
                                    </div>
                                </div>
                                @if($review->body)
                                    <p class="text-secondary mt-2 mb-0 ms-5 small" style="font-size: 13px;">"{{ $review->body }}"</p>
                                @endif
                            </div>
                            @endforeach
                        </div>
                    @endif
                </div>

            </div>

            <div class="col-lg-4">
                <div class="card border-0 shadow rounded-4 p-4 sticky-top" style="top: 100px;">
                    <h6 class="text-muted">Mulai dari</h6>
                    <h2 class="fw-bold text-primary mb-1">
                        Rp {{ number_format($kos->rooms->first()->harga_per_bulan ?? 0, 0, ',', '.') }}
                    </h2>
                    <small class="text-muted">per bulan</small>

                    <hr class="my-4">

                    <div class="d-flex justify-content-between mb-2">
                        <span>Tipe Kamar</span>
                        <span class="fw-bold">{{ $kos->rooms->first()->nama_kamar ?? '-' }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-4">
                        <span>Sisa Kamar</span>
                        <span class="text-danger fw-bold">{{ $kos->rooms->first()->stok_kamar ?? 0 }} Unit</span>
                    </div>

                    <div class="d-grid gap-2">
                        @auth
                            <a href="{{ route('booking.checkout', $kos->slug) }}" class="btn btn-primary btn-lg fw-bold rounded-pill w-100 text-white text-decoration-none d-block text-center pt-2">
                                Ajukan Sewa
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-primary btn-lg fw-bold rounded-pill w-100 text-white text-decoration-none d-block text-center pt-2">
                                Login untuk Sewa
                            </a>
                        @endauth

                        @if($kos->user->no_hp)
                            <a href="https://wa.me/{{ $kos->user->no_hp }}?text=Halo, saya tertarik dengan {{ $kos->nama_kos }}. Apakah masih tersedia?" 
                               target="_blank" 
                               class="btn btn-outline-success btn-lg fw-bold rounded-pill text-decoration-none pt-2">
                                <i class="fab fa-whatsapp me-2"></i> Tanya Pemilik
                            </a>
                        @else
                            <button class="btn btn-secondary btn-lg fw-bold rounded-pill" disabled>
                                <i class="fas fa-phone-slash me-2"></i> No HP Belum Ada
                            </button>
                        @endif
                    </div>

                    <div class="mt-4 text-center">
                        <small class="text-muted">Dikelola oleh Juragan <b>{{ $kos->user->name }}</b></small>
                    </div>
                </div>
            </div>

        </div>
    </div>

    @if($kos->latitude && $kos->longitude)
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script>
        // Ambil koordinat dari Database PHP
        var lat = {{ $kos->latitude }};
        var lng = {{ $kos->longitude }};

        // Inisialisasi Peta
        var map = L.map('map-detail').setView([lat, lng], 15); // Zoom level 15 (cukup dekat)

        // Tile Layer
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        // Marker (Tanpa draggable, karena cuma view)
        L.marker([lat, lng]).addTo(map)
            .bindPopup("<b>{{ $kos->nama_kos }}</b><br>Lokasi Kos di sini.")
            .openPopup();
    </script>
    @endif

</body>
</html>