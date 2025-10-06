# Fix: Table 'cabangs' doesn't exist

## 🐛 Bug Report

**Error:** `SQLSTATE[42S02]: Base table or view not found: 1146 Table 'inventaris_barbershop.cabangs' doesn't exist`

**Location:** Terjadi saat input layanan baru di form create

**Root Cause:** Validation rule di `LayananRequest.php` menggunakan nama tabel yang salah `cabangs` (plural) padahal nama tabel di database adalah `cabang` (singular).

## ✅ Solution

### File: `app/Http/Requests/LayananRequest.php`

**Before:**

```php
'cabang_ids.*' => 'required|exists:cabangs,id',
```

**After:**

```php
'cabang_ids.*' => 'required|exists:cabang,id',
```

## 📝 Explanation

Laravel validation rule `exists:table,column` harus menggunakan nama tabel yang **sebenarnya** ada di database.

Dari migration file `2025_09_10_093041_create_cabang_table.php`:

```php
Schema::create('cabang', function (Blueprint $table) {
    $table->id();
    $table->string('nama_cabang');
    // ...
});
```

Terlihat bahwa nama tabelnya adalah `cabang` bukan `cabangs`.

## 🔍 Konvensi Penamaan di Project Ini

| Model       | Table Name   | Note                    |
| ----------- | ------------ | ----------------------- |
| Cabang      | cabang       | Singular (tidak plural) |
| Layanan     | layanans     | Plural                  |
| Inventaris  | inventaris   | Singular (tidak plural) |
| Kategori    | kategoris    | Plural                  |
| Transaksi   | transaksis   | Plural                  |
| Pengeluaran | pengeluarans | Plural                  |

**⚠️ Warning:** Project ini tidak konsisten dalam penamaan tabel. Beberapa menggunakan plural, beberapa singular. Pastikan selalu cek migration file untuk nama tabel yang benar.

## ✅ Verification

Setelah fix:

1. ✅ Form create layanan bisa submit tanpa error
2. ✅ Validation `cabang_ids` berjalan dengan benar
3. ✅ Data layanan tersimpan ke database
4. ✅ Pivot table `cabang_layanan` terisi dengan benar

## 📚 Related Files

**Modified:**

-   `app/Http/Requests/LayananRequest.php` (line 41)
-   `LAYANAN_CREATE_FORM_IMPLEMENTATION.md` (documentation update)

**Reference:**

-   `database/migrations/2025_09_10_093041_create_cabang_table.php`
-   `database/migrations/2025_10_05_125229_create_cabang_layanan_table.php`

---

**Fixed Date:** October 6, 2025
**Status:** ✅ Resolved
