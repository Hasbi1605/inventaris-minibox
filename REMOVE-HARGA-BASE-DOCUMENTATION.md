# Dokumentasi: Menghapus Harga Base/Default pada Layanan

## 📋 Overview

Menghapus field **"Harga Base/Default"** dari form Tambah dan Edit Layanan. Sekarang sistem hanya menggunakan **harga spesifik per cabang** saja.

## 🎯 Alasan Perubahan

### Sebelumnya (Membingungkan):

1. ❌ User harus input **Harga Base** terlebih dahulu
2. ❌ Kemudian baru input **Harga Spesifik per Cabang** (opsional)
3. ❌ Jika harga spesifik kosong → pakai harga base
4. ❌ **Redundan dan membingungkan**

### Sekarang (Lebih Sederhana):

1. ✅ User langsung pilih cabang
2. ✅ Input harga langsung untuk masing-masing cabang
3. ✅ **Tidak ada harga base** lagi
4. ✅ **Lebih jelas dan tidak membingungkan**

## 🔧 File yang Diubah

### 1. **resources/views/pages/kelola-layanan/create.blade.php**

**Before:**

```blade
<!-- Harga Base/Default -->
<div class="col-span-1 lg:col-span-2">
    <label>Harga Base/Default <span class="text-red-500">*</span></label>
    <input type="number" name="harga" required placeholder="0" />
    <div class="text-xs text-slate-500 mt-1">
        Harga default yang akan digunakan jika tidak ada harga spesifik per cabang
    </div>
</div>

<!-- Cabang & Harga Spesifik -->
<div class="col-span-1 lg:col-span-2">
    <label>Tersedia di Cabang & Harga Spesifik</label>
    <p>Pilih cabang dan set harga spesifik (kosongkan untuk menggunakan harga base)</p>
    ...
    <input name="harga_cabang[...]" placeholder="Kosongkan untuk pakai harga base" />
</div>
```

**After:**

```blade
<!-- Langsung ke Cabang & Harga (No Base Price) -->
<div class="col-span-1 lg:col-span-2">
    <label><i class="fas fa-store mr-2"></i>Pilih Cabang & Set Harga <span class="text-red-500">*</span></label>
    <p>Pilih cabang dan tentukan harga layanan untuk masing-masing cabang</p>
    ...
    <label>Harga di {{ $cabang->nama_cabang }} <span class="text-red-500">*</span></label>
    <input name="harga_cabang[...]" placeholder="Masukkan harga" required />
</div>
```

**Key Changes:**

-   ❌ Removed entire "Harga Base/Default" section
-   ✅ Changed label dari "Tersedia di Cabang & Harga Spesifik" → **"Pilih Cabang & Set Harga"**
-   ✅ Changed description dari "kosongkan untuk menggunakan harga base" → **"tentukan harga untuk masing-masing cabang"**
-   ✅ Added `<span class="text-red-500">*</span>` to harga input (now required)
-   ✅ Changed placeholder dari "Kosongkan untuk pakai harga base" → **"Masukkan harga"**
-   ✅ Updated info text: "Pilih minimal 1 cabang dan tentukan harga untuk setiap cabang yang dipilih"

### 2. **resources/views/pages/kelola-layanan/edit.blade.php**

**Changes:** Same as create.blade.php

-   ❌ Removed "Harga Base/Default" section
-   ✅ Simplified to direct per-cabang pricing only

### 3. **app/Http/Requests/LayananRequest.php**

**Before:**

```php
$rules = [
    'harga' => 'required|numeric|min:0|max:999999999.99',
    'harga_cabang' => 'nullable|array',
    'harga_cabang.*' => 'nullable|numeric|min:0|max:999999999.99'
];

$messages = [
    'harga.required' => 'Harga layanan wajib diisi.',
    'harga.numeric' => 'Harga harus berupa angka.',
    ...
];
```

**After:**

