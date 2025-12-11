<x-app-layout>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    
    <style>
        #map {
            height: 350px; /* Tinggi Paksa */
            width: 100%;   /* Lebar Paksa */
            z-index: 1;    /* Pastikan di atas layer lain */
            border-radius: 8px;
            border: 2px solid #bfdbfe;
        }
    </style>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Upload Kos Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <h3 class="text-lg font-bold mb-4">Isi Data Kos Kamu</h3>

                    <form action="{{ route('owner.kos.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Nama Kos</label>
                            <input type="text" name="nama_kos" class="w-full border rounded px-3 py-2" placeholder="Contoh: Kos Melati Indah" required>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Jenis Penghuni</label>
                            <select name="jenis_kos" class="w-full border rounded px-3 py-2 bg-white">
                                <option value="Campur">Campur (Putra/Putri)</option>
                                <option value="Putra">Khusus Putra 👨</option>
                                <option value="Putri">Khusus Putri 👩</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Deskripsi Singkat</label>
                            <textarea name="deskripsi" class="w-full border rounded px-3 py-2" rows="3" placeholder="Ceritakan kelebihan kosmu (tambahkan fasilitas tertentu jika tidak ada pilihan di fasilitas tersedia)"></textarea>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Alamat Lengkap</label>
                            <input type="text" name="alamat" class="w-full border rounded px-3 py-2" placeholder="Jalan, Nomor, Kelurahan, Kecamatan, Kota" required>
                        </div>

                        <div class="mb-6">
                            <label class="block text-gray-700 text-sm font-bold mb-2">📍 Tandai Lokasi di Peta (Wajib)</label>
                            <p class="text-xs text-gray-500 mb-2">Geser peta dan klik untuk menaruh pin di lokasi kos yang tepat.</p>
                            
                            <div id="map"></div>

                            <input type="hidden" name="latitude" id="latitude" required>
                            <input type="hidden" name="longitude" id="longitude" required>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Harga per Bulan (Rupiah)</label>
                                <input type="number" name="harga_per_bulan" class="w-full border rounded px-3 py-2" placeholder="Contoh: 800000" required>
                            </div>

                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Jumlah Kamar Kosong</label>
                                <input type="number" name="stok_kamar" class="w-full border rounded px-3 py-2" placeholder="Contoh: 5" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Foto Depan Kos</label>
                            <input type="file" name="foto_utama" class="w-full border rounded px-3 py-2" accept="image/*" required>
                            <p class="text-xs text-gray-500 mt-1">*Format JPG/PNG, Max 2MB</p>
                        </div>

                        <div class="mb-6">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Fasilitas Tersedia</label>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="fasilitas[]" value="WiFi" class="form-checkbox text-blue-600">
                                    <span class="ml-2">WiFi</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="fasilitas[]" value="AC" class="form-checkbox text-blue-600">
                                    <span class="ml-2">AC</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="fasilitas[]" value="Kamar Mandi Dalam" class="form-checkbox text-blue-600">
                                    <span class="ml-2">KM Dalam</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="fasilitas[]" value="Kasur" class="form-checkbox text-blue-600">
                                    <span class="ml-2">Kasur</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="fasilitas[]" value="Lemari" class="form-checkbox text-blue-600">
                                    <span class="ml-2">Lemari</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="fasilitas[]" value="Parkir Motor" class="form-checkbox text-blue-600">
                                    <span class="ml-2">Parkir Motor</span>
                                </label>
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg shadow-lg transform transition hover:scale-105">
                                🚀 Terbitkan Iklan Kos
                            </button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    
    <script>
        // Pastikan halaman sudah siap (DOM Ready) baru jalankan peta
        document.addEventListener('DOMContentLoaded', function() {
            
            // 1. Inisialisasi Peta (Default: Jakarta / Monas)
            var map = L.map('map').setView([-6.175392, 106.827153], 13);

            // 2. Tampilkan Gambar Peta (Tile Layer)
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            // 3. Tambah Marker yang bisa digeser
            var marker = L.marker([-6.175392, 106.827153], {
                draggable: true
            }).addTo(map);

            // Fungsi Update Input Koordinat
            function updateInput(lat, lng) {
                document.getElementById('latitude').value = lat;
                document.getElementById('longitude').value = lng;
            }

            // Set nilai awal
            updateInput(-6.175392, 106.827153);

            // Event: Saat marker digeser
            marker.on('dragend', function (e) {
                var lat = marker.getLatLng().lat;
                var lng = marker.getLatLng().lng;
                updateInput(lat, lng);
            });

            // Event: Saat peta diklik
            map.on('click', function(e) {
                var lat = e.latlng.lat;
                var lng = e.latlng.lng;
                marker.setLatLng([lat, lng]); 
                updateInput(lat, lng); 
            });
            
            // Trik khusus agar peta merender ulang ukurannya saat dimuat
            setTimeout(function(){ map.invalidateSize(); }, 500);
        });
    </script>

</x-app-layout>