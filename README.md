# ExploreLocal — Website Wisata + Dashboard Admin (Laravel)

Website pariwisata lokal Indonesia dengan **backoffice dashboard admin** untuk mengelola destinasi wisata.

## Tema & fungsi dashboard admin

Karena tema websitenya **pariwisata**, dashboard admin berisi menu untuk mengelola konten wisata:

| Menu admin | Fungsi |
|---|---|
| Dashboard | Ringkasan (total destinasi, wisatawan, ulasan, kategori), grafik aktivitas 14 hari, grafik destinasi per kategori, destinasi terpopuler, ulasan terbaru |
| Destinasi Wisata | **Tambah / edit / hapus** destinasi: nama, kategori, lokasi, deskripsi, harga tiket, jam buka, fasilitas, koordinat peta, **upload foto** (atau link foto), tandai "unggulan" |
| Kategori | Tambah / edit / hapus kategori (pantai, gunung, dll) + pilih ikon |
| Wisatawan | Lihat & hapus akun wisatawan terdaftar |
| Ulasan | Moderasi ulasan pengunjung |

## Fitur sisi wisatawan
- Beranda (hero + pencarian, kategori, destinasi unggulan & terbaru)
- Daftar destinasi dengan filter kategori, pencarian, dan urutan (terbaru/populer/rating/termurah)
- Detail destinasi: foto, deskripsi, fasilitas, peta Google Maps, harga & jam buka, ulasan
- **Daftar, Login, Logout** wisatawan
- Simpan destinasi ke **Favorit**, tulis **ulasan & rating**, edit **profil**

## Login admin
- Halaman: `/admin/login` (atau link "Login Admin" di footer)
- Admin yang login (dari halaman mana pun) **langsung diarahkan ke dashboard admin**
- Akun admin demo: `admin@explorelocal.test` / `admin123`
- Akun wisatawan demo: `budi@example.com` / `password`

## Cara menjalankan

Kebutuhan: **PHP 8.2+** (ekstensi `pdo_sqlite`, `mbstring`, `openssl`, `fileinfo`), **Composer**, dan internet (untuk unduh Laravel + CDN Bootstrap/Font Awesome/Chart.js).

1. Ekstrak zip ini.
2. **Windows**: klik dua kali `setup.bat` — **Mac/Linux**: jalankan `./setup.sh`
3. Tunggu sampai muncul tulisan SELESAI, lalu buka http://127.0.0.1:8000

Skrip akan: mengunduh kerangka Laravel resmi → menyalin kode ExploreLocal → membuat database SQLite → mengisi data contoh (12 destinasi + foto) → menjalankan server.

Menjalankan lagi di lain waktu: `jalankan-lagi.bat` atau masuk ke folder `explorelocal-app` lalu `php artisan serve`.

### Pakai MySQL (opsional)
Buat database kosong, lalu di `explorelocal-app/.env` ubah:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=explorelocal
DB_USERNAME=root
DB_PASSWORD=
```
kemudian jalankan `php artisan migrate:fresh --seed`.

## Foto destinasi
Data contoh memakai foto dari picsum.photos (butuh internet; fotonya acak, bukan foto asli tempatnya). Ganti dengan foto asli lewat **Admin → Destinasi Wisata → Edit → Upload foto**. Foto upload disimpan di `storage/app/public/destinations`.

## Struktur kode (folder `source/`)
```
app/Http/Controllers/        Home, Destination, Review, Favorite, Profile, Auth
app/Http/Controllers/Admin/  Dashboard, Destination, Category, User, Review
app/Http/Middleware/AdminMiddleware.php   (hanya role "admin" boleh masuk /admin)
app/Models/                  User, Category, Destination, Review
database/migrations/         tabel users(+role), categories, destinations, reviews, favorites
database/seeders/            data contoh (admin, wisatawan, kategori, destinasi, ulasan)
resources/views/             layouts, halaman publik, auth, dan admin/*
routes/web.php               semua rute
public/css, public/js        gaya & skrip
```

Catatan: data destinasi pada seeder (harga tiket, jam buka, koordinat) adalah **data contoh** dan perlu disesuaikan sebelum dipakai sungguhan.
# ExploreLocal
>>>>>>> 62427e106093d0a71bf53740fc59cf37b80b7522
