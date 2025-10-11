# Update: Separated Commission Columns in Kelola Kapster

## Overview

Kolom komisi di halaman **Kelola Kapster** sekarang dipisah menjadi **3 kolom terpisah** untuk konsistensi dengan tampilan di **Tab Gaji & Komisi** pada halaman Laporan.

## Changes Made

### Before:

```
| KAPSTER | CABANG | SPESIALISASI | STATUS | KOMISI (%) | AKSI |
|---------|--------|--------------|--------|------------|------|
| Arif    | Balong | -            | AKTIF  | 🔵40% 🟣25% 🟢25% | ⚫🔵🔴 |
```

### After:

```
| KAPSTER | CABANG | SPESIALISASI | STATUS | KOMISI POTONG RAMBUT | KOMISI LAYANAN LAIN | KOMISI PRODUK | AKSI |
|---------|--------|--------------|--------|---------------------|-------------------|--------------|------|
| Arif    | Balong | -            | AKTIF  | 40%                 | 25%               | 25%          | ⚫🔵🔴 |
```

## Visual Comparison

### Kelola Kapster (Now):

```
┌──────────┬────────────┬──────────────┬────────┬─────────────┬─────────────┬──────────┬──────┐
│ KAPSTER  │ CABANG     │ SPESIALISASI │ STATUS │ KOMISI P.R. │ KOMISI L.L. │ KOMISI P │ AKSI │
├──────────┼────────────┼──────────────┼────────┼─────────────┼─────────────┼──────────┼──────┤
│ Khusein  │ Krajen     │      -       │ AKTIF  │    40%      │    25%      │   30%    │ ⚫🔵🔴│
│ Panca    │ Candi      │      -       │ AKTIF  │    40%      │    25%      │   25%    │ ⚫🔵🔴│
│ Mahesa   │ Balong     │      -       │ AKTIF  │    40%      │    25%      │   25%    │ ⚫🔵🔴│
│ Arif     │ Balong     │      -       │ AKTIF  │    40%      │    25%      │   25%    │ ⚫🔵🔴│
└──────────┴────────────┴──────────────┴────────┴─────────────┴─────────────┴──────────┴──────┘
```

### Tab Gaji & Komisi di Laporan (Reference):

```
┌──────────┬────────────┬───────────────┬─────────────┬─────────────┬──────────┬────────────┐
│ KAPSTER  │ CABANG     │ TOTAL TRXN    │ KOMISI P.R. │ KOMISI L.L. │ KOMISI P │ TOTAL GAJI │
├──────────┼────────────┼───────────────┼─────────────┼─────────────┼──────────┼────────────┤
│ Khusein  │ Krajen     │ 4 / Rp 177k   │ Rp 0 (40%)  │ Rp 39k (25%)│ Rp 6k(30%)│ Rp 45.250 │
│ Panca    │ Candi      │ 10 / Rp 295k  │ Rp 36k (40%)│ Rp 36k (25%)│ Rp 15k(25%)│ Rp 87.250│
└──────────┴────────────┴───────────────┴─────────────┴─────────────┴──────────┴────────────┘
```

## Implementation Details

### File Modified:

`resources/views/pages/kelola-kapster/index.blade.php`

### 1. Table Header

**Before** (1 merged column):

```blade
<th>Komisi (%)</th>
```

**After** (3 separate columns):

```blade
<th>Komisi Potong Rambut</th>
<th>Komisi Layanan Lain</th>
<th>Komisi Produk</th>
```

### 2. Table Body

**Before** (3 badges in 1 cell):

```blade
<td class="p-2 text-center...">
    <div class="flex items-center justify-center gap-1 flex-wrap">
        <span class="...text-blue-700...">🔵 40%</span>
        <span class="...text-purple-700...">🟣 25%</span>
        <span class="...text-green-700...">🟢 25%</span>
    </div>
</td>
```

**After** (3 separate cells):

```blade
<td class="p-2 text-center...">
    <span class="text-xs font-semibold text-green-600">40%</span>
</td>
<td class="p-2 text-center...">
    <span class="text-xs font-semibold text-orange-600">25%</span>
</td>
<td class="p-2 text-center...">
    <span class="text-xs font-semibold text-purple-600">30%</span>
</td>
```

### 3. Color Coding

Konsisten dengan warna di Laporan:

-   **Komisi Potong Rambut**: `text-green-600` (hijau)
-   **Komisi Layanan Lain**: `text-orange-600` (oranye)
-   **Komisi Produk**: `text-purple-600` (ungu)

### 4. Empty State

Updated colspan dari `6` ke `8` untuk menyesuaikan dengan jumlah kolom baru.

## Benefits

✅ **Konsisten**: Tampilan sama dengan Tab Gaji & Komisi di Laporan
✅ **Lebih Jelas**: Setiap jenis komisi punya kolom sendiri
✅ **Mudah Dibaca**: Format sederhana dengan persentase saja
✅ **Responsive**: Tetap rapi di berbagai ukuran layar
✅ **Color-coded**: Warna membedakan jenis komisi

## Comparison with Laporan

| Aspect  | Kelola Kapster        | Tab Gaji (Laporan)      |
| ------- | --------------------- | ----------------------- |
| Layout  | 3 kolom terpisah      | 3 kolom terpisah ✓      |
| Format  | XX%                   | Rp XXX (XX%)            |
| Colors  | Green, Orange, Purple | Green, Orange, Purple ✓ |
| Spacing | Clean & simple        | Clean & simple ✓        |

## User Experience

### Before:

-   User melihat 3 badge dalam 1 kolom sempit
-   Sulit membandingkan antar kapster
-   Inconsistent dengan laporan

### After:

-   User melihat 3 kolom terpisah yang lebar
-   Mudah membandingkan komisi per jenis
-   **Consistent dengan tampilan di laporan** ✨

## Example Data Display

```
Khusein: 40% | 25% | 30%
Panca:   40% | 25% | 25%
Mahesa:  40% | 25% | 25%
Arif:    40% | 25% | 25%
```

Sekarang mudah untuk:

-   ✓ Membandingkan rate antar kapster
-   ✓ Mengidentifikasi kapster dengan custom rate (Khusein: 30% produk)
-   ✓ Melihat pola komisi di tim

## Technical Notes

-   Total columns: **8** (Kapster, Cabang, Spesialisasi, Status, 3x Komisi, Aksi)
-   Table width: Auto-expand dengan `overflow-x-auto`
-   Column alignment: `text-center` untuk semua kolom komisi
-   Font size: `text-xs` untuk consistency

---

**Date**: 2025-10-10
**Status**: ✅ Implemented
**Impact**: Better UX, consistent with Laporan view
