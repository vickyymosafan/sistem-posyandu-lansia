Sistem Posyandu Lansia - PHP MVC Skeleton

Ringkas: Kerangka awal aplikasi sesuai SRS (R1-R6) menggunakan PHP (MVC), MySQL (PDO), dan TailwindCSS. Identifikasi lansia memakai ID Unik (tanpa QR/Barcode).

Fitur yang tersedia (awal):
- Routing dasar (Front Controller + Router sederhana)
- Halaman pendaftaran lansia (form + validasi client/server)
- Simpan data ke MySQL (PDO) dan hasilkan ID Unik (`id_unik`)
- Halaman profil menampilkan ID Unik (bisa disalin)
- Halaman cari ID Unik

Persiapan lingkungan:
1) Salin `.env.example` menjadi `.env` lalu isi kredensial DB Anda.
2) Buat database MySQL sesuai `.env`.
3) Jalankan migrasi SQL berurutan: import `database/migrations/001_init.sql`, `002_add_lipid_profile.sql`, `003_add_gula_tipe.sql`, `004_add_gula_kategori.sql`, dan `005_drop_lipid_details.sql` (menghapus LDL/HDL/Trigliserida).
4) Tidak perlu library QR. Sistem menggunakan ID Unik saja.

Menjalankan aplikasi (contoh):
- Dev server built-in PHP: `php -S localhost:8000 -t public` (pastikan `public/` sebagai docroot).

Struktur folder:
- `public/` Front controller, asset JS/CSS, .htaccess
- `app/Core/` Router, Controller, View, Database, Helpers
- `app/Controllers/` Controller aplikasi
- `app/Models/` Model PDO
- `app/Views/` Template PHP (Tailwind via CDN)
- `config/` Konfigurasi
- `database/migrations/` DDL SQL

Catatan keamanan & praktik baik:
- Gunakan session aman (`cookie_httponly`, `secure` jika HTTPS), CSRF token untuk form sensitif.
- Semua query menggunakan prepared statements (lihat `app/Core/Database.php`).
- Validasi ganda: client-side (JS) dan server-side (PHP) agar konsisten.

Roadmap next:
- Form pemeriksaan fisik & kesehatan + validasi range
- (Opsional) Riwayat dan tren visual dapat ditambahkan kemudian
- Autentikasi petugas/admin
- Peningkatan aksesibilitas & haptic feedback
