<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <h2 class="font-bold text-2xl mb-6 text-gray-950">Konfirmasi Sewa</h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                
                <div class="md:col-span-1">
                    <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                        <img src="{{ asset($kos->foto_utama) }}" class="w-full h-48 object-cover" alt="Foto Kos">
                        <div class="p-4">
                            <h3 class="font-bold text-lg">{{ $kos->nama_kos }}</h3>
                            <p class="text-sm text-gray-500 mb-2">{{ $kos->alamat }}</p>
                            <div class="border-t pt-2 mt-2">
                                <span class="text-xs text-gray-400 uppercase">Tipe Kamar</span>
                                <p class="font-bold text-blue-600">{{ $kamar->nama_kamar }}</p>
                            </div>
                            <div class="border-t pt-2 mt-2">
                                <span class="text-xs text-gray-400 uppercase">Harga per Bulan</span>
                                <p class="font-bold">Rp {{ number_format($kamar->harga_per_bulan, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="md:col-span-2">
                    <div class="bg-white p-6 shadow-sm rounded-lg">
                        
                        @if(session('error'))
                            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                                {{ session('error') }}
                            </div>
                        @endif

                        <form action="{{ route('booking.store') }}" method="POST">
                            @csrf
                            
                            <input type="hidden" name="room_id" value="{{ $kamar->id }}">

                            <div class="mb-4">
                                <label class="block text-gray-700 font-bold mb-2">Mau mulai ngekos tanggal berapa?</label>
                                <input type="date" name="start_date" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                            </div>

                            <div class="mb-6">
                                <label class="block text-gray-700 font-bold mb-2">Mau sewa berapa bulan?</label>
                                <select name="duration" class="w-full border-gray-300 rounded-lg shadow-sm">
                                    <option value="1">1 Bulan</option>
                                    <option value="3">3 Bulan</option>
                                    <option value="6">6 Bulan</option>
                                    <option value="12">1 Tahun</option>
                                </select>
                                <p class="text-xs text-gray-500 mt-1">*Total harga akan dihitung otomatis oleh sistem.</p>
                            </div>

                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                                <h4 class="font-bold text-blue-800 mb-2">Informasi Pembayaran</h4>
                                <p class="text-sm text-gray-600 mb-3">Silakan transfer ke salah satu rekening pemilik kos berikut:</p>
                                
                                @if($rekeningJuragan->isEmpty())
                                    <p class="text-red-500 text-sm italic">Pemilik belum memasukkan info rekening. Silakan hubungi via WhatsApp.</p>
                                @else
                                    <div class="space-y-2">
                                        @foreach($rekeningJuragan as $bank)
                                            <div class="flex items-center bg-white p-2 rounded border">
                                                <img src="https://cdn-icons-png.flaticon.com/512/2534/2534204.png" class="w-8 h-8 mr-3 opacity-50">
                                                <div>
                                                    <p class="font-bold text-gray-800">{{ $bank->nama_bank }}</p>
                                                    <p class="font-mono text-sm text-blue-600">{{ $bank->nomor_rekening }}</p>
                                                    <p class="text-xs text-gray-500">a.n {{ $bank->atas_nama }}</p>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>

                            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg shadow-lg transition transform hover:scale-105">
                                💳 Ajukan Sewa & Bayar
                            </button>
                            
                            <a href="{{ url()->previous() }}" class="block text-center mt-4 text-gray-500 hover:underline">Batal</a>
                        </form>

                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>