# Fix Harga Layanan Per Cabang di Transaksi

## Masalah Utama

1. **Harga Layanan**: Ketika membuat transaksi, sistem masih menampilkan dan menggunakan harga base layanan, bukan harga per cabang yang sudah dikonfigurasi.

2. **Nomor Transaksi Duplicate**: Error "Duplicate entry 'TRX20251000008'" karena fungsi generate nomor transaksi menggunakan `count()` semua transaksi, bukan per bulan.

## Solusi yang Diterapkan

### 1. **TransaksiService.php**

-   Menambahkan method baru `getAvailableLayananForCabang($cabangId)` yang:
    -   Mengambil layanan berdasarkan cabang yang dipilih
    -   Menghitung harga per cabang (harga_cabang) dari tabel pivot `cabang_layanan`
    -   Jika tidak ada harga khusus untuk cabang, menggunakan harga base sebagai fallback
    -   Filter hanya layanan yang aktif di cabang tersebut

### 2. **KelolaTransaksiController.php**

-   **Method `create()`**: Mengubah dari `getAvailableLayanan()` ke `getAvailableLayananForCabang($cabangId)`
-   **Method `edit()`**: Mengubah dari `getAvailableLayanan()` ke `getAvailableLayananForCabang($transaksi->cabang_id)`

### 3. **View create.blade.php & edit.blade.php**

-   Mengubah tampilan dropdown layanan untuk menggunakan `harga_cabang` alih-alih `harga`
-   Menambahkan logic PHP untuk format harga:

```blade
@php
    $hargaToShow = isset($service->harga_cabang) ? $service->harga_cabang : $service->harga;
    $formattedHarga = 'Rp ' . number_format($hargaToShow, 0, ',', '.');
@endphp
<option value="{{ $service->id }}" data-harga="{{ $hargaToShow }}">
    {{ $service->nama_layanan }} - {{ $formattedHarga }}
</option>
```

### 4. **Transaksi.php (Model)** - Fix Generate Nomor Transaksi

**Masalah Lama:**

```php
$count = self::count();  // Hitung SEMUA transaksi
$nextNumber = $count + 1;
```

**Solusi Baru:**

```php
// Cari nomor transaksi terakhir untuk bulan ini
$lastTransaction = self::where('nomor_transaksi', 'like', $prefix . '%')
    ->orderBy('nomor_transaksi', 'desc')
    ->first();

if ($lastTransaction) {
    $lastNumber = (int) substr($lastTransaction->nomor_transaksi, -5);
    $nextNumber = $lastNumber + 1;
} else {
    $nextNumber = 1;
}
```

**Penjelasan:**

-   Sekarang mencari nomor transaksi terakhir **untuk bulan yang sama** (menggunakan `LIKE TRX202510%`)
-   Mengambil 5 digit terakhir dari nomor transaksi tersebut
-   Menambahkan 1 untuk mendapatkan nomor berikutnya
-   Jika belum ada transaksi di bulan ini, mulai dari 1

## Cara Kerja

1. **User memilih cabang** → Halaman reload dengan parameter `cabang_id`
2. **Controller** → Memanggil `getAvailableLayananForCabang($cabangId)`
3. **Service** → Mengambil layanan dengan harga spesifik cabang dari tabel `cabang_layanan`
4. **View** → Menampilkan layanan dengan harga per cabang
5. **JavaScript** → Menggunakan `data-harga` (yang sudah berisi harga per cabang) untuk kalkulasi total
6. **Generate Nomor** → Sistem mengambil nomor terakhir bulan ini dan increment

## Testing

### Sebelum Fix:

-   ❌ Pilih cabang Minibox Balong → Layanan menampilkan Rp 0 (harga base)
-   ❌ Total transaksi menggunakan harga base
-   ❌ Error duplicate nomor transaksi

### Setelah Fix:

-   ✅ Pilih cabang Minibox Balong → Layanan menampilkan Rp 45.000 (harga per cabang)
-   ✅ Pilih cabang Minibox Krajen → Layanan menampilkan Rp 44.000 (harga per cabang)
-   ✅ Total transaksi menggunakan harga sesuai cabang
-   ✅ Nomor transaksi generate dengan benar per bulan

## File yang Dimodifikasi

1. `app/Services/TransaksiService.php` - Tambah method `getAvailableLayananForCabang()`
2. `app/Http/Controllers/KelolaTransaksiController.php` - Update method `create()` dan `edit()`
3. `resources/views/pages/kelola-transaksi/create.blade.php` - Update dropdown layanan
4. `resources/views/pages/kelola-transaksi/edit.blade.php` - Update dropdown layanan
5. `app/Models/Transaksi.php` - Fix method `generateNomorTransaksi()` untuk mencegah duplicate

## Error yang Diperbaiki

### Error Log:

```
SQLSTATE[23000]: Integrity constraint violation: 1062 Duplicate entry 'TRX20251000008'
for key 'transaksis_nomor_transaksi_unique'
```

### Root Cause:

Fungsi `generateNomorTransaksi()` menggunakan total count transaksi, tidak per bulan.

### Solution:

Query nomor transaksi terakhir berdasarkan prefix bulan yang sama.

## Catatan

-   Jika belum ada konfigurasi harga per cabang, sistem akan fallback ke harga base
-   Hanya layanan yang aktif di cabang yang akan ditampilkan
-   JavaScript kalkulasi total sudah otomatis menggunakan harga yang benar karena mengambil dari attribute `data-harga`
-   Nomor transaksi sekarang di-generate per bulan, mencegah duplicate entry
