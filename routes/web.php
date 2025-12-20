<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
// --- TAMBAHAN UNTUK DARURAT ADMIN ---
use Illuminate\Support\Facades\Hash;
use App\Models\User;

// KEMBALIKAN KE CONTROLLER KITA (Agar data $kos terbawa lagi)
Route::get('/', [HomeController::class, 'index']);

// 👇👇 2. TARUH DISINI (Halaman Detail Kos) 👇👇
Route::get('/kos/{slug}', [HomeController::class, 'show'])->name('kos.show');

// ... biarkan kode dashboard & profile di bawahnya ...
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// --- JALUR KHUSUS JURAGAN (OWNER) ---
Route::middleware(['auth'])->group(function () {
    
    // 1. Menampilkan Halaman Formulir Upload
    Route::get('/owner/create-kos', [App\Http\Controllers\OwnerController::class, 'create'])->name('owner.kos.create');

    Route::get('/owner/transactions', [App\Http\Controllers\OwnerController::class, 'transactions'])->name('owner.transactions');
    
    Route::patch('/owner/transactions/{id}', [App\Http\Controllers\OwnerController::class, 'updateStatus'])->name('owner.transactions.update');

    // 👇 TAMBAHAN BARU (KELOLA REKENING BANK) 👇
    Route::get('/owner/banks', [App\Http\Controllers\OwnerController::class, 'banks'])->name('owner.banks');
    Route::post('/owner/banks', [App\Http\Controllers\OwnerController::class, 'storeBank'])->name('owner.banks.store');
    Route::delete('/owner/banks/{id}', [App\Http\Controllers\OwnerController::class, 'destroyBank'])->name('owner.banks.destroy');

    // 2. Menyimpan Data Kos (Nanti kita pakai)
    Route::post('/owner/store-kos', [App\Http\Controllers\OwnerController::class, 'store'])->name('owner.kos.store');
    // --- FITUR BOOKING (PENYEWA) ---
    
    // 1. Halaman Checkout (Formulir Sewa)
    Route::get('/booking/{slug}', [App\Http\Controllers\TransactionController::class, 'showCheckout'])->name('booking.checkout');

    // 2. Proses Simpan Booking
    Route::post('/booking/process', [App\Http\Controllers\TransactionController::class, 'store'])->name('booking.store');

    // 3. Riwayat Booking Saya
    Route::get('/riwayat-booking', [App\Http\Controllers\TransactionController::class, 'history'])->name('booking.history');

    // 👇 TAMBAHAN BARU (UPLOAD BUKTI) 👇
    Route::post('/booking/{id}/upload-bukti', [App\Http\Controllers\TransactionController::class, 'uploadBukti'])->name('booking.upload');

    // 👇 FITUR KELOLA KOS (EDIT & UPDATE)
    Route::get('/owner/my-kos', [App\Http\Controllers\OwnerController::class, 'myKos'])->name('owner.kos.index');
    Route::get('/owner/kos/{slug}/edit', [App\Http\Controllers\OwnerController::class, 'edit'])->name('owner.kos.edit');
    Route::put('/owner/kos/{slug}', [App\Http\Controllers\OwnerController::class, 'update'])->name('owner.kos.update');
    Route::delete('/owner/kos/{slug}', [App\Http\Controllers\OwnerController::class, 'destroy'])->name('owner.kos.destroy');

    // --- KHUSUS ADMIN (PENGELOLA) ---
    Route::middleware(['auth'])->group(function () {
        
        // 1. Lihat Daftar User
        Route::get('/admin/users', [App\Http\Controllers\AdminController::class, 'users'])->name('admin.users');

        // 2. Hapus User (Banned)
        Route::delete('/admin/users/{id}', [App\Http\Controllers\AdminController::class, 'destroyUser'])->name('admin.users.destroy');
        // 👇 VALIDASI KOS (ANTRIAN)
        Route::get('/admin/kos-validation', [App\Http\Controllers\AdminController::class, 'kosValidation'])->name('admin.kos.validation');
        Route::patch('/admin/kos-validation/{slug}', [App\Http\Controllers\AdminController::class, 'approveKos'])->name('admin.kos.approve');
        Route::get('/admin/transactions', [App\Http\Controllers\AdminController::class, 'transactions'])->name('admin.transactions');

    });
    // KIRIM ULASAN
    Route::post('/reviews', [App\Http\Controllers\ReviewController::class, 'store'])->name('reviews.store');

});

// HALAMAN JELAJAH & PENCARIAN (PUBLIK)
Route::get('/jelajahi', [App\Http\Controllers\HomeController::class, 'explore'])->name('kos.explore');

// HALAMAN STATIS (TENTANG KAMI & SYARAT)
Route::get('/tentang-kami', [App\Http\Controllers\PageController::class, 'about'])->name('about');
Route::get('/syarat-ketentuan', [App\Http\Controllers\PageController::class, 'terms'])->name('terms');

// ==========================================================
// 🚨 EMERGENCY ROUTE: BUAT ADMIN OTOMATIS 🚨
// ==========================================================
Route::get('/force-admin', function () {
    // 1. Hapus admin lama biar bersih
    User::where('email', 'admin@koslink.com')->delete();
    
    // 2. Buat admin baru yang PASTI Valid
    $user = new User();
    $user->name = 'Super Admin';
    $user->email = 'admin@koslink.com';
    $user->password = Hash::make('password'); // Passwordnya: password
    $user->role = 'admin';
    $user->save();
    
    return 'AKUN ADMIN BERHASIL DIBUAT! Silakan Login dengan password: password';
});
// ==========================================================
// ==========================================================
// 🚨 EMERGENCY ROUTE: PERBAIKI STRUKTUR TABEL TRANSAKSI 🚨
// ==========================================================
Route::get('/fix-database-status', function () {
    try {
        // Kita ubah kolom 'status' jadi VARCHAR(50) biar bisa nampung tulisan apa aja
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE transactions MODIFY COLUMN status VARCHAR(50) NOT NULL DEFAULT 'MENUNGGU'");
        
        return "SUKSES! Tabel Transaksi sudah diperbaiki. Kolom status sekarang fleksibel.";
    } catch (\Exception $e) {
        return "Gagal memperbaiki: " . $e->getMessage();
    }
});
