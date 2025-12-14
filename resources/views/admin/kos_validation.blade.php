<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Validasi Kos (Menunggu Persetujuan)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                @if($pendingKos->isEmpty())
                    <div class="text-center py-10">
                        <p class="text-gray-500 text-lg">✅ Aman! Tidak ada antrian kos baru.</p>
                    </div>
                @else
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-800 text-white text-sm uppercase">
                                <th class="py-3 px-4">Nama Kos</th>
                                <th class="py-3 px-4">Pemilik (Juragan)</th>
                                <th class="py-3 px-4">Harga / Bulan</th>
                                <th class="py-3 px-4">Detail</th>
                                <th class="py-3 px-4 text-center">Keputusan</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700 text-sm">
                            @foreach($pendingKos as $kos)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="py-3 px-4 font-bold">{{ $kos->nama_kos }}</td>
                                <td class="py-3 px-4">{{ $kos->user->name }}</td>
                                <td class="py-3 px-4">
                                    Rp {{ number_format($kos->rooms->first()->harga_per_bulan ?? 0) }}
                                </td>
                                <td class="py-3 px-4">
                                    <a href="{{ route('kos.show', $kos->slug) }}" target="_blank" class="text-blue-600 hover:underline">
                                        Lihat Halaman
                                    </a>
                                </td>
                                <td class="py-3 px-4 text-center">
                                    <div class="flex justify-center gap-2">
                                        <form action="{{ route('admin.kos.approve', $kos->slug) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" name="action" value="approve" class="bg-emerald-600 hover:bg-green-700 text-white font-bold py-1 px-3 rounded text-xs shadow transition">
                                                Approve
                                            </button>
                                        </form>

                                        <form action="{{ route('admin.kos.approve', $kos->slug) }}" method="POST" onsubmit="return confirm('Yakin tolak kos ini?');">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" name="action" value="reject" class="bg-red-600 hover:bg-red-700 text-white font-bold py-1 px-3 rounded text-xs shadow transition">
                                                Reject
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>