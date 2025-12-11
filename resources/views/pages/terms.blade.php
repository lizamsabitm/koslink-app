<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KosLink - Syarat & Ketentuan</title>
    <link rel="icon" href="{{ asset('img/logobrowser.png') }}" type="image/png">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <style>
        body { font-family: 'Figtree', sans-serif; background-color: #f8f9fa; }
    </style>
</head>
<body>

    @if(request('source') != 'register')
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold text-primary" href="{{ url('/') }}">
                <img src="{{ asset('img/logo.png') }}" alt="Logo" height="30">
            </a>
            <a href="{{ url('/') }}" class="btn btn-outline-primary rounded-pill btn-sm">
                <i class="fas fa-arrow-left me-2"></i> Kembali ke Beranda
            </a>
        </div>
    </nav>
    @endif

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="card-header bg-white p-4 border-bottom">
                        <h2 class="fw-bold mb-0 text-dark">📜 Syarat & Ketentuan</h2>
                        <p class="text-muted mb-0 small">Wajib dibaca sebelum mendaftar.</p>
                    </div>
                    
                    <div class="card-body p-5">
                        <div class="mb-4">
                            <h5 class="fw-bold text-primary">1. Ketentuan Umum</h5>
                            <p class="text-secondary small">Dengan mengakses dan menggunakan situs web serta layanan KosLink, Anda menyatakan setuju untuk terikat oleh Syarat dan Ketentuan ini.</p>
                        </div>

                        <div class="mb-4">
                            <h5 class="fw-bold text-primary">2. Kewajiban Penyewa</h5>
                            <ul class="text-secondary small list-unstyled ps-2">
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Wajib memberikan informasi identitas yang valid (KTP/KTM).</li>
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Pembayaran sewa pertama wajib dilakukan melalui sistem KosLink.</li>
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Dilarang menggunakan properti untuk kegiatan ilegal.</li>
                            </ul>
                        </div>

                        <div class="mb-4">
                            <h5 class="fw-bold text-primary">3. Kebijakan Refund</h5>
                            <p class="text-secondary small">Pengajuan refund dapat dilakukan maksimal <strong>3 hari sebelum tanggal masuk</strong>. Uang akan dikembalikan 100%.</p>
                        </div>

                        <hr>

                        <div class="text-center mt-4">
                            <p class="small text-muted mb-3">Apakah Anda setuju dengan ketentuan di atas?</p>
                            
                            @if(request('source') == 'register')
                                <button onclick="window.close()" class="btn btn-success btn-lg fw-bold rounded-pill px-5 shadow">
                                    ✅ Saya Setuju (Lanjut Daftar)
                                </button>
                                <p class="text-muted small mt-2">Klik tombol di atas untuk menutup tab ini dan kembali ke formulir.</p>
                            @else
                                <a href="{{ url('/') }}" class="btn btn-primary btn-lg fw-bold rounded-pill px-5">
                                    Saya Setuju
                                </a>
                            @endif
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

</body>
</html>