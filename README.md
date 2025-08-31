Sistem Posyandu Lansia — PHP MVC Mini App

Ringkasan: Aplikasi sederhana berbasis PHP (pola MVC) dan MySQL untuk pendaftaran lansia, pencarian via ID Unik, pencatatan pemeriksaan fisik/kesehatan, dan tampilan profil + riwayat. UI menggunakan TailwindCSS via CDN, tanpa dependensi tambahan.

Fitur Utama
- Pendaftaran lansia dengan validasi server dan client.
- ID Unik otomatis: format `pasienYYYYMMDDXX` (contoh: `pasien20250101AB`).
- Halaman profil lansia dengan salin ID, serta riwayat pemeriksaan terbaru.
- Form pemeriksaan fisik (tinggi, berat, sistolik, diastolik) dengan kalkulasi BMI + kategori.
- Form pemeriksaan kesehatan (asam urat, gula darah + tipe, kolesterol total) beserta klasifikasi otomatis.
- Pencarian cepat berdasarkan ID Unik.
- Router ringan dan tampilan terpisah per halaman.

Persyaratan
- PHP 8.1+ (disarankan 8.2).
- MySQL 8+ (atau kompatibel), akses user/DB sudah tersedia.
- Tidak perlu Composer; Tailwind diambil via CDN.

Langkah Instalasi
1) Salin `.env.example` menjadi `.env` dan sesuaikan nilai berikut:
   - `DB_HOST`, `DB_PORT`, `DB_NAME`, `DB_USER`, `DB_PASS`
   - `APP_URL` (mis. `http://localhost:8000`), `TIMEZONE`
2) Buat database sesuai `DB_NAME`.
3) Import skema `database/posyandu.sql` ke database tersebut (berisi seluruh tabel dan enum yang dipakai aplikasi).
4) Jalankan server dev PHP: `php -S localhost:8000 -t public` lalu buka `http://localhost:8000`.

Rute Aplikasi (ringkas)
- GET `/`           → Beranda.
- GET `/lansia`     → Daftar lansia (paginasi + pencarian).
- GET `/lansia/create` → Form pendaftaran.
- POST `/lansia`    → Simpan pendaftaran (buat ID Unik).
- GET `/lansia/{id_unik}` → Profil lansia + riwayat pemeriksaan.
- GET `/lansia/{id_unik}/pemeriksaan` → Form pemeriksaan gabungan.
- POST `/lansia/{id_unik}/pemeriksaan` → Simpan pemeriksaan (gabungan).
- POST `/lansia/{id_unik}/pemeriksaan/fisik` → Simpan bagian fisik saja.
- POST `/lansia/{id_unik}/pemeriksaan/kesehatan` → Simpan bagian kesehatan saja.
- GET `/find` dan POST `/find` → Cari profil berdasarkan ID Unik.

Format ID Unik
- Pola: `pasien` + `YYYYMMDD` + 2 karakter Base62 (total 16 karakter).
- Implementasi generator: `app/Core/Str.php:18` (`patientId()`).
- Dipakai saat pendaftaran: `app/Controllers/LansiaController.php:75`.
- Unik per-row; jika tabrakan (sangat jarang), generator akan mengulang.

Struktur Proyek
- `public/` front controller (`public/index.php`) dan `.htaccess`.
- `app/Core/` util inti: `Router`, `Controller`, `View`, `Database`, `Env`, `Str`.
- `app/Controllers/` controller halaman (Home, Lansia, Pemeriksaan, Find).
- `app/Models/` akses data dengan PDO (prepared statements, tanpa ORM).
- `app/Views/` template PHP dengan Tailwind via CDN.
- `config/` bootstrap konfigurasi (`config/config.php`).
- `database/posyandu.sql` skema database siap impor.

Keamanan & Praktik Baik
- PDO dengan prepared statements (`app/Core/Database.php`).
- Validasi di server (PHP) dan umpan balik real‑time di klien (JS) pada form.
- Set `TIMEZONE` dan `APP_URL` sesuai lingkungan. Gunakan HTTPS di produksi dan aktifkan cookie yang aman.

Pengembangan
- Jalankan server dev: `php -S localhost:8000 -t public`.
- Ubah ambang/kategori pemeriksaan di controller:
  - Tekanan darah & BMI: `app/Controllers/PemeriksaanController.php`.
  - Gula darah, kolesterol, asam urat: file yang sama (bagian `storeKesehatan`/`store`).
- Ubah format ID jika dibutuhkan di `app/Core/Str.php`.

Catatan
- Aplikasi tidak memakai QR/Barcode; seluruh navigasi berbasis ID Unik.
- Jika men-deploy di server web (Nginx/Apache), arahkan docroot ke folder `public/`.
