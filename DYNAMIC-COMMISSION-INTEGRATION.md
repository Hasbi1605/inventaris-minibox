# Update: Dynamic Commission Rates Integration

## Overview

Sistem laporan gaji & komisi sekarang **otomatis menggunakan rate komisi individual** dari setiap kapster. Ketika Anda mengubah komisi di halaman **Kelola Kapster**, perubahan akan langsung terlihat di:

1. Tab Gaji & Komisi di halaman Laporan
2. PDF Slip Gaji

## Perubahan yang Dilakukan

### 1. **LaporanService.php** - Backend Integration

**File**: `app/Services/LaporanService.php`

**Perubahan**: Menambahkan data persentase komisi individual ke response

```php
// Persentase komisi individual kapster
'persen_komisi_potong_rambut' => $kapster->komisi_potong_rambut ?? 40,
'persen_komisi_layanan_lain' => $kapster->komisi_layanan_lain ?? 25,
'persen_komisi_produk' => $kapster->komisi_produk ?? 25,
```

**Impact**: Service sekarang mengirim persentase komisi aktual yang digunakan untuk perhitungan.

### 2. **Laporan View** - Dynamic Percentage Display

**File**: `resources/views/pages/laporan/partials/gaji-kapster.blade.php`

**Before**:

```blade
<p class="mb-0 text-xs text-slate-300">4x (40%)</p>
<p class="mb-0 text-xs text-slate-300">10x (25%)</p>
<p class="mb-0 text-xs text-slate-300">5x (25%)</p>
```

**After**:

```blade
<p class="mb-0 text-xs text-slate-300">{{ $item['jumlah_transaksi_potong_rambut'] }}x ({{ number_format($item['persen_komisi_potong_rambut'], 0) }}%)</p>
<p class="mb-0 text-xs text-slate-300">{{ $item['jumlah_transaksi_layanan_lain'] }}x ({{ number_format($item['persen_komisi_layanan_lain'], 0) }}%)</p>
<p class="mb-0 text-xs text-slate-300">{{ $item['jumlah_produk_terjual'] }}x ({{ number_format($item['persen_komisi_produk'], 0) }}%)</p>
```

**Impact**: Persentase ditampilkan sesuai dengan setting individual kapster.

### 3. **PDF Slip Gaji** - Dynamic Percentage Display

**File**: `resources/views/pages/laporan/pdf/slip-gaji.blade.php`

**Before**:

```blade
Komisi Potong Rambut (40%)
Komisi Layanan Lain (25%)
Komisi Produk (25%)
```

**After**:

```blade
Komisi Potong Rambut ({{ number_format($kapster['persen_komisi_potong_rambut'], 0) }}%)
Komisi Layanan Lain ({{ number_format($kapster['persen_komisi_layanan_lain'], 0) }}%)
Komisi Produk ({{ number_format($kapster['persen_komisi_produk'], 0) }}%)
```

**Impact**: PDF slip gaji menampilkan persentase komisi yang sebenarnya digunakan untuk perhitungan.

## How It Works - Full Flow

```
1. Admin Edit Komisi Kapster
   └─> Kelola Kapster > Edit > Ubah komisi (contoh: 50%, 30%, 30%)
       └─> KapsterController@update
           └─> Simpan ke database (tabel kapster)

2. View Laporan Gaji & Komisi
   └─> Laporan > Tab Gaji & Komisi
       └─> LaporanController@index
           └─> LaporanService->getLaporanGajiKapster()
               ├─> Load Kapster dengan komisi individual
               ├─> KomisiService->hitungKomisiKapster()
               │   └─> Menggunakan $kapster->komisi_* untuk perhitungan
               └─> Return data dengan persentase individual

3. Display di View
   └─> Tampilkan: "10x (50%)" bukan "10x (40%)"

4. Export PDF Slip Gaji
   └─> PDF juga menampilkan persentase yang sama: "Komisi Potong Rambut (50%)"
```

## Example Scenarios

### Scenario 1: Kapster dengan Rate Default

**Kapster**: Arif
**Komisi**: 40% / 25% / 25% (default)

**Laporan menampilkan**:

