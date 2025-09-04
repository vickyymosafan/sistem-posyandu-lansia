Sistem Posyandu Lansia — PHP MVC Mini App

Ringkasan: Aplikasi PHP (pola MVC) + MySQL untuk pendaftaran lansia, pencarian via ID Unik, pencatatan pemeriksaan fisik/kesehatan, autentikasi admin/petugas, serta halaman profil pengguna. UI memakai TailwindCSS via CDN, tanpa Composer/Node.

Fitur Utama
- Autentikasi: login, logout, proteksi rute; admin/petugas (role).
- Manajemen Petugas (admin-only): tambah petugas aktif/non-aktif.
- Pendaftaran lansia dengan validasi server-side (NIK/KK 16 digit, dsb.).
- ID Unik otomatis (base62) untuk setiap lansia; pencarian cepat.
- Pemeriksaan fisik (tinggi, berat, sistolik, diastolik) + hitung BMI dan kategori.
- Pemeriksaan kesehatan (asam urat, gula darah: puasa/sewaktu/2jpp, kolesterol total) + klasifikasi.
- Halaman profil lansia dan riwayat pemeriksaan terbaru.
- Halaman profil pengguna: ubah nama dan kata sandi.

Persyaratan
- PHP 8.1+ (disarankan 8.2+), ekstensi PDO MySQL aktif.
- MySQL 8+ (atau kompatibel) dengan akses user/DB.
- Tidak perlu Composer/Node; Tailwind via CDN.

Instalasi & Migrasi
1) Salin `.env.example` menjadi `.env`, lalu atur minimal:
   - `DB_HOST`, `DB_PORT`, `DB_NAME`, `DB_USER`, `DB_PASS`
   - `APP_URL` (mis. `http://localhost:8000`), `TIMEZONE` (mis. `Asia/Jakarta`)
   - Opsional seeding admin: `ADMIN_NAME` (default `admin`), `ADMIN_PASS` (kosong = akan dibuat otomatis)
2) Buat database sesuai `DB_NAME`.
3) Jalankan migrasi + seeder admin:
   - Perintah dasar: `php bin/migrate.php`
   - Opsi CLI yang tersedia:
     - `--skip-sql`        : lewati eksekusi file `database/posyandu.sql` (berguna jika sudah diimpor manual)
     - `--admin=NamaAdmin` : override nama admin (jika tidak diisi, pakai `ADMIN_NAME` dari `.env` atau `admin`)
     - `--password=Rahasia`: set kata sandi admin (jika kosong, akan dibuat acak dan dicetak di terminal)
   - Apa yang dilakukan skrip:
     - Mengimpor `database/posyandu.sql` secara idempoten (mengabaikan objek yang sudah ada).
     - Memastikan kolom `lansia.nik` dan `lansia.kk` tersedia serta indeks unik `uniq_lansia_nik`.
     - Membuat admin jika belum ada sesuai `--admin`/`.env`; tidak menimpa akun yang sudah ada.
   - Contoh:
     - `php bin/migrate.php`
     - `php bin/migrate.php --admin=adminpos --password=SuperRahasia123!`
     - `php bin/migrate.php --skip-sql`
4) Jalankan server dev: `php -S localhost:8000 -t public` lalu buka `http://localhost:8000`.
5) Masuk melalui `/login` menggunakan kredensial admin. Jika kata sandi dibuat otomatis, lihat output terminal dari perintah migrasi.

Catatan Basis Data
- `database/posyandu.sql` berisi skema dan contoh data (termasuk tabel `users`).
- Menjalankan `bin/migrate.php` aman diulang (idempoten) dan tidak akan menimpa data admin yang sudah ada.
- Untuk mengatur ulang kata sandi admin yang sudah ada, login lalu ubah lewat `/profil/edit` atau perbarui langsung di DB.

Rute Penting (ringkas)
- GET `/login`, POST `/login`, POST `/logout` (halaman autentikasi publik).
- GET `/` (beranda, butuh login).
- GET `/lansia` (daftar), GET `/lansia/create` (form), POST `/lansia` (simpan),
  GET `/lansia/{kode}` (profil + riwayat),
  GET `/lansia/{kode}/pemeriksaan` (form),
  POST `/lansia/{kode}/pemeriksaan` (simpan gabungan),
  POST `/lansia/{kode}/pemeriksaan/fisik`,
  POST `/lansia/{kode}/pemeriksaan/kesehatan`.
- GET `/find`, POST `/find` (cari berdasarkan ID Unik).
- GET `/petugas/create`, POST `/petugas` (tambah petugas, admin-only).
- GET `/profil`, GET `/profil/edit`, POST `/profil/nama`, POST `/profil/password`.

Format ID Unik Lansia
- Pola: `pasien` + `YYYYMMDD` + 2 karakter base62 (total 16).
- Generator: `app/Core/Str.php` fungsi `patientId()`.

Variabel Lingkungan (dipakai kode)
- `DB_HOST`, `DB_PORT`, `DB_NAME`, `DB_USER`, `DB_PASS`.
- `APP_URL` (tanpa trailing slash), `TIMEZONE`.
- Opsional: `ADMIN_NAME`, `ADMIN_PASS` untuk `bin/migrate.php`.

Struktur Proyek
- `public/` front controller (`public/index.php`) dan `.htaccess` untuk rewrite.
- `app/Core/` util inti: `Router`, `Controller`, `View`, `Database`, `Env`, `Str`.
- `app/Controllers/` controller (Auth, Home, Lansia, Pemeriksaan, Find, Petugas, Profile).
- `app/Models/` akses data dengan PDO (tanpa ORM).
- `app/Validation/` validator sederhana untuk form.
- `app/Views/` template PHP + Tailwind via CDN.
- `config/config.php` bootstrap konfigurasi.
- `database/posyandu.sql` skema dan seed contoh.
- `bin/migrate.php` migrasi SQL + seeder admin.

Keamanan & Praktik Baik
- PDO dengan `ERRMODE_EXCEPTION`, prepared statements.
- Hardening sesi: `HttpOnly`, `SameSite=Strict`, `Secure` saat HTTPS, regenerasi ID.
- CSRF token pada form penting; validasi server-side menyeluruh.
- Gunakan HTTPS di produksi dan arahkan docroot ke `public/`.

Pengembangan
- Jalankan: `php -S localhost:8000 -t public`.
- Ubah ambang/kategori pemeriksaan di `app/Controllers/PemeriksaanController.php`.
- Ubah format ID di `app/Core/Str.php` bila diperlukan.

Deploy
- Nginx/Apache: arahkan root ke folder `public/` dan pastikan PHP-FPM/handler terpasang.
