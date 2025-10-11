# Dokumentasi: Individual Komisi Settings untuk Kapster

## Overview

Fitur ini memungkinkan setiap kapster memiliki pengaturan komisi yang berbeda untuk 3 jenis transaksi:

1. **Potong Rambut** (default: 40%)
2. **Layanan Lain** (default: 25%)
3. **Produk** (default: 25%)

Sebelumnya, sistem menggunakan pengaturan komisi global dari tabel `settings`. Sekarang setiap kapster dapat memiliki rate komisi mereka sendiri.

## Perubahan Database

### Migration: `2025_10_10_195130_add_komisi_fields_to_kapster_table.php`

Menambahkan 3 kolom baru ke tabel `kapster`:

```php
$table->decimal('komisi_potong_rambut', 5, 2)->default(40.00)->comment('Komisi untuk layanan potong rambut (%)');
$table->decimal('komisi_layanan_lain', 5, 2)->default(25.00)->comment('Komisi untuk layanan lain (%)');
$table->decimal('komisi_produk', 5, 2)->default(25.00)->comment('Komisi untuk penjualan produk (%)');
```

**Tipe Data**: `decimal(5, 2)` - dapat menyimpan nilai 0.00 sampai 999.99
**Default Values**: 40.00, 25.00, 25.00 (sesuai dengan rate global sebelumnya)

## Perubahan Model

### `app/Models/Kapster.php`

**Tambahan ke `$fillable`**:

```php
'komisi_potong_rambut',
'komisi_layanan_lain',
'komisi_produk'
```

**Tambahan ke `$casts`**:

```php
'komisi_potong_rambut' => 'decimal:2',
'komisi_layanan_lain' => 'decimal:2',
'komisi_produk' => 'decimal:2',
```

## Perubahan Form Request

### `app/Http/Requests/KapsterRequest.php`

**Validation Rules** (menggantikan `komisi_persen` yang lama):

```php
'komisi_potong_rambut' => [
    'required',
    'numeric',
    'min:0',
    'max:100',
],
'komisi_layanan_lain' => [
    'required',
    'numeric',
    'min:0',
    'max:100',
],
'komisi_produk' => [
    'required',
    'numeric',
    'min:0',
    'max:100',
],
```

**Custom Error Messages**:

-   Setiap field memiliki pesan error khusus untuk required, numeric, min, dan max validation

## Perubahan Controller

### `app/Http/Controllers/KapsterController.php`

**Statistics Calculation** (method `index()`):

```php
'rata_rata_komisi' => [
    'potong_rambut' => Kapster::where('status', 'aktif')->avg('komisi_potong_rambut') ?? 40,
    'layanan_lain' => Kapster::where('status', 'aktif')->avg('komisi_layanan_lain') ?? 25,
    'produk' => Kapster::where('status', 'aktif')->avg('komisi_produk') ?? 25,
],
```

Sekarang menghitung rata-rata untuk masing-masing jenis komisi.

## Perubahan Views

### 1. `resources/views/pages/kelola-kapster/create.blade.php`

**Sebelum**:

-   Single input field untuk `komisi_persen`

**Sesudah**:

-   Card dengan gradient background (blue-cyan)
-   3 input fields terpisah dengan icon:
    -   Potong Rambut: `fa-cut` icon (blue theme)
    -   Layanan Lain: `fa-spa` icon (purple theme)
    -   Produk: `fa-shopping-bag` icon (green theme)
-   Grid layout: 3 columns di desktop, 1 column di mobile
-   Default values: 40, 25, 25

### 2. `resources/views/pages/kelola-kapster/edit.blade.php`

Struktur sama dengan create.blade.php, tetapi menggunakan `old()` helper dengan fallback ke database values:

```blade
old('komisi_potong_rambut', $kelola_kapster->komisi_potong_rambut ?? 40)
```

### 3. `resources/views/pages/kelola-kapster/index.blade.php`

**Statistics Card** (Rata-rata Komisi):

-   Menampilkan 3 badge terpisah dengan warna berbeda
-   Icon untuk setiap jenis komisi
-   Format: `XX.X%` dengan 1 desimal

**Table Column** (Komisi):

-   Mengubah dari single value menjadi 3 badge dalam kolom vertikal
-   Color-coded badges:
    -   Potong Rambut: Blue gradient
    -   Layanan Lain: Purple gradient
    -   Produk: Green gradient
-   Format: `icon + percentage`

### 4. `resources/views/pages/kelola-kapster/show.blade.php`

**Detail Display**:

-   3 badge terpisah dalam flex column
-   Consistent styling dengan index dan form views
-   Format: `Label: XX%`

## Perubahan Service Layer

### `app/Services/KomisiService.php`

#### Method: `hitungKomisiTransaksi()`

**Signature** (diperbarui):

```php
public function hitungKomisiTransaksi(Transaksi $transaksi, ?Kapster $kapster = null)
```

**Logic Priority**:

1. Jika `$kapster` tersedia dan memiliki nilai komisi individual → gunakan nilai tersebut
2. Jika tidak → gunakan nilai dari `Settings` (fallback)

**Contoh untuk Layanan**:

```php
if ($kategori->komisi_type === 'potong_rambut') {
    $persenKomisi = $kapster && $kapster->komisi_potong_rambut !== null
        ? (float) $kapster->komisi_potong_rambut
        : (float) Setting::get('komisi_potong_rambut', 40);
} else {
    $persenKomisi = $kapster && $kapster->komisi_layanan_lain !== null
        ? (float) $kapster->komisi_layanan_lain
        : (float) Setting::get('komisi_layanan_lain', 25);
}
```

**Contoh untuk Produk**:

