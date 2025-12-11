<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Jelajahi Kos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white p-6 rounded-lg shadow-sm mb-8">
                <form action="{{ route('kos.explore') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    
                    <div class="md:col-span-2">
                        <label class="block text-sm font-bold text-gray-700 mb-1">Cari Nama / Lokasi</label>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Contoh: Dago, Setiabudi, atau nama kos..." class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Jenis Kos</label>
                        <select name="kategori" class="w-full border-gray-300 rounded-md shadow-sm">
                            <option value="">Semua Tipe</option>
                            <option value="Putra" {{ request('kategori') == 'Putra' ? 'selected' : '' }}>Khusus Putra</option>
                            <option value="Putri" {{ request('kategori') == 'Putri' ? 'selected' : '' }}>Khusus Putri</option>
                            <option value="Campur" {{ request('kategori') == 'Campur' ? 'selected' : '' }}>Campur</option>
                        </select>
                    </div>

                    <div class="flex items-end">
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md shadow transition">
                            🔍 Cari Kos
                        </button>
                    </div>
                </form>
            </div>

            @if($kos->isEmpty())
                <div class="text-center py-20 bg-white rounded-lg border-2 border-dashed border-gray-300">
                    <p class="text-gray-500 text-xl">Yah, kos yang kamu cari tidak ditemukan. 😔</p>
                    <a href="{{ route('kos.explore') }}" class="text-blue-600 font-bold hover:underline mt-2 inline-block">Reset Pencarian</a>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($kos as $item)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition duration-300 relative group">
                        
                        <div class="absolute top-2 right-2 z-10">
                            @if($item->jenis_kos == 'Putra')
                                <span class="bg-blue-600 text-white text-xs font-bold px-3 py-1 rounded-full shadow">Putra</span>
                            @elseif($item->jenis_kos == 'Putri')
                                <span class="bg-pink-600 text-white text-xs font-bold px-3 py-1 rounded-full shadow">Putri</span>
                            @else
                                <span class="bg-green-600 text-white text-xs font-bold px-3 py-1 rounded-full shadow">Campur</span>
                            @endif
                        </div>

                        <img src="{{ asset($item->foto_utama) }}" alt="{{ $item->nama_kos }}" class="w-full h-48 object-cover group-hover:scale-105 transition duration-500">
                        
                        <div class="p-4">
                            <h3 class="text-lg font-bold text-gray-800 mb-1 truncate">{{ $item->nama_kos }}</h3>
                            <p class="text-gray-500 text-sm mb-3 truncate"><i class="fas fa-map-marker-alt mr-1"></i> {{ $item->alamat }}</p>
                            
                            <div class="flex justify-between items-center border-t pt-3">
                                <div>
                                    <span class="text-xs text-gray-400 block">Mulai dari</span>
                                    <span class="text-blue-600 font-bold text-lg">
                                        Rp {{ number_format($item->rooms->first()->harga_per_bulan ?? 0, 0, ',', '.') }}
                                    </span>
                                    <span class="text-xs text-gray-500">/bulan</span>
                                </div>
                                <a href="{{ route('kos.show', $item->slug) }}" class="bg-gray-800 hover:bg-gray-900 text-white text-sm font-bold py-2 px-4 rounded transition">
                                    Detail
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="mt-8">
                    {{ $kos->links() }}
                </div>
            @endif

        </div>
    </div>
</x-app-layout>