```php
$rules = [
    // 'harga' => REMOVED
    'harga_cabang' => 'required|array|min:1',
    'harga_cabang.*' => 'required|numeric|min:0|max:999999999.99'
];

$messages = [
    // 'harga.*' messages REMOVED
    'harga_cabang.required' => 'Harga untuk setiap cabang wajib diisi.',
    'harga_cabang.min' => 'Minimal isi harga untuk 1 cabang.',
    'harga_cabang.*.required' => 'Harga cabang wajib diisi.',
    ...
];
```

**Key Changes:**

-   ❌ Removed `'harga' => 'required|...'` validation rule
-   ✅ Changed `harga_cabang` from `nullable` → **`required`**
-   ✅ Changed `harga_cabang.*` from `nullable` → **`required`**
-   ✅ Added `min:1` to ensure at least 1 cabang has price
-   ✅ Updated validation messages accordingly

### 4. **app/Services/LayananService.php**

**Before:**

```php
public function createLayanan(array $data)
{
    $cabangIds = $data['cabang_ids'] ?? [];
    $hargaCabang = $data['harga_cabang'] ?? [];

    unset($data['cabang_ids'], $data['harga_cabang']);

    // Create layanan with base price
    $layanan = Layanan::create($data); // $data['harga'] included

    // Attach to cabangs
    $syncData = [];
    foreach ($cabangIds as $cabangId) {
        $syncData[$cabangId] = [
            'harga' => isset($hargaCabang[$cabangId]) && !empty($hargaCabang[$cabangId])
                ? $hargaCabang[$cabangId]
                : $data['harga'], // ⚠️ Fallback to base price
            'status' => $data['status']
        ];
    }

    $layanan->cabangs()->sync($syncData);
    return $layanan;
}
```

**After:**

```php
public function createLayanan(array $data)
{
    $cabangIds = $data['cabang_ids'] ?? [];
    $hargaCabang = $data['harga_cabang'] ?? [];

    unset($data['cabang_ids'], $data['harga_cabang']);

    // ✅ Set harga to 0 (not used anymore)
    $data['harga'] = 0;

    // Create layanan
    $layanan = Layanan::create($data);

    // Attach to cabangs with direct prices
    $syncData = [];
    foreach ($cabangIds as $cabangId) {
        $syncData[$cabangId] = [
            'harga' => $hargaCabang[$cabangId] ?? 0, // ✅ Direct price, no fallback
            'status' => $data['status']
        ];
    }

    $layanan->cabangs()->sync($syncData);
    return $layanan;
}
```

**Key Changes:**

-   ✅ Added `$data['harga'] = 0;` before creating layanan (untuk backward compatibility di database)
-   ✅ Removed fallback logic: `?: $data['harga']`
-   ✅ Now uses direct price: `$hargaCabang[$cabangId] ?? 0`
-   ✅ Same changes applied to `updateLayanan()` method

### 5. **Database Notes**

**Field `harga` di tabel `layanans`:**

-   ❌ **Tidak dihapus** dari database schema (untuk backward compatibility)
-   ✅ Otomatis diset ke `0` untuk semua layanan baru
-   ✅ Field ini **tidak digunakan** lagi dalam logic sistem
-   ℹ️ Sistem sepenuhnya pakai harga dari pivot table `cabang_layanan`

**Field `harga` di tabel `cabang_layanan` (pivot):**

-   ✅ Ini yang **aktif digunakan**
-   ✅ Setiap cabang punya harga spesifik sendiri
-   ✅ Wajib diisi (validated as `required`)

## 📊 User Flow Comparison

### Before (Confusing):

```
1. Input Nama Layanan
2. Pilih Kategori
3. Pilih Status
4. ⚠️ Input Harga Base (Rp 50,000) ← MEMBINGUNGKAN
5. Pilih Cabang A
   └─ Input Harga Khusus (Rp 60,000) atau kosongkan
6. Pilih Cabang B
   └─ Input Harga Khusus (Rp 55,000) atau kosongkan
7. Pilih Cabang C
   └─ Kosongkan → pakai Rp 50,000 (harga base) ← MEMBINGUNGKAN
```

