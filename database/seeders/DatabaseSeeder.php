<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\BoardingHouse;
use App\Models\Room;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        
        User::create([
            'name' => 'Fajar Administrator',
            'email' => 'admin@koslink.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'no_hp' => '08111111111'
        ]);

        User::create([
            'name' => 'Rizky Penyewa',
            'email' => 'rizky@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'user',
            'no_hp' => '08222222222'
        ]);

        $dataLengkap = [
            [
                'pemilik_nama' => 'Haji Budi Santoso',
                'pemilik_email' => 'haji.budi@gmail.com',
            
                'kos_nama' => 'Pondok Damai (Putra)',
                'kota' => 'Yogyakarta',
                'alamat' => 'Jl. Kaliurang KM 5',
                'deskripsi' => 'Kos khusus putra, lingkungan tenang, masjid dekat.',
                'harga' => 650000,
                'fasilitas' => 'Kasur Busa, KM Luar, Parkir Motor'
            ],
            [
             
                'pemilik_nama' => 'Ibu Siti Aminah',
                'pemilik_email' => 'siti.aminah@yahoo.com',
          
                'kos_nama' => 'Wisma Muslimah',
                'kota' => 'Yogyakarta',
                'alamat' => 'Jl. Gejayan Gg. Jembatan Merah',
                'deskripsi' => 'Kos putri bersih, aman, wajib jam malam pukul 22.00.',
                'harga' => 700000,
                'fasilitas' => 'Kasur, Lemari, WiFi, Dapur Bersama'
            ],
            [
            
                'pemilik_nama' => 'Ko Hendra Wijaya',
                'pemilik_email' => 'hendra.wijaya@gmail.com',
            
                'kos_nama' => 'Residence 88 Eksekutif',
                'kota' => 'Jakarta Selatan',
                'alamat' => 'Jl. Cilandak KKO',
                'deskripsi' => 'Hunian mewah rasa hotel. Kolam renang & Gym.',
                'harga' => 4500000,
                'fasilitas' => 'AC, Water Heater, Smart TV, Bed King Size'
            ],
            [
              
                'pemilik_nama' => 'Mas Andi Investor',
                'pemilik_email' => 'andi.invest@gmail.com',
             
                'kos_nama' => 'Apartemen Mahasiswa UI',
                'kota' => 'Depok',
                'alamat' => 'Margonda Raya',
                'deskripsi' => 'Sangat dekat kampus UI, akses stasiun mudah.',
                'harga' => 2500000,
                'fasilitas' => 'Full Furnished, AC, Study Desk'
            ],
            [
        
                'pemilik_nama' => 'Teh Rina Bandung',
                'pemilik_email' => 'rina.bdg@gmail.com',
             
                'kos_nama' => 'Green House Dago',
                'kota' => 'Bandung',
                'alamat' => 'Dago Atas No. 12',
                'deskripsi' => 'Udara sejuk, view bagus, bangunan estetik.',
                'harga' => 1500000,
                'fasilitas' => 'Air Hangat, Balkon Pribadi, WiFi'
            ],
            [
             
                'pemilik_nama' => 'Pak RT Slamet',
                'pemilik_email' => 'pakrt.slamet@gmail.com',
                
                'kos_nama' => 'Kos Pak RT Rungkut',
                'kota' => 'Surabaya',
                'alamat' => 'Rungkut Madya',
                'deskripsi' => 'Kos aman dipantau Pak RT langsung. Bebas banjir.',
                'harga' => 900000,
                'fasilitas' => 'Kipas Angin, Kasur, Lemari'
            ],
            [
             
                'pemilik_nama' => 'Bli Wayan Sugawa',
                'pemilik_email' => 'wayan.bali@gmail.com',
              
                'kos_nama' => 'Kos Backpacker Kuta',
                'kota' => 'Bali',
                'alamat' => 'Poppies Lane II',
                'deskripsi' => 'Cocok untuk surfer dan traveler. Suasana santai.',
                'harga' => 950000,
                'fasilitas' => 'Bunk Bed, Loker, WiFi, Ruang Santai'
            ],
            [
               
                'pemilik_nama' => 'Mba Sarah Desainer',
                'pemilik_email' => 'sarah.design@gmail.com',
            
                'kos_nama' => 'Loft Industrial Tebet',
                'kota' => 'Jakarta Selatan',
                'alamat' => 'Tebet Timur',
                'deskripsi' => 'Desain industrial kekinian. Instagramable banget.',
                'harga' => 2100000,
                'fasilitas' => 'AC, Mezzanine Bed, Netflix'
            ],
            [
               
                'pemilik_nama' => 'Pak Dedi Malang',
                'pemilik_email' => 'dedi.malang@gmail.com',
              
                'kos_nama' => 'Griya Brawijaya',
                'kota' => 'Malang',
                'alamat' => 'Jl. Soekarno Hatta',
                'deskripsi' => 'Dekat UB dan Polinema. Strategis banyak makanan.',
                'harga' => 950000,
                'fasilitas' => 'Kamar Mandi Dalam, WiFi, Parkir Motor'
            ],
            [
               
                'pemilik_nama' => 'Bu Hj. Fatimah',
                'pemilik_email' => 'fatimah.solo@gmail.com',
              
                'kos_nama' => 'Omah Jowo Guest House',
                'kota' => 'Solo',
                'alamat' => 'Laweyan',
                'deskripsi' => 'Suasana tenang seperti rumah sendiri. Termasuk sarapan.',
                'harga' => 1200000,
                'fasilitas' => 'AC, TV, Sarapan Pagi'
            ]
        ];

        
        foreach ($dataLengkap as $index => $item) {
            
            $pemilikBaru = User::create([
                'name' => $item['pemilik_nama'],
                'email' => $item['pemilik_email'],
                'password' => bcrypt('password'), 
                'role' => 'owner',
                'no_hp' => '0812' . rand(1000000, 9999999)
            ]);

            $kosBaru = BoardingHouse::create([
                'nama_kos' => $item['kos_nama'],
                'slug' => Str::slug($item['kos_nama']),
                'user_id' => $pemilikBaru->id, 
                'deskripsi' => $item['deskripsi'],
                'alamat' => $item['alamat'] . ', ' . $item['kota'],
                'foto_utama' => 'img/kamar/kos-' . ($index + 1) . '.jpg',
                'status' => 'approved'
            ]);

            Room::create([
                'boarding_house_id' => $kosBaru->id,
                'nama_kamar' => 'Tipe Standar',
                'harga_per_bulan' => $item['harga'],
                'fasilitas' => $item['fasilitas'],
                'stok_kamar' => rand(1, 5)
            ]);
        }
    }
}