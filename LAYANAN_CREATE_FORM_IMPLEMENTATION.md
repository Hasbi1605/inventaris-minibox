# Implementasi Form Create Layanan dengan Dynamic Cabang Selection

## 🎯 Tujuan

Menambahkan fitur pemilihan cabang dan input harga spesifik per cabang pada form create layanan, agar setiap layanan bisa memiliki harga yang berbeda di setiap cabang.

## 📋 Perubahan yang Dilakukan

### 1. **Update View: create.blade.php** ✅

**File:** `resources/views/pages/kelola-layanan/create.blade.php`

**Perubahan:**

-   Tambah section "Cabang & Harga Spesifik" dengan checkbox untuk setiap cabang
-   Input harga per cabang yang muncul dinamis ketika checkbox diceklis
-   JavaScript untuk toggle visibility input harga
-   Backup file lama ke `create-old.blade.php`

**Struktur Form Baru:**

```
1. Nama Layanan (required)
2. Kategori (optional)
3. Status (required: aktif/tidak_aktif)
4. Harga Base/Default (required) - fallback jika tidak ada harga spesifik
5. Deskripsi (optional)
6. Cabang & Harga Spesifik (required, minimal 1 cabang):
   - Checkbox per cabang
   - Input harga spesifik (muncul ketika checkbox diceklis)
   - Jika harga spesifik kosong, pakai harga base
```

**JavaScript Features:**

-   `toggleHargaCabang(cabangId)`: Show/hide input harga ketika checkbox di toggle
-   Auto-initialize untuk old input values (validation error state)
-   Clear harga value ketika checkbox di-uncheck

### 2. **Update Controller: KelolaLayananController.php** ✅

**File:** `app/Http/Controllers/KelolaLayananController.php`

**Method `create()` - Tambah cabangList:**

```php
public function create()
{
    $categories = $this->layananService->getAvailableCategories();
    $cabangList = $this->cabangService->getAllCabangForDropdown(); // ← BARU
    return view('pages.kelola-layanan.create', compact('categories', 'cabangList'));
}
```

### 3. **Update Validation: LayananRequest.php** ✅

**File:** `app/Http/Requests/LayananRequest.php`

**Rules Baru:**

```php
'status' => 'required|in:aktif,tidak_aktif', // Changed dari nonaktif
'cabang_ids' => 'required|array|min:1',
'cabang_ids.*' => 'required|exists:cabang,id',
'harga_cabang' => 'nullable|array',
'harga_cabang.*' => 'nullable|numeric|min:0|max:999999999.99'
```

**Custom Messages:**

```php
'cabang_ids.required' => 'Minimal pilih 1 cabang.',
'cabang_ids.min' => 'Minimal pilih 1 cabang.',
'cabang_ids.*.exists' => 'Cabang yang dipilih tidak valid.',
'harga_cabang.*.numeric' => 'Harga cabang harus berupa angka.',
```

### 4. **Update Service: LayananService.php** ✅

**File:** `app/Services/LayananService.php`

**Method `createLayanan()` - Support Pivot Table:**

```php
public function createLayanan(array $data)
{
    // Separate cabang data
    $cabangIds = $data['cabang_ids'] ?? [];
    $hargaCabang = $data['harga_cabang'] ?? [];

    // Remove cabang fields from main data
    unset($data['cabang_ids'], $data['harga_cabang']);

    // Create layanan
    $layanan = Layanan::create($data);

    // Attach to cabangs with specific prices
    $syncData = [];
    foreach ($cabangIds as $cabangId) {
        $syncData[$cabangId] = [
            'harga' => isset($hargaCabang[$cabangId]) && !empty($hargaCabang[$cabangId])
                ? $hargaCabang[$cabangId]
                : $data['harga'], // Use base price
            'status' => $data['status']
        ];
    }

    $layanan->cabangs()->sync($syncData);

    return $layanan;
}
```

**Logic:**

-   Extract `cabang_ids[]` dan `harga_cabang[]` dari request
-   Create layanan dengan data utama (nama, deskripsi, harga base, status, kategori)
-   Loop cabang_ids, untuk setiap cabang:
    -   Jika ada harga spesifik → gunakan harga spesifik
    -   Jika tidak ada harga spesifik → gunakan harga base
-   Sync ke pivot table `cabang_layanan` dengan `harga` dan `status`

### 5. **Model Relationship** ✅

**File:** `app/Models/Layanan.php` (Sudah Ada)

```php
public function cabangs()
{
    return $this->belongsToMany(Cabang::class, 'cabang_layanan')
        ->withPivot('harga', 'status')
        ->withTimestamps();
}

public function getHargaForCabang($cabangId)
{
    $cabangLayanan = $this->cabangs()->where('cabang_id', $cabangId)->first();
    return $cabangLayanan ? $cabangLayanan->pivot->harga : $this->harga;
}
```

## 🗄️ Database Schema

**Table:** `cabang_layanan` (Pivot Table)

| Column     | Type      | Description               |
| ---------- | --------- | ------------------------- |
| id         | bigint    | Primary key               |
| cabang_id  | bigint    | FK to cabangs             |
| layanan_id | bigint    | FK to layanans            |
| harga      | decimal   | Harga spesifik per cabang |
| status     | enum      | aktif/tidak_aktif         |
| created_at | timestamp |                           |
| updated_at | timestamp |                           |

**Unique Constraint:** `(cabang_id, layanan_id)`

