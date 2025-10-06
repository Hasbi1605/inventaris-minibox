# Update: Remove Deskripsi & Implement Dynamic Form di Edit Layanan

## 📋 Changes Overview

### 1. **Hapus Field Deskripsi di Create Layanan** ✅

Field deskripsi dihapus dari form create karena tidak diperlukan.

### 2. **Update Edit Layanan dengan Dynamic Cabang Selection** ✅

Form edit layanan sekarang sama seperti create layanan dengan fitur:

-   Dynamic cabang selection dengan checkbox
-   Input harga spesifik per cabang
-   Pre-fill data existing (cabang yang sudah dipilih & harga per cabang)

---

## 🔧 Implementation Details

### 1. Remove Deskripsi Field from Create Form

**File:** `resources/views/pages/kelola-layanan/create.blade.php`

**Removed Section:**

```blade
<!-- Deskripsi -->
<div class="col-span-1 lg:col-span-2">
    <label for="deskripsi">Deskripsi</label>
    <textarea name="deskripsi" id="deskripsi" rows="4"></textarea>
</div>
```

**Before:** Form memiliki 6 fields (nama, kategori, status, harga, deskripsi, cabang)
**After:** Form memiliki 5 fields (nama, kategori, status, harga, cabang)

---

### 2. Complete Rewrite of Edit Form

**File:** `resources/views/pages/kelola-layanan/edit.blade.php`

**Backup Created:** `edit-old.blade.php`

#### Key Features:

**A. Pre-fill Existing Data**

```php
@php
    $selectedCabangIds = old('cabang_ids', $layanan->cabangs->pluck('id')->toArray());
    $oldHargaCabang = old('harga_cabang', []);
@endphp

@foreach($cabangList as $cabang)
@php
    $isChecked = in_array($cabang->id, $selectedCabangIds);
    $existingHarga = $layanan->cabangs->where('id', $cabang->id)->first();
    $hargaCabang = $oldHargaCabang[$cabang->id] ?? ($existingHarga ? $existingHarga->pivot->harga : '');
@endphp
```

**Logic:**

1. Get selected cabang IDs from old input OR existing layanan->cabangs
2. For each cabang, check if it's selected
3. Get existing harga from pivot table
4. Use old input harga if validation fails, otherwise use existing harga

**B. Dynamic Checkbox with Pre-checked State**

```blade
<input
    type="checkbox"
    name="cabang_ids[]"
    id="cabang_{{ $cabang->id }}"
    value="{{ $cabang->id }}"
    {{ $isChecked ? 'checked' : '' }}
/>
```

**C. Dynamic Harga Input with Existing Value**

```blade
<div id="harga_container_{{ $cabang->id }}" class="mt-3 {{ $isChecked ? '' : 'hidden' }}">
    <input
        type="number"
        name="harga_cabang[{{ $cabang->id }}]"
        value="{{ $hargaCabang }}"
        placeholder="Kosongkan untuk pakai harga base"
    />
</div>
```

**D. JavaScript for Toggle & Initialization**

```javascript
// Toggle on checkbox change
function toggleHargaCabang(cabangId) {
    const checkbox = document.getElementById("cabang_" + cabangId);
    const hargaContainer = document.getElementById(
        "harga_container_" + cabangId
    );

    if (checkbox.checked) {
        hargaContainer.classList.remove("hidden");
    } else {
        hargaContainer.classList.add("hidden");
    }
}

// Initialize on page load
document.addEventListener("DOMContentLoaded", function () {
    const checkboxes = document.querySelectorAll(".cabang-checkbox");
    checkboxes.forEach(function (checkbox) {
        if (checkbox.checked) {
            const cabangId = checkbox.value;
            const hargaContainer = document.getElementById(
                "harga_container_" + cabangId
            );
            hargaContainer.classList.remove("hidden");
        }
    });
});
```

---

### 3. Update Controller Edit Method

**File:** `app/Http/Controllers/KelolaLayananController.php`

**Before:**

```php
public function edit(string $id)
{
    $layanan = Layanan::findOrFail($id);
    $categories = $this->layananService->getAvailableCategories();
    return view('pages.kelola-layanan.edit', compact('layanan', 'categories'));
}
```

**After:**

```php
public function edit(string $id)
{
    $layanan = Layanan::with('cabangs')->findOrFail($id);
    $categories = $this->layananService->getAvailableCategories();
    $cabangList = $this->cabangService->getAllCabangForDropdown();
    return view('pages.kelola-layanan.edit', compact('layanan', 'categories', 'cabangList'));
}
```

**Changes:**

-   ✅ Added `with('cabangs')` to eager load relationship
-   ✅ Added `$cabangList` to get all available cabangs
-   ✅ Pass `cabangList` to view

---

### 4. Update Service Update Method

**File:** `app/Services/LayananService.php`

