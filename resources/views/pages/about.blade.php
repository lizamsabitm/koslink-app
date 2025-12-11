<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang Kami - KosLink</title>
    <link rel="icon" href="{{ asset('img/logobrowser.png') }}" type="image/png">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <style>
        body { font-family: 'Figtree', sans-serif; background-color: #f8f9fa; }
        .hero-section { background: linear-gradient(135deg, #0d6efd 0%, #0043a8 100%); color: white; padding: 60px 0; }
    </style>
</head>
<body>

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

    <header class="hero-section text-center mb-5">
        <div class="container">
            <h1 class="fw-bold display-5">Tentang KosLink</h1>
            <p class="lead opacity-75">Mewujudkan pengalaman pencarian kos yang aman, nyaman, dan transparan.</p>
        </div>
    </header>

    <div class="container pb-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card border-0 shadow rounded-4 p-5">
                    
                    <div class="text-center mb-5">
                        <img src="{{ asset('img/logo.png') }}" alt="KosLink Logo" class="mb-3" style="height: 60px;">
                        <h4 class="fw-bold">Solusi Anak Rantau Masa Kini</h4>
                    </div>

                    <div class="row g-5 align-items-center mb-5">
                        <div class="col-md-6">
                            <h3 class="fw-bold text-primary mb-3">Siapa Kami?</h3>
                            <p class="text-secondary" style="line-height: 1.8;">
                                <strong>KosLink</strong> didirikan dengan satu misi sederhana: Membantu jutaan anak rantau di Indonesia menemukan tempat tinggal yang layak tanpa drama.
                                <br><br>
                                Kami percaya bahwa mencari kos seharusnya semudah memesan ojek online. Tidak perlu lagi keliling gang panas-panasan, cukup buka HP, lihat foto & video, cek lokasi, dan bayar dengan aman.
                            </p>
                        </div>
                        <div class="col-md-6 text-center">
                            <img src="https://img.freepik.com/free-vector/house-searching-concept-illustration_114360-466.jpg" class="img-fluid rounded-4" alt="Ilustrasi">
                        </div>
                    </div>

                    <hr class="my-5">

                    <div class="row text-center">
                        <div class="col-md-4 mb-4">
                            <div class="p-3">
                                <i class="fas fa-shield-alt text-primary fa-3x mb-3"></i>
                                <h5 class="fw-bold">100% Aman</h5>
                                <p class="text-muted small">Pembayaran ditahan sistem sampai Anda dikonfirmasi masuk kos.</p>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <div class="p-3">
                                <i class="fas fa-check-circle text-success fa-3x mb-3"></i>
                                <h5 class="fw-bold">Terverifikasi</h5>
                                <p class="text-muted small">Semua kos telah melalui proses pengecekan kualitas oleh tim kami.</p>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <div class="p-3">
                                <i class="fas fa-headset text-warning fa-3x mb-3"></i>
                                <h5 class="fw-bold">Layanan 24/7</h5>
                                <p class="text-muted small">Tim support kami siap membantu kendala Anda kapan saja.</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <footer class="bg-dark text-white text-center py-4 mt-5">
        <p class="mb-0 small">&copy; 2025 KosLink Indonesia. All rights reserved.</p>
    </footer>

</body>
</html>