## 🎨 UI/UX Design

### Section "Cabang & Harga Spesifik"

-   Background: `bg-blue-50` dengan border `border-blue-200`
-   Layout: Card per cabang dengan checkbox di kiri
-   Info cabang: Nama + alamat
-   Input harga: Hidden by default, muncul ketika checkbox checked
-   Placeholder: "Kosongkan untuk pakai harga base"

### Dynamic Behavior

```javascript
// When checkbox checked → Show input harga
// When checkbox unchecked → Hide input + clear value
function toggleHargaCabang(cabangId) {
    const checkbox = document.getElementById("cabang_" + cabangId);
    const hargaContainer = document.getElementById(
        "harga_container_" + cabangId
    );
    const hargaInput = document.getElementById("harga_cabang_" + cabangId);

    if (checkbox.checked) {
        hargaContainer.classList.remove("hidden");
    } else {
        hargaContainer.classList.add("hidden");
        hargaInput.value = "";
    }
}
```

## 📊 Data Flow

### Create Layanan Flow

```
1. User akses /kelola-layanan/create
   ↓
2. Controller fetch categories + cabangList
   ↓
3. Render form dengan dynamic cabang checkboxes
   ↓
4. User:
   - Isi nama, kategori, status, harga base, deskripsi
   - Ceklis cabang yang diinginkan
   - (Optional) Isi harga spesifik per cabang
   ↓
5. Submit form
   ↓
6. LayananRequest validate:
   - cabang_ids: required, array, min:1
   - cabang_ids.*: exists in cabangs
   - harga_cabang: nullable, array
   - harga_cabang.*: nullable, numeric
   ↓
7. LayananService::createLayanan():
   - Create layanan (nama, deskripsi, harga base, status, kategori_id)
   - Loop cabang_ids:
     * Jika ada harga_cabang[cabang_id] → use it
     * Jika tidak → use harga base
   - Sync ke pivot table cabang_layanan
   ↓
8. Redirect ke index dengan success message
```

## 🔄 Comparison: Sebelum vs Sesudah

### Sebelum

-   User hanya input 1 harga untuk semua cabang
-   Tidak ada pivot table
-   Tidak bisa set harga berbeda per cabang
-   Form hanya: nama, kategori, harga, status, deskripsi

### Sesudah

-   User pilih cabang mana saja yang tersedia layanan ini
-   Bisa set harga spesifik per cabang atau pakai harga base
-   Data disimpan di pivot table `cabang_layanan`
-   Form: nama, kategori, harga base, status, deskripsi, **cabang selection + harga spesifik**

## ✅ Testing Checklist

### Manual Testing

-   [ ] Akses `/kelola-layanan/create` → Form tampil dengan cabang list
-   [ ] Ceklis cabang tanpa isi harga spesifik → Harga base dipakai
-   [ ] Ceklis cabang dengan isi harga spesifik → Harga spesifik tersimpan
-   [ ] Submit tanpa ceklis cabang → Validation error "Minimal pilih 1 cabang"
-   [ ] Submit dengan harga spesifik non-numeric → Validation error
-   [ ] Submit valid → Data tersimpan, redirect ke index
-   [ ] Check database `cabang_layanan` → Data sesuai

### Validation Testing

```php
// Test Case 1: No cabang selected
'cabang_ids' => []
// Expected: "Minimal pilih 1 cabang."

// Test Case 2: Invalid cabang_id
'cabang_ids' => [999]
// Expected: "Cabang yang dipilih tidak valid."

// Test Case 3: Non-numeric harga
'harga_cabang' => ['1' => 'abc']
// Expected: "Harga cabang harus berupa angka."

// Test Case 4: Valid data
'cabang_ids' => [1, 2],
'harga_cabang' => ['1' => '50000', '2' => ''] // Cabang 2 pakai harga base
// Expected: Success
```

## 📝 Next Steps

### Immediate

1. **Test form create** dengan berbagai skenario
2. **Update form edit** dengan fitur yang sama
3. **Test form edit** untuk existing layanan

### Future Enhancements

-   [ ] Bulk import layanan dengan harga per cabang (Excel)
-   [ ] Validasi: Harga spesifik tidak boleh jauh berbeda dari harga base (warning)
-   [ ] History log perubahan harga per cabang
-   [ ] Copy harga dari cabang lain (shortcut)

## 🐛 Known Issues & Solutions

### Issue 1: Status value mismatch

**Problem:** Form use `tidak_aktif`, old validation use `nonaktif`
**Solution:** ✅ Updated validation to `in:aktif,tidak_aktif`

### Issue 2: Old input values tidak muncul setelah validation error

**Solution:** ✅ JavaScript initialization on DOMContentLoaded untuk restore checked state

## 📚 Related Files

**Modified:**

-   `resources/views/pages/kelola-layanan/create.blade.php`
-   `app/Http/Controllers/KelolaLayananController.php`
-   `app/Http/Requests/LayananRequest.php`
-   `app/Services/LayananService.php`

**Backup:**

-   `resources/views/pages/kelola-layanan/create-old.blade.php`

**Related:**

-   `app/Models/Layanan.php` (relationship already exists)
-   `database/migrations/*_create_cabang_layanan_table.php`
-   `resources/views/pages/kelola-layanan/index.blade.php` (show harga per cabang)

---

**Tanggal:** 2025
**Developer:** AI Assistant
**Status:** ✅ Implemented - Ready for Testing
