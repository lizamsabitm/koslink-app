<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya - KosLink</title>
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
                
                {{-- LOGIKA 1: Jika PENYEWA, Tampilkan Riwayat --}}
                @if(Auth::user()->role === 'user')
                    <a href="{{ route('booking.history') }}" class="btn btn-outline-primary btn-sm rounded-pill px-3">
                        <i class="fas fa-history me-1"></i> Riwayat
                    </a>
                @endif

                {{-- LOGIKA 2: Jika JURAGAN/ADMIN, Tampilkan Tombol Dashboard --}}
                @if(Auth::user()->role === 'owner' || Auth::user()->role === 'admin')
                    <a href="{{ route('dashboard') }}" class="btn btn-primary btn-sm rounded-pill px-3">
                        <i class="fas fa-columns me-1"></i> Dashboard Juragan
                    </a>
                @endif

                {{-- TOMBOL KEMBALI (Muncul untuk Semua) --}}
                <a href="{{ url('/') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                    <i class="fas fa-arrow-left me-1"></i> Home
                </a>

            </div>
        </div>
    </nav>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                
                <h3 class="fw-bold mb-4">⚙️ Pengaturan Profil</h3>

                @if (session('status') === 'profile-updated')
                    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                        ✅ <strong>Berhasil!</strong> Profil kamu sudah diperbarui.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                
                @if (session('status') === 'password-updated')
                    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                        🔒 <strong>Berhasil!</strong> Password telah diganti.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-3 text-primary"><i class="fas fa-user-edit me-2"></i>Informasi Akun</h5>
                        
                        <form method="post" action="{{ route('profile.update') }}">
                            @csrf
                            @method('patch') <div class="mb-3">
                                <label class="form-label text-muted small fw-bold">Nama Lengkap</label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required>
                                
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-muted small fw-bold">Email</label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required>
                                
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-muted small fw-bold">No. Handphone / WhatsApp</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light text-muted">+62</span>
                                    <input type="number" name="no_hp" class="form-control @error('no_hp') is-invalid @enderror" value="{{ old('no_hp', $user->no_hp) }}" placeholder="81234567890" required>
                                </div>
                                <small class="text-muted" style="font-size: 11px;">*Nomor ini akan digunakan untuk fitur Chat WhatsApp.</small>
                                
                                @error('no_hp')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm">
                                Simpan Perubahan
                            </button>
                        </form>
                    </div>
                </div>

                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-3 text-warning"><i class="fas fa-key me-2"></i>Ganti Password</h5>
                        
                        <form method="post" action="{{ route('password.update') }}">
                            @csrf
                            @method('put')

                            <div class="mb-3">
                                <label class="form-label text-muted small fw-bold">Password Saat Ini</label>
                                <input type="password" name="current_password" class="form-control @error('current_password', 'updatePassword') is-invalid @enderror" placeholder="Masukkan password lama">
                                
                                @error('current_password', 'updatePassword')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-muted small fw-bold">Password Baru</label>
                                <input type="password" name="password" class="form-control @error('password', 'updatePassword') is-invalid @enderror" placeholder="Minimal 8 karakter">
                                
                                @error('password', 'updatePassword')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-muted small fw-bold">Konfirmasi Password Baru</label>
                                <input type="password" name="password_confirmation" class="form-control" placeholder="Ketik ulang password baru">
                            </div>

                            <button type="submit" class="btn btn-warning text-white rounded-pill px-4 fw-bold shadow-sm">
                                Update Password
                            </button>
                        </form>
                    </div>
                </div>

                <div class="card border-0 shadow-sm rounded-4 bg-danger text-white">
                    <div class="card-body p-4 d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="fw-bold mb-1">Keluar Aplikasi</h5>
                            <p class="mb-0 small opacity-75">Selesai menggunakan KosLink?</p>
                        </div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-light text-danger fw-bold rounded-pill px-4 shadow-sm">
                                Log Out
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
