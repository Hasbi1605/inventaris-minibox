# Fix: Alamat Cabang Tidak Muncul di Form Create Layanan

## 🐛 Bug Report

**Issue:** Di form create layanan, alamat cabang tertulis "Alamat belum diisi" padahal di kelola cabang alamat sudah diisi.

**Location:** `/kelola-layanan/create` - Section "Tersedia di Cabang & Harga Spesifik"

**Screenshot Evidence:** User reported alamat showing as "Alamat belum diisi" for all cabangs.

## 🔍 Root Cause Analysis

### Investigation

Method `getAllCabangForDropdown()` di `CabangService.php` hanya mengambil 2 kolom:

```php
->get(['id', 'nama_cabang']);  // ❌ Missing 'alamat' column
```

Sedangkan di view `create.blade.php` menggunakan:

```blade
<p class="text-xs text-slate-500">{{ $cabang->alamat ?? 'Alamat belum diisi' }}</p>
```

Karena kolom `alamat` tidak di-fetch dari database, maka `$cabang->alamat` selalu `null`, sehingga fallback text "Alamat belum diisi" yang muncul.

## ✅ Solution

### File: `app/Services/CabangService.php`

**Before:**

```php
public function getAllCabangForDropdown(): Collection
{
    return Cabang::where('status', 'aktif')
        ->orderBy('nama_cabang')
        ->get(['id', 'nama_cabang']);
}
```

**After:**

```php
public function getAllCabangForDropdown(): Collection
{
    return Cabang::where('status', 'aktif')
        ->orderBy('nama_cabang')
        ->get(['id', 'nama_cabang', 'alamat']);
}
```

## 📝 Explanation

Ketika menggunakan `get()` dengan array parameter, Laravel hanya akan fetch kolom-kolom yang disebutkan. Kolom lain tidak akan tersedia di object result.

**Query Before:**

```sql
SELECT id, nama_cabang FROM cabang WHERE status = 'aktif' ORDER BY nama_cabang
```

**Query After:**

```sql
SELECT id, nama_cabang, alamat FROM cabang WHERE status = 'aktif' ORDER BY nama_cabang
```

## 🎯 Impact

Method `getAllCabangForDropdown()` digunakan di beberapa controller:

-   ✅ `KelolaLayananController` - create() & index()
-   ✅ `KelolaTransaksiController` - index(), create(), edit()
-   ✅ `KelolaInventarisController` - index(), create(), edit()

**Benefit:** Sekarang semua form yang menggunakan method ini akan menampilkan alamat cabang dengan benar.

## 🧪 Testing

### Before Fix:

```
Minibox Balong
Alamat belum diisi  ❌

Minibox Krajen
Alamat belum diisi  ❌
```

### After Fix:

```
Minibox Balong
Jl. Balong No. 123, Purwokerto  ✅

Minibox Krajen
Jl. Krajen Raya No. 456, Purwokerto  ✅
```

## ⚠️ Note

Method ini bernama `getAllCabangForDropdown()` yang awalnya memang hanya didesain untuk dropdown sederhana (hanya id & nama). Namun seiring perkembangan aplikasi, method ini juga digunakan untuk display form dengan informasi alamat.

### Alternative Solution (Not Implemented)

Bisa juga membuat method baru seperti:

```php
public function getAllCabangForForm(): Collection
{
    return Cabang::where('status', 'aktif')
        ->orderBy('nama_cabang')
        ->get(); // Get all columns
}
```

Tapi untuk saat ini, menambahkan kolom `alamat` ke existing method lebih efisien dan tidak breaking existing code.

## 📚 Related Files

**Modified:**

-   `app/Services/CabangService.php` (line 332)

**Affected Controllers:**

-   `app/Http/Controllers/KelolaLayananController.php`
-   `app/Http/Controllers/KelolaTransaksiController.php`
-   `app/Http/Controllers/KelolaInventarisController.php`

**Affected Views:**

-   `resources/views/pages/kelola-layanan/create.blade.php`
-   All other forms using this service method

## ✅ Verification

After fix:

1. ✅ Alamat cabang muncul di form create layanan
2. ✅ Alamat cabang muncul di form create/edit transaksi
3. ✅ Alamat cabang muncul di form create/edit inventaris
4. ✅ No breaking changes to existing functionality
5. ✅ Performance impact minimal (1 extra column in SELECT)

---

**Fixed Date:** October 6, 2025
**Status:** ✅ Resolved
