<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Monitoring Transaksi (Global)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                @if($transaksi->isEmpty())
                    <p class="text-center text-gray-500 py-10">Belum ada transaksi apapun di sistem.</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse text-sm">
                            <thead>
                                <tr class="bg-gray-800 text-white uppercase">
                                    <th class="p-3">Tanggal</th>
                                    <th class="p-3">Penyewa</th>
                                    <th class="p-3">Info Kos</th>
                                    <th class="p-3">Pemilik (Juragan)</th>
                                    <th class="p-3">Total Bayar</th>
                                    <th class="p-3">Bukti</th>
                                    <th class="p-3">Status</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-700">
                                @foreach($transaksi as $item)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="p-3">{{ $item->created_at->format('d M Y, H:i') }}</td>
                                    
                                    <td class="p-3 font-bold">{{ $item->user->name }}</td>
                                    
                                    <td class="p-3">
                                        {{ $item->room->boardingHouse->nama_kos }}
                                        <div class="text-xs text-gray-500">{{ $item->room->nama_kamar }} ({{ $item->durasi_sewa }} Bln)</div>
                                    </td>
                                    
                                    <td class="p-3 text-blue-600">
                                        {{ $item->room->boardingHouse->user->name }}
                                    </td>
                                    
                                    <td class="p-3 font-bold">
                                        Rp {{ number_format($item->total_harga) }}
                                    </td>
                                    
                                    <td class="p-3">
                                        @if($item->bukti_bayar)
                                            <a href="{{ asset($item->bukti_bayar) }}" target="_blank" class="text-blue-500 hover:underline text-xs">
                                                Lihat Foto
                                            </a>
                                        @else
                                            <span class="text-gray-400 text-xs">-</span>
                                        @endif
                                    </td>

                                    <td class="p-3">
                                        @if($item->status == 'LUNAS')
                                            <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs font-bold">LUNAS</span>
                                        @elseif($item->status == 'DITOLAK')
                                            <span class="bg-red-100 text-red-800 px-2 py-1 rounded text-xs font-bold">DITOLAK</span>
                                        @elseif($item->status == 'MENUNGGU VERIFIKASI')
                                            <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs font-bold">VERIFIKASI</span>
                                        @else
                                            <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-xs font-bold">PENDING</span>
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
</x-app-layout>