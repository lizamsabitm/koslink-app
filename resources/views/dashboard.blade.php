<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    {{-- 1. TAMPILKAN KHUSUS JURAGAN --}}
                    @if(Auth::user()->role === 'owner')
                        <h3 class="text-lg font-bold text-blue-600 mb-2">Halo, Juragan {{ Auth::user()->name }}! 👋</h3>
                        <p class="mb-4">Siap menyewakan kamar kosmu hari ini?</p>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <a href="{{ route('owner.kos.index') }}" class="block border p-4 rounded-lg bg-blue-50 cursor-pointer hover:bg-blue-100 transition shadow-sm">
                                <h4 class="font-bold text-blue-800">🏠 Properti Saya</h4>
                                <p class="text-sm text-gray-600">Lihat daftar kos, edit stok kamar, atau tambah baru.</p>
                            </a>
    
                            <a href="{{ route('owner.transactions') }}" class="block border p-4 rounded-lg bg-green-50 cursor-pointer hover:bg-green-100 transition shadow-sm">
                                <h4 class="font-bold text-green-800">💰 Data Penyewa</h4>
                                <p class="text-sm text-gray-600">Cek siapa saja yang sudah booking kamarmu.</p>
                            </a>

                            <a href="{{ route('owner.banks') }}" class="block border p-4 rounded-lg bg-yellow-50 cursor-pointer hover:bg-yellow-100 transition shadow-sm">
                                <h4 class="font-bold text-yellow-800">💳 Rekening Bank</h4>
                                <p class="text-sm text-gray-600">Atur metode pembayaran untuk penyewa.</p>
                            </a>
                        </div>

                    {{-- 2. TAMPILKAN KHUSUS ADMIN --}}
                    @elseif(Auth::user()->role === 'admin')
                        <h3 class="text-lg font-bold text-red-600 mb-2">Selamat Datang, Administrator! 🛡️</h3>
                        <p class="mb-4">Pantau aktivitas website dan kelola pengguna.</p>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <a href="{{ route('admin.users') }}" class="block border p-4 rounded-lg bg-orange-50 cursor-pointer hover:bg-orange-100 transition shadow-sm">
                                <h4 class="font-bold text-orange-800">👥 Kelola User</h4>
                                <p class="text-sm text-gray-600">Lihat daftar dan hapus akun bermasalah.</p>
                            </a>

                            <a href="{{ route('admin.kos.validation') }}" class="block border p-4 rounded-lg bg-green-50 cursor-pointer hover:bg-green-100 transition shadow-sm">
                                <h4 class="font-bold text-green-800">✅ Validasi Kos</h4>
                                <p class="text-sm text-gray-600">Cek kos baru yang perlu persetujuan.</p>
                            </a>

                            <a href="{{ route('admin.transactions') }}" class="block border p-4 rounded-lg bg-purple-50 cursor-pointer hover:bg-purple-100 transition shadow-sm">
                                <h4 class="font-bold text-purple-800">📊 Data Transaksi</h4>
                                <p class="text-sm text-gray-600">Pantau semua pembayaran yang masuk.</p>
                            </a>
                        </div>

                    {{-- 3. TAMPILKAN KHUSUS PENYEWA --}}
                    @else
                        <h3 class="text-lg font-bold text-green-600 mb-2">Halo, Kak {{ Auth::user()->name }}! 🎒</h3>
                        <p class="mb-4">Belum dapat kos? Jangan khawatir, kami bantu carikan.</p>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <a href="{{ route('kos.explore') }}" class="border p-4 rounded-lg bg-indigo-50 block hover:bg-indigo-100 transition shadow-sm">
                                <h4 class="font-bold">🔍 Cari Kos Sekarang</h4>
                                <p class="text-sm text-gray-600">Jelajahi ribuan kos nyaman di sekitarmu.</p>
                            </a>
                            
                            <div class="border p-4 rounded-lg bg-gray-50">
                                <h4 class="font-bold">🔖 Kos Favorit</h4>
                                <p class="text-sm text-gray-600">Lihat kos yang sudah kamu simpan.</p>
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