### After (Clear):

```
1. Input Nama Layanan
2. Pilih Kategori
3. Pilih Status
4. ✅ Pilih Cabang A
   └─ Input Harga: Rp 60,000 ← WAJIB ISI
5. ✅ Pilih Cabang B
   └─ Input Harga: Rp 55,000 ← WAJIB ISI
6. ✅ Pilih Cabang C
   └─ Input Harga: Rp 50,000 ← WAJIB ISI
```

## ✅ Benefits

### User Experience:

1. ✅ **Lebih sederhana** - Tidak perlu bingung kapan pakai base, kapan pakai spesifik
2. ✅ **Lebih jelas** - Setiap cabang harus punya harga, tidak ada ambiguitas
3. ✅ **Menghindari error** - Tidak ada kemungkinan lupa set harga dan accidentally pakai base price yang salah
4. ✅ **Lebih cepat** - Langsung isi harga per cabang tanpa tahap tambahan

### Developer:

1. ✅ **Kode lebih clean** - Tidak ada fallback logic yang rumit
2. ✅ **Validasi lebih ketat** - Semua harga cabang wajib diisi
3. ✅ **Konsisten** - Satu sumber truth (pivot table), bukan dua tempat (layanans.harga + pivot.harga)

## 🧪 Testing Checklist

-   [ ] Buka halaman **Tambah Layanan**
    -   [ ] Pastikan field "Harga Base/Default" **tidak ada**
    -   [ ] Pastikan section langsung "Pilih Cabang & Set Harga"
    -   [ ] Pilih 1 cabang → input harga muncul dengan tanda **merah (\*)**
-   [ ] Test **Submit tanpa isi harga**
    -   [ ] Harus muncul error: "Harga cabang wajib diisi."
-   [ ] Test **Submit dengan harga valid**
    -   [ ] Layanan berhasil dibuat
    -   [ ] Cek database:
        -   `layanans.harga` = **0**
        -   `cabang_layanan.harga` = harga yang diinput
-   [ ] Buka halaman **Edit Layanan**
    -   [ ] Pastikan field "Harga Base/Default" **tidak ada**
    -   [ ] Harga yang ditampilkan adalah harga dari masing-masing cabang
    -   [ ] Update harga → berhasil tersimpan
-   [ ] Buka halaman **Detail Layanan**
    -   [ ] Pastikan tampilan harga per cabang masih benar
-   [ ] Buka halaman **Index/List Layanan**
    -   [ ] Tab per cabang masih berfungsi
    -   [ ] Harga yang ditampilkan adalah harga per cabang yang sesuai

## 📝 Migration Notes

**⚠️ IMPORTANT:**

-   Field `harga` di tabel `layanans` **TIDAK DIHAPUS**
-   Alasan:
    1. Backward compatibility dengan data existing
    2. Menghindari breaking changes pada model
    3. Set otomatis ke 0 untuk data baru

**If you want to clean up (Optional):**

```php
// Future cleanup migration (only after all data migrated)
Schema::table('layanans', function (Blueprint $table) {
    $table->dropColumn('harga');
});
```

## 🎉 Summary

| Aspect              | Before                         | After                     |
| ------------------- | ------------------------------ | ------------------------- |
| **Harga Base**      | ✅ Ada (required)              | ❌ Tidak ada              |
| **Harga Cabang**    | ⚠️ Opsional (fallback ke base) | ✅ Wajib (required)       |
| **User Experience** | ⚠️ Membingungkan               | ✅ Jelas & Sederhana      |
| **Validation**      | ⚠️ Loose (`nullable`)          | ✅ Ketat (`required`)     |
| **Code Complexity** | ⚠️ Ada fallback logic          | ✅ Direct & Clean         |
| **Database**        | ⚠️ 2 sumber (base + cabang)    | ✅ 1 sumber (cabang only) |

---

**Date:** 2025-10-11  
**Status:** ✅ Implemented  
**Breaking Changes:** None (backward compatible)  
**Next Steps:** Test thoroughly before deployment
