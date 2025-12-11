<x-app-layout>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    
    <style>
        #map {
            height: 350px;
            width: 100%;
            z-index: 1;
            border-radius: 8px;
            border: 2px solid #bfdbfe;
        }
    </style>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Data Kos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-bold">Edit Kos: {{ $kos->nama_kos }}</h3>
                        <a href="{{ route('owner.kos.index') }}" class="text-sm text-gray-500 hover:text-gray-700">← Kembali</a>
                    </div>

                    <form action="{{ route('owner.kos.update', $kos->slug) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT') <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Nama Kos</label>
                            <input type="text" name="nama_kos" value="{{ old('nama_kos', $kos->nama_kos) }}" class="w-full border rounded px-3 py-2" required>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Jenis Penghuni</label>
                            <select name="jenis_kos" class="w-full border rounded px-3 py-2 bg-white">
                                <option value="Campur" {{ $kos->jenis_kos == 'Campur' ? 'selected' : '' }}>Campur (Putra/Putri)</option>
                                <option value="Putra" {{ $kos->jenis_kos == 'Putra' ? 'selected' : '' }}>Khusus Putra 👨</option>
                                <option value="Putri" {{ $kos->jenis_kos == 'Putri' ? 'selected' : '' }}>Khusus Putri 👩</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Deskripsi Singkat</label>
                            <textarea name="deskripsi" class="w-full border rounded px-3 py-2" rows="3">{{ old('deskripsi', $kos->deskripsi) }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Alamat Lengkap</label>
                            <input type="text" name="alamat" value="{{ old('alamat', $kos->alamat) }}" class="w-full border rounded px-3 py-2" required>
                        </div>

                        <div class="mb-6">
                            <label class="block text-gray-700 text-sm font-bold mb-2">📍 Update Lokasi (Geser Pin)</label>
                            <p class="text-xs text-gray-500 mb-2">Peta otomatis menampilkan lokasi lama. Geser pin jika ingin mengubah lokasi.</p>
                            
                            <div id="map"></div>

                            <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude', $kos->latitude) }}">
                            <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude', $kos->longitude) }}">
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Harga per Bulan</label>
                                <input type="number" name="harga_per_bulan" value="{{ old('harga_per_bulan', $kos->rooms->first()->harga_per_bulan ?? 0) }}" class="w-full border rounded px-3 py-2" required>
                            </div>

                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Jumlah Kamar Kosong</label>
                                <input type="number" name="stok_kamar" value="{{ old('stok_kamar', $kos->rooms->first()->stok_kamar ?? 0) }}" class="w-full border rounded px-3 py-2" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Ganti Foto Depan (Opsional)</label>
                            <div class="mb-2">
                                <img src="{{ asset($kos->foto_utama) }}" class="h-20 w-20 object-cover rounded border">
                            </div>
                            <input type="file" name="foto_utama" class="w-full border rounded px-3 py-2" accept="image/*">
                            <p class="text-xs text-gray-500 mt-1">Biarkan kosong jika tidak ingin mengganti foto.</p>
                        </div>

                        <div class="mb-6">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Fasilitas Tersedia</label>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                                @php
                                    // Ambil fasilitas lama & ubah jadi array biar bisa dicek (checked)
                                    $fasilitasLama = explode(', ', $kos->rooms->first()->fasilitas ?? '');
                                @endphp

                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="fasilitas[]" value="WiFi" class="form-checkbox text-blue-600" {{ in_array('WiFi', $fasilitasLama) ? 'checked' : '' }}>
                                    <span class="ml-2">WiFi</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="fasilitas[]" value="AC" class="form-checkbox text-blue-600" {{ in_array('AC', $fasilitasLama) ? 'checked' : '' }}>
                                    <span class="ml-2">AC</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="fasilitas[]" value="Kamar Mandi Dalam" class="form-checkbox text-blue-600" {{ in_array('Kamar Mandi Dalam', $fasilitasLama) ? 'checked' : '' }}>
                                    <span class="ml-2">KM Dalam</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="fasilitas[]" value="Kasur" class="form-checkbox text-blue-600" {{ in_array('Kasur', $fasilitasLama) ? 'checked' : '' }}>
                                    <span class="ml-2">Kasur</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="fasilitas[]" value="Lemari" class="form-checkbox text-blue-600" {{ in_array('Lemari', $fasilitasLama) ? 'checked' : '' }}>
                                    <span class="ml-2">Lemari</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="fasilitas[]" value="Parkir Motor" class="form-checkbox text-blue-600" {{ in_array('Parkir Motor', $fasilitasLama) ? 'checked' : '' }}>
                                    <span class="ml-2">Parkir Motor</span>
                                </label>
                            </div>
                        </div>

                        <div class="flex justify-end gap-2">
                            <a href="{{ route('owner.kos.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded-lg">
                                Batal
                            </a>
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg shadow-lg">
                                Simpan Perubahan
                            </button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            
            // 1. Ambil Koordinat Lama dari Database (Atau default Monas jika kosong)
            // Tanda ?? artinya: Kalau datanya null, pakai angka sebelah kanan
            var savedLat = {{ $kos->latitude ?? -6.175392 }};
            var savedLng = {{ $kos->longitude ?? 106.827153 }};

            // 2. Inisialisasi Peta di posisi lama
            var map = L.map('map').setView([savedLat, savedLng], 15);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            // 3. Taruh Marker di posisi lama
            var marker = L.marker([savedLat, savedLng], {
                draggable: true // Boleh digeser
            }).addTo(map);

            // Fungsi Update Input
            function updateInput(lat, lng) {
                document.getElementById('latitude').value = lat;
                document.getElementById('longitude').value = lng;
            }

            // Saat marker digeser, update input
            marker.on('dragend', function (e) {
                var lat = marker.getLatLng().lat;
                var lng = marker.getLatLng().lng;
                updateInput(lat, lng);
            });

            // Saat peta diklik, pindahkan marker
            map.on('click', function(e) {
                var lat = e.latlng.lat;
                var lng = e.latlng.lng;
                marker.setLatLng([lat, lng]); 
                updateInput(lat, lng); 
            });
            
            // Trik agar peta tidak blank
            setTimeout(function(){ map.invalidateSize(); }, 500);
        });
    </script>

</x-app-layout>