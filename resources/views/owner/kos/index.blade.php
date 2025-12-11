<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Kelola Kos Saya') }}
            </h2>
            
            <a href="{{ route('owner.kos.create') }}" style="background-color: #203FE5;" class="text-white font-bold py-2 px-4 rounded shadow text-sm hover:opacity-90 transition">
    + Tambah Kos Baru
</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                @if(session('success'))
                    <div class="bg-green-100 text-green-700 p-3 rounded mb-4">{{ session('success') }}</div>
                @endif

                @if($allKos->isEmpty())
                    <div class="text-center py-10">
                        <p class="text-gray-500 mb-4">Kamu belum punya properti kos.</p>
                        <a href="{{ route('owner.kos.create') }}" class="text-blue-600 font-bold hover:underline">Mulai Upload Sekarang</a>
                    </div>
                @else
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-100 border-b">
                                <th class="p-3">Nama Kos</th>
                                <th class="p-3">Harga</th>
                                <th class="p-3">Stok</th>
                                <th class="p-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($allKos as $kos)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="p-3 font-bold">{{ $kos->nama_kos }}</td>
                                <td class="p-3">Rp {{ number_format($kos->rooms->first()->harga_per_bulan) }}</td>
                                <td class="p-3 font-bold text-blue-600">{{ $kos->rooms->first()->stok_kamar }} Kamar</td>
                                <td class="p-3 text-center flex justify-center gap-2">
                                    <a href="{{ route('owner.kos.edit', $kos->slug) }}" class="bg-yellow-400 hover:bg-yellow-500 text-yellow-900 px-3 py-1 rounded text-sm font-bold transition">
                                        Edit
                                    </a>
                                    <form action="{{ route('owner.kos.destroy', $kos->slug) }}" method="POST" onsubmit="return confirm('Yakin hapus?');">
                                        @csrf @method('DELETE')
                                        <button class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-sm transition">
                                            Hapus
                                        </button>
                                    </form>
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