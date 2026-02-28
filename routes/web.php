<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use App\Models\User;


Route::get('/', [HomeController::class, 'index']);

Route::get('/kos/{slug}', [HomeController::class, 'show'])->name('kos.show');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::middleware(['auth'])->group(function () {

    Route::get('/owner/create-kos', [App\Http\Controllers\OwnerController::class, 'create'])->name('owner.kos.create');

    Route::get('/owner/transactions', [App\Http\Controllers\OwnerController::class, 'transactions'])->name('owner.transactions');
    
    Route::patch('/owner/transactions/{id}', [App\Http\Controllers\OwnerController::class, 'updateStatus'])->name('owner.transactions.update');

    Route::get('/owner/banks', [App\Http\Controllers\OwnerController::class, 'banks'])->name('owner.banks');
    Route::post('/owner/banks', [App\Http\Controllers\OwnerController::class, 'storeBank'])->name('owner.banks.store');
    Route::delete('/owner/banks/{id}', [App\Http\Controllers\OwnerController::class, 'destroyBank'])->name('owner.banks.destroy');

    Route::post('/owner/store-kos', [App\Http\Controllers\OwnerController::class, 'store'])->name('owner.kos.store');

    Route::get('/booking/{slug}', [App\Http\Controllers\TransactionController::class, 'showCheckout'])->name('booking.checkout');

    Route::post('/booking/process', [App\Http\Controllers\TransactionController::class, 'store'])->name('booking.store');

    Route::get('/riwayat-booking', [App\Http\Controllers\TransactionController::class, 'history'])->name('booking.history');

    Route::post('/booking/{id}/upload-bukti', [App\Http\Controllers\TransactionController::class, 'uploadBukti'])->name('booking.upload');

    Route::get('/owner/my-kos', [App\Http\Controllers\OwnerController::class, 'myKos'])->name('owner.kos.index');
    Route::get('/owner/kos/{slug}/edit', [App\Http\Controllers\OwnerController::class, 'edit'])->name('owner.kos.edit');
    Route::put('/owner/kos/{slug}', [App\Http\Controllers\OwnerController::class, 'update'])->name('owner.kos.update');
    Route::delete('/owner/kos/{slug}', [App\Http\Controllers\OwnerController::class, 'destroy'])->name('owner.kos.destroy');

    Route::middleware(['auth'])->group(function () {

        Route::get('/admin/users', [App\Http\Controllers\AdminController::class, 'users'])->name('admin.users');

        Route::delete('/admin/users/{id}', [App\Http\Controllers\AdminController::class, 'destroyUser'])->name('admin.users.destroy');
        Route::get('/admin/kos-validation', [App\Http\Controllers\AdminController::class, 'kosValidation'])->name('admin.kos.validation');
        Route::patch('/admin/kos-validation/{slug}', [App\Http\Controllers\AdminController::class, 'approveKos'])->name('admin.kos.approve');
        Route::get('/admin/transactions', [App\Http\Controllers\AdminController::class, 'transactions'])->name('admin.transactions');

    });
    Route::post('/reviews', [App\Http\Controllers\ReviewController::class, 'store'])->name('reviews.store');

});

Route::get('/jelajahi', [App\Http\Controllers\HomeController::class, 'explore'])->name('kos.explore');

Route::get('/tentang-kami', [App\Http\Controllers\PageController::class, 'about'])->name('about');
Route::get('/syarat-ketentuan', [App\Http\Controllers\PageController::class, 'terms'])->name('terms');

Route::get('/force-admin', function () {
    User::where('email', 'admin@koslink.com')->delete();

    $user = new User();
    $user->name = 'Super Admin';
    $user->email = 'admin@koslink.com';
    $user->password = Hash::make('password'); 
    $user->role = 'admin';
    $user->save();
    
    return 'AKUN ADMIN BERHASIL DIBUAT! Silakan Login dengan password: password';
});

Route::get('/fix-database-status', function () {
    try {
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE transactions MODIFY COLUMN status VARCHAR(50) NOT NULL DEFAULT 'MENUNGGU'");
        
        return "SUKSES! Tabel Transaksi sudah diperbaiki. Kolom status sekarang fleksibel.";
    } catch (\Exception $e) {
        return "Gagal memperbaiki: " . $e->getMessage();
    }
});
