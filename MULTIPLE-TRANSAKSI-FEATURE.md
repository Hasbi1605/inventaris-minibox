# Fitur Multiple Transaksi

## Deskripsi

Fitur ini memungkinkan pengguna untuk membuat beberapa transaksi sekaligus dengan data yang sama dalam satu kali submit form. Hal ini sangat berguna untuk kasus seperti membuat banyak transaksi dengan kapster yang sama, cabang yang sama, dan metode pembayaran yang sama.

## Cara Penggunaan

### 1. Akses Form Tambah Transaksi

-   Pergi ke menu "Kelola Transaksi" → "Tambah Transaksi"

### 2. Isi Data Transaksi

-   **Cabang**: Pilih cabang (contoh: Minibox Balong)
-   **Layanan**: Pilih layanan yang akan dilakukan
-   **Kapster**: Pilih kapster (contoh: Arif)
-   **Produk Tambahan**: Tambahkan produk jika diperlukan (opsional)
-   **Metode Pembayaran**: Pilih metode pembayaran (contoh: QRIS)
-   **Status**: Pilih status transaksi
-   **Tanggal Transaksi**: Pilih tanggal
-   **Jumlah Transaksi**: Masukkan jumlah transaksi yang ingin dibuat (1-50)

### 3. Preview dan Konfirmasi

-   Sistem akan menampilkan preview jumlah transaksi yang akan dibuat
-   Tombol submit akan menampilkan jumlah transaksi yang akan dibuat

### 4. Submit Form

-   Klik tombol "Simpan X Transaksi" (X adalah jumlah yang dipilih)
-   Sistem akan membuat X transaksi dengan data yang sama
-   Setiap transaksi akan memiliki nomor transaksi yang unik

## Contoh Penggunaan

### Skenario: Membuat 5 Transaksi Arif di Balong dengan QRIS

1. Pilih Cabang: Minibox Balong
2. Pilih Layanan: Potong Rambut
3. Pilih Kapster: Arif
4. Pilih Metode Pembayaran: QRIS
5. Pilih Status: Selesai
6. Isi Tanggal: Hari ini
7. Isi Jumlah Transaksi: 5
8. Klik "Simpan 5 Transaksi"

Hasil: Sistem akan membuat 5 transaksi terpisah dengan nomor transaksi berbeda, namun semua dengan data yang sama.

## Batasan

-   Maksimal 50 transaksi per submit
-   Minimal 1 transaksi
-   Semua transaksi akan memiliki data yang identik kecuali nomor transaksi

## Error Handling

-   Jika salah satu transaksi gagal (misalnya stok produk habis), sistem akan melanjutkan membuat transaksi lainnya
-   Sistem akan memberikan laporan berapa transaksi yang berhasil dan yang gagal
-   Transaksi yang berhasil tetap tersimpan, yang gagal akan dilaporkan

## Keuntungan

-   Menghemat waktu untuk input transaksi berulang
-   Mengurangi kesalahan input data
-   Ideal untuk transaksi bulk dengan pola yang sama
