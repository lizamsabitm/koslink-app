<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelola Metode Pembayaran') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <h3 class="font-bold text-lg mb-4">➕ Tambah Rekening Baru</h3>
                    
                    <form action="{{ route('owner.banks.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="block text-sm font-bold mb-1">Nama Bank / E-Wallet</label>
                            <input type="text" name="nama_bank" class="w-full border rounded px-3 py-2" placeholder="Contoh: BCA / DANA" required>
                        </div>
                        <div class="mb-3">
                            <label class="block text-sm font-bold mb-1">Nomor Rekening</label>
                            <input type="number" name="nomor_rekening" class="w-full border rounded px-3 py-2" placeholder="Contoh: 1234567890" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-bold mb-1">Atas Nama</label>
                            <input type="text" name="atas_nama" class="w-full border rounded px-3 py-2" placeholder="Nama Pemilik Rekening" required>
                        </div>
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 rounded">
                            Simpan Rekening
                        </button>
                    </form>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <h3 class="font-bold text-lg mb-4">🏦 Rekening Terdaftar</h3>
                    
                    @if($rekening->isEmpty())
                        <p class="text-gray-500 text-sm">Belum ada rekening. Tambahkan dulu!</p>
                    @else
                        <ul class="space-y-3">
                            @foreach($rekening as $bank)
                                <li class="flex justify-between items-center border-b pb-2">
                                    <div>
                                        <p class="font-bold text-blue-800">{{ $bank->nama_bank }}</p>
                                        <p class="text-sm font-mono">{{ $bank->nomor_rekening }}</p>
                                        <p class="text-xs text-gray-500">a.n {{ $bank->atas_nama }}</p>
                                    </div>
                                    
                                    <form action="{{ route('owner.banks.destroy', $bank->id) }}" method="POST" onsubmit="return confirm('Yakin hapus rekening ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 text-sm font-bold">
                                            Hapus
                                        </button>
                                    </form>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>

            </div>
        </div>
    </div>
</x-app-layout>