-   Komisi Potong Rambut: Rp 28.000 (4x **40%**)
-   Komisi Layanan Lain: Rp 0 (0x **25%**)
-   Komisi Produk: Rp 55.000 (3x **25%**)

**PDF Slip Gaji**:

-   Komisi Potong Rambut (**40%**): Rp 28.000
-   Komisi Layanan Lain (**25%**): Rp 0
-   Komisi Produk (**25%**): Rp 55.000

### Scenario 2: Senior Kapster dengan Rate Khusus

**Kapster**: Khusein (Senior)
**Komisi**: 50% / 30% / 30% (custom)

**Edit di Kelola Kapster**:

1. Buka Edit Khusein
2. Ubah komisi:
    - Potong Rambut: 50%
    - Layanan Lain: 30%
    - Produk: 30%
3. Save

**Laporan langsung update**:

-   Komisi Potong Rambut: Rp 39.250 (4x **50%**) ✨
-   Komisi Layanan Lain: Rp 36.250 (10x **30%**) ✨
-   Komisi Produk: Rp 6.000 (1x **30%**) ✨

**PDF Slip Gaji juga update**:

-   Komisi Potong Rambut (**50%**): Rp 39.250 ✨
-   Komisi Layanan Lain (**30%**): Rp 36.250 ✨
-   Komisi Produk (**30%**): Rp 6.000 ✨

### Scenario 3: Junior Kapster dengan Rate Lebih Rendah

**Kapster**: Budi (Junior)
**Komisi**: 30% / 20% / 20% (custom)

**Hasil perhitungan otomatis menggunakan rate yang lebih rendah**.

## Key Benefits

✅ **Real-time Update**: Perubahan komisi langsung terlihat di laporan
✅ **Transparent**: User dapat melihat persentase yang digunakan untuk perhitungan
✅ **Accurate**: Tidak ada hard-coded values, semua dinamis
✅ **Consistent**: View dan PDF menampilkan persentase yang sama
✅ **Flexible**: Mendukung custom rate per kapster

## Technical Details

### Data Flow

```
Database (kapster table)
  ↓ (komisi_potong_rambut, komisi_layanan_lain, komisi_produk)
KomisiService
  ↓ (menggunakan rate individual untuk perhitungan)
LaporanService
  ↓ (mengirim data perhitungan + persentase)
View (gaji-kapster.blade.php)
  ↓ (tampilkan persentase dinamis)
PDF (slip-gaji.blade.php)
  ↓ (tampilkan persentase dinamis)
```

### Fallback Mechanism

Jika kapster belum punya rate individual (NULL), sistem otomatis menggunakan default:

-   Potong Rambut: 40%
-   Layanan Lain: 25%
-   Produk: 25%

Ini di-handle di 2 tempat:

1. **KomisiService**: `$kapster->komisi_potong_rambut ?? 40`
2. **LaporanService**: `$kapster->komisi_potong_rambut ?? 40`

## Testing Checklist

-   [x] Ubah komisi kapster di Kelola Kapster
-   [x] Buka tab Gaji & Komisi di Laporan
-   [x] Verifikasi persentase ditampilkan sesuai setting
-   [x] Export PDF Slip Gaji
-   [x] Verifikasi PDF menampilkan persentase yang sama
-   [x] Test dengan kapster yang tidak punya custom rate (gunakan default)
-   [x] Test dengan multiple kapster dengan rate berbeda

## Notes

⚠️ **Penting**:

-   Perubahan komisi di Kelola Kapster **langsung aktif** untuk semua transaksi baru
-   Transaksi lama **tetap menggunakan perhitungan saat transaksi tersebut dibuat**
-   KomisiService sudah di-update untuk membaca rate individual kapster
-   View dan PDF sudah sinkron menampilkan persentase yang sama

## Files Modified

1. `app/Services/LaporanService.php` - Add dynamic percentage data
2. `resources/views/pages/laporan/partials/gaji-kapster.blade.php` - Dynamic display
3. `resources/views/pages/laporan/pdf/slip-gaji.blade.php` - Dynamic PDF display

---

**Last Updated**: 2025-10-10
**Status**: ✅ Completed & Tested
**Version**: 1.0
