<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Pesanan Masuk') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    
                    @if($transaksi->isEmpty())
                        <p class="text-gray-500 text-center">Belum ada pesanan masuk, Juragan. Sabar ya!</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="bg-blue-50 text-blue-800 uppercase text-sm leading-normal">
                                        <th class="py-3 px-6">Penyewa</th>
                                        <th class="py-3 px-6">Kamar</th>
                                        <th class="py-3 px-6">Durasi</th>
                                        <th class="py-3 px-6">Bukti Transfer</th> 
                                        <th class="py-3 px-6">Status</th>
                                        <th class="py-3 px-6 text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="text-gray-600 text-sm font-light">
                                    @foreach($transaksi as $item)
                                    <tr class="border-b border-gray-200 hover:bg-gray-50">
                                        <td class="py-3 px-6 font-bold">
                                            {{ $item->user->name }}
                                            
                                            @if($item->user->no_hp)
                                                <div class="mt-1">
                                                    <a href="https://wa.me/{{ $item->user->no_hp }}?text=Halo {{ $item->user->name }}, saya pemilik kos. Mengenai pesanan kamu..." 
                                                       target="_blank"
                                                       class="text-green-600 hover:text-green-800 text-xs flex items-center gap-1">
                                                        <i class="fab fa-whatsapp"></i> Chat WA
                                                    </a>
                                                </div>
                                            @endif
                                        </td>
                                        <td class="py-3 px-6">
                                            {{ $item->room->boardingHouse->nama_kos }}
                                            <br>
                                            <span class="text-xs text-gray-400">{{ $item->room->nama_kamar }}</span>
                                        </td>
                                        <td class="py-3 px-6">{{ $item->durasi_sewa }} Bulan</td>
                                        
                                        <td class="py-3 px-6">
                                            @if($item->bukti_bayar)
                                                <a href="{{ asset($item->bukti_bayar) }}" target="_blank">
                                                    <img src="{{ asset($item->bukti_bayar) }}" class="w-16 h-16 object-cover rounded border hover:scale-150 transition" alt="Bukti">
                                                </a>
                                                <br>
                                                <small class="text-blue-500 underline cursor-pointer">Lihat Besar</small>
                                            @else
                                                <span class="text-red-400 text-xs italic">Belum Upload</span>
                                            @endif
                                        </td>

                                        <td class="py-3 px-6">
                                            <span class="bg-gray-200 text-gray-600 py-1 px-3 rounded-full text-xs font-bold">
                                                {{ $item->status }}
                                            </span>
                                        </td>
                                        
                                        <td class="py-3 px-6 text-center">
                                            @if($item->status == 'MENUNGGU VERIFIKASI')
                                                <div class="flex flex-col gap-2">
                                                    <form action="{{ route('owner.transactions.update', $item->id) }}" method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status" value="LUNAS">
                                                        <button class="w-full bg-emerald-600 hover:bg-green-700 text-white py-1 px-3 rounded text-xs shadow transition font-bold">
                                                            Sah / Lunas
                                                        </button>
                                                    </form>

                                                    <form action="{{ route('owner.transactions.update', $item->id) }}" method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status" value="DITOLAK">
                                                        <button class="w-full bg-red-600 hover:bg-red-700 text-white py-1 px-3 rounded text-xs shadow transition font-bold">
                                                            Tolak (Salah)
                                                        </button>
                                                    </form>
                                                </div>
                                            @elseif($item->status == 'MENUNGGU')
                                                <span class="text-xs text-gray-400 italic">Menunggu Upload...</span>
                                            @else
                                                <span class="text-green-600 text-xs font-bold border border-green-600 px-2 py-1 rounded">Selesai</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>