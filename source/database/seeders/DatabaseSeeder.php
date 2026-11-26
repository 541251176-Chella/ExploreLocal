<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Destination;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Model::unguard();

        /* ---------- AKUN ---------- */
        User::create([
            'name' => 'Admin ExploreLocal',
            'email' => 'admin@explorelocal.test',
            'password' => 'admin123',
            'role' => 'admin',
        ]);

        $tourists = collect([
            ['Budi Santoso', 'budi@example.com'],
            ['Siti Rahma', 'siti@example.com'],
            ['Andi Pratama', 'andi@example.com'],
            ['Dewi Lestari', 'dewi@example.com'],
            ['Rizky Ramadhan', 'rizky@example.com'],
            ['Putri Anggraini', 'putri@example.com'],
        ])->map(fn ($u) => User::create([
            'name' => $u[0],
            'email' => $u[1],
            'password' => 'password',
            'role' => 'tourist',
            'created_at' => now()->subDays(rand(0, 13))->subMinutes(rand(0, 600)),
        ]));

        /* ---------- KATEGORI ---------- */
        $cats = collect([
            ['Pantai & Pulau', 'fa-umbrella-beach'],
            ['Gunung & Alam', 'fa-mountain'],
            ['Budaya & Sejarah', 'fa-landmark'],
            ['Air Terjun & Danau', 'fa-water'],
            ['Wisata Keluarga', 'fa-ticket'],
            ['Kuliner & Pasar', 'fa-utensils'],
        ])->mapWithKeys(fn ($c) => [
            $c[0] => Category::create(['name' => $c[0], 'slug' => Str::slug($c[0]), 'icon' => $c[1]]),
        ]);

        /* ---------- DESTINASI (data contoh) ---------- */
        $items = [
            ['Candi Borobudur', 'Budaya & Sejarah', 'Magelang', 'Jawa Tengah', 50000, '06.30 - 17.00 WIB', -7.6079, 110.2038, true,
                'Candi Buddha terbesar di dunia dari abad ke-9 ini memiliki ribuan relief dan ratusan stupa. Waktu terbaik berkunjung adalah saat matahari terbit, ketika kabut tipis menyelimuti perbukitan di sekelilingnya.',
                "Area parkir luas\nToilet\nMusala\nPemandu wisata\nToko suvenir"],
            ['Gunung Bromo', 'Gunung & Alam', 'Probolinggo', 'Jawa Timur', 35000, 'Buka 24 jam (sunrise 03.00 - 08.00)', -7.9425, 112.9530, true,
                'Lautan pasir, kawah yang mengepul, dan sunrise dari Penanjakan menjadikan Bromo salah satu pemandangan paling ikonik di Indonesia. Tersedia jip dan kuda untuk menyeberangi lautan pasir.',
                "Sewa jip\nSewa kuda\nHomestay\nWarung makan\nToilet"],
            ['Raja Ampat', 'Pantai & Pulau', 'Raja Ampat', 'Papua Barat Daya', 500000, 'Setiap hari', -0.5000, 130.5000, true,
                'Surga bawah laut dengan ratusan gugusan pulau karst dan terumbu karang terkaya di dunia. Cocok untuk snorkeling, diving, dan menikmati panorama Wayag dari puncak bukit.',
                "Penyewaan alat snorkeling\nHomestay\nPemandu lokal\nKapal wisata"],
            ['Pulau Padar', 'Pantai & Pulau', 'Manggarai Barat', 'Nusa Tenggara Timur', 100000, '06.00 - 18.00 WITA', -8.6544, 119.5806, true,
                'Trekking singkat ke puncak Padar akan membayar lunas dengan pemandangan tiga teluk berpasir berwarna berbeda. Bagian dari Taman Nasional Komodo yang bisa dijangkau dari Labuan Bajo.',
                "Jalur trekking\nPemandu\nKapal dari Labuan Bajo"],
            ['Danau Toba', 'Air Terjun & Danau', 'Samosir', 'Sumatera Utara', 0, 'Setiap hari', 2.6869, 98.8754, true,
                'Danau vulkanik terbesar di Asia Tenggara dengan Pulau Samosir di tengahnya. Nikmati budaya Batak, desa Tomok, dan sunset di tepi danau yang tenang.',
                "Penginapan\nSewa kapal\nRumah makan\nToko ulos"],
            ['Malioboro', 'Budaya & Sejarah', 'Yogyakarta', 'DI Yogyakarta', 0, 'Setiap hari (ramai malam hari)', -7.7930, 110.3658, false,
                'Jantung wisata Yogyakarta: jalan pedestrian yang dipenuhi pedagang batik, kerajinan perak, dan angkringan. Berjalan kaki dari Tugu hingga Keraton adalah pengalaman khas Jogja.',
                "Pedestrian luas\nToilet umum\nAngkringan\nBecak & andong"],
            ['Kawah Ijen', 'Gunung & Alam', 'Banyuwangi', 'Jawa Timur', 75000, '01.00 - 12.00 WIB', -8.0583, 114.2422, false,
                'Terkenal dengan api biru (blue fire) yang hanya muncul menjelang subuh dan danau kawah berwarna toska. Pendakian sekitar 2-3 jam dari Paltuding, siapkan masker gas dan pakaian hangat.',
                "Sewa masker gas\nPemandu\nWarung\nPos Paltuding"],
            ['Pantai Kelingking', 'Pantai & Pulau', 'Klungkung', 'Bali', 25000, '07.00 - 18.00 WITA', -8.7503, 115.4739, true,
                'Tebing berbentuk kepala T-Rex menghadap laut biru Nusa Penida. Spot foto paling populer di pulau ini, dengan jalur turun ke pantai bagi yang berani.',
                "Parkir\nWarung\nToilet\nSewa motor di sekitar"],
            ['Dataran Tinggi Dieng', 'Gunung & Alam', 'Wonosobo', 'Jawa Tengah', 20000, '06.00 - 18.00 WIB', -7.2095, 109.9099, false,
                'Negeri di atas awan dengan kompleks candi Hindu tertua di Jawa, telaga warna, dan kawah Sikidang. Cobalah mie ongklok dan carica sebagai oleh-oleh khas.',
                "Homestay\nWarung makan\nParkir\nToilet"],
            ['Curug Cipendok', 'Air Terjun & Danau', 'Banyumas', 'Jawa Tengah', 15000, '07.00 - 17.00 WIB', -7.3283, 109.1219, false,
                'Air terjun setinggi lebih dari 90 meter yang tersembunyi di lereng Gunung Slamet. Udaranya sejuk dan suasana hutannya masih sangat asri.',
                "Area parkir\nWarung\nMusala\nToilet"],
            ['Taman Mini Indonesia Indah', 'Wisata Keluarga', 'Jakarta Timur', 'DKI Jakarta', 20000, '07.00 - 22.00 WIB', -6.3024, 106.8951, false,
                'Miniatur budaya seluruh provinsi Indonesia dalam satu taman: anjungan rumah adat, museum, kereta gantung, dan wahana untuk anak-anak. Pas untuk liburan keluarga.',
                "Kereta gantung\nMuseum\nFood court\nPenyewaan sepeda"],
            ['Pasar Terapung Lok Baintan', 'Kuliner & Pasar', 'Banjar', 'Kalimantan Selatan', 0, '05.30 - 08.30 WITA', -3.3730, 114.6420, false,
                'Ibu-ibu berjukung menjual sayur, buah, dan kue tradisional di atas Sungai Martapura. Datang pagi-pagi dan coba soto Banjar langsung dari atas perahu.',
                "Sewa klotok\nPemandu lokal\nWarung apung"],
        ];

        $destinations = collect($items)->map(function ($i) use ($cats) {
            $slug = Str::slug($i[0]);

            return Destination::create([
                'category_id' => $cats[$i[1]]->id,
                'name' => $i[0],
                'slug' => $slug,
                'city' => $i[2],
                'province' => $i[3],
                'address' => $i[2] . ', ' . $i[3],
                'ticket_price' => $i[4],
                'open_hours' => $i[5],
                'latitude' => $i[6],
                'longitude' => $i[7],
                'is_featured' => $i[8],
                'description' => $i[9],
                'facilities' => $i[10],
                'image' => "https://picsum.photos/seed/{$slug}/900/600",
                'views' => rand(40, 900),
                'created_at' => now()->subDays(rand(0, 20)),
            ]);
        });

        /* ---------- ULASAN & FAVORIT CONTOH ---------- */
        $comments = [
            [5, 'Pemandangannya luar biasa, benar-benar worth it untuk dikunjungi!'],
            [5, 'Tempatnya bersih dan masyarakat sekitar ramah. Pasti balik lagi.'],
            [4, 'Bagus banget, cuma agak ramai saat akhir pekan. Datang pagi lebih nyaman.'],
            [4, 'Akses jalannya lumayan, tapi pemandangannya membayar semuanya.'],
            [5, 'Cocok untuk liburan bareng keluarga, anak-anak senang sekali.'],
            [3, 'Bagus, tapi fasilitas toilet masih perlu diperbaiki.'],
            [4, 'Harga tiket terjangkau dan spot fotonya banyak.'],
            [5, 'Salah satu tempat terbaik yang pernah saya kunjungi di Indonesia.'],
        ];

        foreach ($destinations as $destination) {
            foreach ($tourists->shuffle()->take(rand(2, 4)) as $tourist) {
                $c = $comments[array_rand($comments)];
                Review::create([
                    'user_id' => $tourist->id,
                    'destination_id' => $destination->id,
                    'rating' => $c[0],
                    'comment' => $c[1],
                    'created_at' => now()->subDays(rand(0, 13))->subMinutes(rand(0, 600)),
                ]);
            }
        }

        foreach ($tourists as $tourist) {
            $tourist->favorites()->attach($destinations->random(3)->pluck('id'));
        }

        Model::reguard();
    }
}
