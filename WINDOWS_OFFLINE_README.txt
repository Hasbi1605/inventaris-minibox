Panduan manual (Windows) — tanpa otomatisasi

Ikuti langkah-langkah ini di mesin Windows target. Skrip otomatisasi telah dihapus; semua langkah dilakukan secara manual agar mudah dipahami.

Persyaratan sebelum mulai
- PHP 8.2+ (bisa portable di folder portable-php\php.exe atau terpasang di PATH sebagai php.exe)
- File paket telah diekstrak lengkap (folder portable-php\ jika disertakan)

Langkah 1 — Buka Command Prompt
1. Buka Start -> ketik "cmd" -> Enter (atau klik kanan Run as administrator bila diperlukan).
2. Pindah ke folder aplikasi hasil ekstrak, contoh:

```cmd
cd C:\path\ke\inventaris
```

Langkah 2 — Periksa PHP dan ekstensi SQLite
1. Jika paket menyertakan portable PHP, jalankan:

```cmd
portable-php\php.exe -v
portable-php\php.exe -m
portable-php\php.exe -r "print_r(PDO::getAvailableDrivers());"
```

2. Jika tidak ada portable PHP, periksa PHP di PATH:

```cmd
php -v
php -m
php -r "print_r(PDO::getAvailableDrivers());"
```

Cari "sqlite" atau "pdo_sqlite" di daftar modul / driver. Jika tidak muncul, aktifkan ekstensi `sqlite3` dan `pdo_sqlite` pada file `php.ini` (lihat bagian Troubleshooting).

Langkah 3 — Siapkan file environment dan database
1. Jika belum ada `.env`, buat salinan dari `.env.example`:

```cmd
copy .env.example .env
```

2. Pastikan `.env` berisi pengaturan untuk SQLite (jika Anda ingin memakai SQLite):

Edit `.env` (Notepad) lalu set:

DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite

3. Buat file database sqlite jika belum ada:

```cmd
if not exist database\database.sqlite type nul > database\database.sqlite
```

Langkah 4 — Generate APP_KEY (jika kosong)
1. Cek apakah `.env` memiliki APP_KEY; bila kosong, jalankan:

```cmd
php artisan key:generate
```

Gunakan `portable-php\php.exe` jika Anda memakai PHP portable:

```cmd
portable-php\php.exe artisan key:generate
```

Langkah 5 — Jalankan server (manual)
Jalankan perintah berikut untuk memulai server pengembangan:

```cmd
php artisan serve --host=127.0.0.1 --port=8000
```

atau jika menggunakan portable PHP:

```cmd
portable-php\php.exe artisan serve --host=127.0.0.1 --port=8000
```

Buka browser ke: http://127.0.0.1:8000

Troubleshooting singkat
- Jika perintah `php` tidak ditemukan: pasang PHP 8.2+ atau gunakan `portable-php\php.exe` jika disertakan.
- Jika `pdo_sqlite` tidak terlihat di `php -m` atau PDO drivers:
  - Buka `php.ini` (lokasi php.ini tergantung pada build PHP) dan pastikan baris berikut tidak dikomentari (hilangkan tanda titik koma `;` di awal):
    - extension=sqlite3
    - extension=pdo_sqlite
  - Simpan perubahan, kemudian jalankan ulang perintah `php -m` untuk verifikasi.
- Jika `php artisan` gagal karena dependensi: jalankan `composer install` di folder project (ini hanya perlu jika vendor belum termasuk):

```cmd
composer install --no-dev --optimize-autoloader
```

Jika Anda ingin saya menulis ulang script launcher menjadi lebih sederhana atau menambahkan checklist otomatis yang hanya menampilkan instruksi (tanpa mengubah file di sistem klien), beri tahu saya. Saya bisa juga membuat file `CHECKLIST.txt` singkat untuk klien.