**Before:**

```php
public function updateLayanan(array $data, Layanan $layanan)
{
    $layanan->update($data);
    return $layanan;
}
```

**After:**

```php
public function updateLayanan(array $data, Layanan $layanan)
{
    // Separate cabang data
    $cabangIds = $data['cabang_ids'] ?? [];
    $hargaCabang = $data['harga_cabang'] ?? [];

    // Remove cabang fields from main data
    unset($data['cabang_ids'], $data['harga_cabang']);

    // Update layanan
    $layanan->update($data);

    // Sync cabangs with specific prices
    $syncData = [];
    foreach ($cabangIds as $cabangId) {
        $syncData[$cabangId] = [
            'harga' => isset($hargaCabang[$cabangId]) && !empty($hargaCabang[$cabangId])
                ? $hargaCabang[$cabangId]
                : $data['harga'],
            'status' => $data['status']
        ];
    }

    $layanan->cabangs()->sync($syncData);

    return $layanan;
}
```

**Logic:**

1. Extract cabang_ids & harga_cabang from request
2. Remove them from main data array
3. Update layanan main fields (nama, kategori, harga, status)
4. Build sync data array with harga per cabang
5. Use `sync()` to update pivot table (removes old, adds new)

**Important:** `sync()` will:

-   Add new cabangs that are checked
-   Remove cabangs that are unchecked
-   Update harga for existing cabangs

---

## 📊 Data Flow Comparison

### Create Flow:

```
1. User fills form (nama, kategori, status, harga, cabang)
2. Submit → LayananRequest validation
3. LayananService::createLayanan()
   - Create layanan record
   - Sync cabangs with harga to pivot table
4. Redirect to index with success message
```

### Edit Flow:

```
1. User clicks Edit → Load existing data
2. Controller fetches:
   - Layanan with cabangs relationship
   - Categories
   - All cabang list
3. View displays:
   - Pre-filled fields
   - Pre-checked cabangs
   - Existing harga per cabang
4. User modifies data
5. Submit → LayananRequest validation
6. LayananService::updateLayanan()
   - Update layanan record
   - Sync cabangs (add/remove/update pivot table)
7. Redirect to index with success message
```

---

## 🎯 User Experience

### Before:

**Create:**

-   ✅ Has dynamic cabang selection
-   ❌ Has deskripsi field (not needed)

**Edit:**

-   ❌ No cabang selection (can't change cabangs)
-   ❌ No per-cabang pricing (can't update)
-   ✅ Has deskripsi field

### After:

**Create:**

-   ✅ Has dynamic cabang selection
-   ✅ No deskripsi field (cleaner)

**Edit:**

-   ✅ Has dynamic cabang selection (same as create)
-   ✅ Shows existing selected cabangs
-   ✅ Shows existing harga per cabang
-   ✅ Can add/remove cabangs
-   ✅ Can update harga per cabang
-   ✅ No deskripsi field (consistency)

---

## ✅ Validation

### Test Scenarios:

**Create Layanan:**

1. ✅ Fill all fields → Success
2. ✅ Select 1 cabang without harga → Uses harga base
3. ✅ Select multiple cabangs with mixed harga → Correct
4. ✅ Validation error → Old input persists

**Edit Layanan:**

1. ✅ Load existing layanan → Pre-filled correctly
2. ✅ Checkboxes pre-checked for existing cabangs
3. ✅ Existing harga shown in inputs
4. ✅ Uncheck cabang → Removes from pivot
5. ✅ Check new cabang → Adds to pivot
6. ✅ Update harga → Pivot updated
7. ✅ Validation error → Old input persists

---

## 📚 Files Modified

**Views:**

-   ✅ `resources/views/pages/kelola-layanan/create.blade.php` - Removed deskripsi
-   ✅ `resources/views/pages/kelola-layanan/edit.blade.php` - Complete rewrite

**Controllers:**

-   ✅ `app/Http/Controllers/KelolaLayananController.php` - Updated edit() method

**Services:**

-   ✅ `app/Services/LayananService.php` - Updated updateLayanan() method

**Backups:**

-   ✅ `resources/views/pages/kelola-layanan/edit-old.blade.php`

---

## 🔍 Key Differences: Create vs Edit

| Aspect           | Create            | Edit                |
| ---------------- | ----------------- | ------------------- |
| Form Fields      | Same              | Same                |
| Cabang Selection | Empty checkboxes  | Pre-checked from DB |
| Harga Input      | Hidden by default | Visible if checked  |
| Harga Value      | Empty             | From pivot table    |
| Submit Method    | POST              | PUT                 |
| Service Method   | createLayanan()   | updateLayanan()     |
| Pivot Action     | Insert new        | Sync (update)       |

---

**Date:** October 6, 2025
**Status:** ✅ Completed & Tested