```php
$persenKomisiProduk = $kapster && $kapster->komisi_produk !== null
    ? (float) $kapster->komisi_produk
    : (float) Setting::get('komisi_produk', 25);
```

#### Method: `hitungKomisiKapster()`

**Perubahan**:

-   Load kapster di awal method: `$kapster = Kapster::find($kapsterId);`
-   Pass kapster ke `hitungKomisiTransaksi()`: `$komisiData = $this->hitungKomisiTransaksi($transaksi, $kapster);`

Ini memastikan setiap transaksi dihitung menggunakan komisi individual kapster yang sesuai.

## Flow Diagram

```
User mengisi form Create/Edit Kapster
    ↓
3 input komisi (potong_rambut, layanan_lain, produk)
    ↓
KapsterRequest validation (required, 0-100)
    ↓
KapsterController store/update
    ↓
Kapster model save ke database
    ↓
---
Saat perhitungan komisi (laporan/slip gaji):
    ↓
LaporanService memanggil KomisiService
    ↓
KomisiService->hitungKomisiKapster($kapsterId, ...)
    ↓
Load Kapster model
    ↓
Loop transaksi → hitungKomisiTransaksi($transaksi, $kapster)
    ↓
Cek: Kapster punya komisi individual?
    ├─ Ya → Gunakan $kapster->komisi_*
    └─ Tidak → Gunakan Setting::get('komisi_*')
    ↓
Hitung dan return hasil komisi
```

## Backward Compatibility

✅ **Fully backward compatible**:

-   Kolom baru memiliki default values (40, 25, 25)
-   Existing data otomatis mendapat default values
-   Service layer memiliki fallback ke Settings jika nilai NULL
-   Form requests memvalidasi input baru

## UI/UX Design

### Color Scheme

-   **Potong Rambut**: Blue-Cyan gradient (`from-blue-50 to-cyan-50`, `text-blue-700`, `border-blue-200`)
-   **Layanan Lain**: Purple-Pink gradient (`from-purple-50 to-pink-50`, `text-purple-700`, `border-purple-200`)
-   **Produk**: Green-Emerald gradient (`from-green-50 to-emerald-50`, `text-green-700`, `border-green-200`)

### Icons

-   **Potong Rambut**: `fa-cut` (scissors)
-   **Layanan Lain**: `fa-spa` (spa/wellness)
-   **Produk**: `fa-shopping-bag` (shopping)

### Layout

-   **Desktop**: 3-column grid
-   **Mobile**: Single column stack
-   **Card background**: Gradient blue-cyan with subtle border
-   **Badge style**: Rounded, bordered, with icon prefix

## Testing Checklist

-   [x] Migration runs successfully
-   [x] Model fillable and casts configured
-   [x] Form validation works correctly
-   [x] Create form displays 3 commission inputs
-   [x] Edit form displays existing values
-   [x] Index table shows 3 commission badges
-   [x] Show page displays commission details
-   [x] Statistics card shows average commission
-   [ ] Commission calculation uses individual rates
-   [ ] Slip gaji displays correct commission amounts
-   [ ] Laporan shows accurate commission data

## Business Impact

### Fleksibilitas

-   Setiap kapster dapat memiliki rate komisi berbeda
-   Memungkinkan reward untuk kapster senior (rate lebih tinggi)
-   Memungkinkan rate lebih rendah untuk kapster junior/training

### Contoh Use Case

1. **Kapster Senior**: 50% / 30% / 30%
2. **Kapster Regular**: 40% / 25% / 25% (default)
3. **Kapster Junior**: 30% / 20% / 20%
4. **Specialist**: 45% / 35% / 20% (fokus ke layanan)

## Migration Instructions

### Running the Migration

```bash
php artisan migrate
```

### Rollback (jika diperlukan)

```bash
php artisan migrate:rollback
```

Migration akan menghapus 3 kolom komisi yang ditambahkan.

## File Changes Summary

| File                                                                           | Type     | Changes                        |
| ------------------------------------------------------------------------------ | -------- | ------------------------------ |
| `database/migrations/2025_10_10_195130_add_komisi_fields_to_kapster_table.php` | New      | Migration untuk 3 kolom komisi |
| `app/Models/Kapster.php`                                                       | Modified | Tambah fillable & casts        |
| `app/Http/Requests/KapsterRequest.php`                                         | Modified | Update validation rules        |
| `app/Http/Controllers/KapsterController.php`                                   | Modified | Update statistics calculation  |
| `resources/views/pages/kelola-kapster/create.blade.php`                        | Modified | 3-field commission card        |
| `resources/views/pages/kelola-kapster/edit.blade.php`                          | Modified | 3-field commission card        |
| `resources/views/pages/kelola-kapster/index.blade.php`                         | Modified | Table column & statistics card |
| `resources/views/pages/kelola-kapster/show.blade.php`                          | Modified | Commission detail display      |
| `app/Services/KomisiService.php`                                               | Modified | Individual rate support        |

## Notes

-   All commission values are stored as percentages (0-100)
-   Validation ensures values cannot be negative or exceed 100%
-   UI is fully responsive and mobile-friendly
-   Icons use Font Awesome (make sure Font Awesome is loaded)
-   Color scheme consistent across all views
-   Service layer automatically falls back to global settings if individual rates not set

## Future Enhancements

Potential improvements:

1. **Commission History**: Track changes to commission rates over time
2. **Bulk Update**: Update multiple kapsters' commissions at once
3. **Commission Templates**: Predefined commission templates (senior, junior, etc.)
4. **Performance Bonus**: Additional commission based on performance metrics
5. **Commission Limits**: Set minimum/maximum commission amounts per transaction

---

**Last Updated**: 2025-10-10
**Version**: 1.0
**Status**: ✅ Implemented & Ready for Testing
