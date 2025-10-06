# Implementasi Tab Per Cabang - Kelola Layanan

**Tanggal:** 6 Oktober 2025  
**Status:** ✅ Selesai Diimplementasikan

## 📋 Ringkasan Perubahan

Mengikuti pola yang sama dengan **Kelola Inventaris** dan **Kelola Transaksi**, halaman Kelola Layanan telah diperbarui dengan sistem tab per cabang untuk mengelola harga layanan yang berbeda-beda di setiap cabang.

---

## 🎯 Masalah yang Diperbaiki

### **Sebelum:**

❌ **Tidak Ada Pengelompokan Per Cabang** - Semua layanan ditampilkan dalam satu tabel  
❌ **Harga Tidak Kontekstual** - Tidak terlihat harga spesifik per cabang  
❌ **Statistik Global** - Tidak ada statistik per cabang  
❌ **Filter Always Visible** - Filter menggunakan banyak ruang layar

### **Sesudah:**

✅ **Tab Per Cabang** - Layanan dikelompokkan berdasarkan cabang  
✅ **Harga Spesifik Per Cabang** - Menampilkan harga yang berbeda untuk setiap cabang  
✅ **Statistik Per Cabang** - Setiap tab memiliki statistik yang relevan  
✅ **Filter Collapsible** - Hemat ruang dan rapi

---

## 🚀 Fitur Baru

### 1. **Struktur Tab Per Cabang**

```
📁 Kelola Layanan
├─ 📋 Tab: Semua Cabang (Master Layanan)
│  └─ Semua layanan dengan harga base
│  └─ Indikator "Tersedia di X cabang"
│
├─ 📋 Tab: Minibox Balong
│  └─ Layanan aktif dengan harga spesifik cabang ini
│
├─ 📋 Tab: Minibox Krajen
│  └─ Layanan aktif dengan harga spesifik cabang ini
│
└─ 📋 Tab: Minibox Pandanaran
   └─ Layanan aktif dengan harga spesifik cabang ini
```

### 2. **Statistik Per Tab**

#### **Tab Semua Cabang:**

-   📊 Total Layanan (seluruh sistem)
-   ✅ Layanan Aktif (global)
-   💰 Rata-rata Harga (semua cabang)
-   🏢 Total Cabang

#### **Tab Per Cabang:**

-   📊 Total Layanan (di cabang tersebut)
-   ✅ Layanan Aktif (di cabang tersebut)
-   💰 Harga Tertinggi (di cabang tersebut)
-   💵 Harga Terendah (di cabang tersebut)

### 3. **Tabel dengan Informasi Kontekstual**

#### **Tab Semua Cabang:**

```
Nama Layanan | Kategori | Harga Base | Tersedia di | Status | Aksi
Hair Cut     | Potong   | Rp 35.000  | 3 cabang   | Aktif  | [👁️][✏️][🗑️]
```

#### **Tab Per Cabang:**

```
Nama Layanan | Kategori | Harga di Cabang Ini | Status di Cabang | Aksi
Hair Cut     | Potong   | Rp 40.000          | Aktif            | [👁️][✏️]
                         Base: Rp 35.000
```

### 4. **Collapsible Filter**

Filter dapat dibuka/tutup dengan:

-   ✅ Toggle button smooth animation
-   ✅ Indikator jumlah filter aktif
-   ✅ Layout 1 baris (3 field + buttons)

---

## 🔧 Perubahan Backend

### **1. LayananService.php - Method Baru**

#### **a. getLayananStatisticsByCabang($cabangId)**

```php
public function getLayananStatisticsByCabang($cabangId)
{
    $layananAktifCount = DB::table('cabang_layanan')
        ->where('cabang_id', $cabangId)
        ->where('status', 'aktif')
        ->count();

    $totalLayananCount = DB::table('cabang_layanan')
        ->where('cabang_id', $cabangId)
        ->count();

    $hargaStats = DB::table('cabang_layanan')
        ->where('cabang_id', $cabangId)
        ->where('status', 'aktif')
        ->selectRaw('MAX(harga) as max_harga, MIN(harga) as min_harga')
        ->first();

    return [
        'total' => $totalLayananCount,
        'aktif' => $layananAktifCount,
        'tidak_aktif' => $totalLayananCount - $layananAktifCount,
        'max_harga' => $hargaStats->max_harga ?? 0,
        'min_harga' => $hargaStats->min_harga ?? 0,
    ];
}
```

#### **b. getAllLayananWithCabang($filters, $perPage)**

```php
public function getAllLayananWithCabang(array $filters = [], $perPage = 10)
{
    $query = Layanan::query()->with(['kategori', 'cabangs']);

    // Apply filters...

    return $query->latest()->paginate($perPage);
}
```

#### **c. getLayananByCabang($cabangId, $filters, $perPage)**

```php
public function getLayananByCabang($cabangId, array $filters = [], $perPage = 10)
{
    $query = Layanan::query()
        ->with(['kategori', 'cabangs' => function($q) use ($cabangId) {
            $q->where('cabang_id', $cabangId);
        }])
        ->whereHas('cabangs', function($q) use ($cabangId) {
            $q->where('cabang_id', $cabangId);
        });

    // Apply filters...

    return $query->latest()->paginate($perPage);
}
```

### **2. KelolaLayananController.php - Method index() Updated**

```php
public function index(Request $request)
{
    $filters = $request->only(['search', 'kategori', 'status']);

    $cabangList = $this->cabangService->getAllCabangForDropdown();

    // Data untuk tab semua cabang
    $semuaLayanan = $this->layananService->getAllLayananWithCabang($filters);
    $statisticsSemuaCabang = $this->layananService->getLayananStatistics();

    // Data per cabang
    $layananPerCabang = [];
    $statisticsPerCabang = [];
    foreach ($cabangList as $cabang) {
        $layananPerCabang[$cabang->id] = $this->layananService->getLayananByCabang($cabang->id, $filters);
        $statisticsPerCabang[$cabang->id] = $this->layananService->getLayananStatisticsByCabang($cabang->id);
    }

    $categories = $this->layananService->getAvailableCategories();

    return view('pages.kelola-layanan.index', compact(
        'semuaLayanan',
        'layananPerCabang',
        'statisticsSemuaCabang',
        'statisticsPerCabang',
        'categories',
        'cabangList',
        'filters'
    ));
}
```

---

## 📁 Struktur File Baru

```
resources/views/pages/kelola-layanan/
├── index.blade.php              # File utama dengan tab
├── index-old.blade.php          # Backup file lama (sebelum tab)
├── index-backup.blade.php       # Backup sebelum replace
├── create.blade.php
├── edit.blade.php
├── show.blade.php
└── partials/
    ├── tab-semua-cabang.blade.php   # Tab untuk semua cabang
    └── tab-per-cabang.blade.php      # Tab untuk masing-masing cabang
```

---

## 🎨 Desain & UI/UX

### **Warna Gradient Kartu Statistik:**

#### **Tab Semua Cabang:**

1. **Total Layanan:** `from-green-600 to-lime-400` 🟢
2. **Layanan Aktif:** `from-blue-600 to-cyan-400` 🔵
3. **Rata-rata Harga:** `from-purple-600 to-pink-400` 🟣
4. **Total Cabang:** `from-yellow-600 to-orange-400` 🟡

#### **Tab Per Cabang:**

1. **Total Layanan:** `from-green-600 to-lime-400` 🟢
2. **Layanan Aktif:** `from-blue-600 to-cyan-400` 🔵
3. **Harga Tertinggi:** `from-purple-600 to-pink-400` 🟣
4. **Harga Terendah:** `from-yellow-600 to-orange-400` 🟡

---

## 📊 Struktur Data yang Dikirim ke View

```php
[
    'semuaLayanan' => Collection,           // Semua layanan dengan relasi cabang
    'layananPerCabang' => [
        1 => Collection,                    // Layanan di cabang 1
        2 => Collection,                    // Layanan di cabang 2
        ...
    ],
    'statisticsSemuaCabang' => [
        'total' => 15,
        'aktif' => 12,
        'avg_harga' => 35000,
        'total_cabang' => 3
    ],
    'statisticsPerCabang' => [
        1 => [
            'total' => 10,
            'aktif' => 8,
            'max_harga' => 50000,
            'min_harga' => 25000
        ],
        ...
    ],
    'categories' => Collection,             // List kategori layanan
    'cabangList' => Collection,             // List cabang
    'filters' => array                      // Filter aktif
]
```

---

## 🔍 Fitur Khusus Layanan

### **1. Indikator Cabang**

Di tab "Semua Cabang", setiap layanan menampilkan badge jumlah cabang:

```blade
<span class="inline-block px-3 py-1 text-xs font-semibold text-blue-600 bg-blue-100 rounded-full">
    {{ $item->cabangs->count() }} cabang
</span>
```

### **2. Perbandingan Harga**

Di tab per cabang, jika harga berbeda dari base, ditampilkan perbandingan:

```blade
Rp 40.000
Base: Rp 35.000
```

### **3. Status Per Cabang**

Setiap layanan bisa memiliki status berbeda di setiap cabang:

-   ✅ **Aktif** di Minibox Balong
-   ❌ **Tidak Aktif** di Minibox Krajen

---

## 🔄 JavaScript Functions

### **1. Toggle Filter**

```javascript
function toggleFilter() {
    const filterContent = document.getElementById("filter-content");
    const filterIcon = document.getElementById("filter-icon");

    if (filterContent.classList.contains("hidden")) {
        filterContent.classList.remove("hidden");
        filterIcon.classList.add("fa-chevron-up");
        filterIcon.classList.remove("fa-chevron-down");
    } else {
        filterContent.classList.add("hidden");
        filterIcon.classList.remove("fa-chevron-up");
        filterIcon.classList.add("fa-chevron-down");
    }
}
```

### **2. Tab Switching**

```javascript
function showCabangTab(cabangTab) {
    // Hide all tabs
    document.querySelectorAll('[id^="content-cabang-"]').forEach((content) => {
        content.classList.add("hidden");
    });

    // Remove active state
    document.querySelectorAll('[id^="tab-cabang-"]').forEach((tab) => {
        tab.classList.remove(
            "border-blue-600",
            "text-blue-600",
            "bg-white",
            "shadow-sm"
        );
        tab.classList.add("border-transparent", "text-gray-500");
    });

    // Show selected tab
    document
        .getElementById("content-cabang-" + cabangTab)
        .classList.remove("hidden");

    // Add active state
    const selectedTab = document.getElementById("tab-cabang-" + cabangTab);
    selectedTab.classList.remove("border-transparent", "text-gray-500");
    selectedTab.classList.add(
        "border-blue-600",
        "text-blue-600",
        "bg-white",
        "shadow-sm"
    );
}
```

---

## ✅ Checklist Implementasi

-   [x] Backup file lama (`index-old.blade.php`)
-   [x] Buat folder `partials/`
-   [x] Buat `tab-semua-cabang.blade.php`
-   [x] Buat `tab-per-cabang.blade.php`
-   [x] Update `index.blade.php` dengan collapsible filter
-   [x] Update controller untuk kirim data per cabang
-   [x] Tambah method `getLayananStatisticsByCabang()` di Service
-   [x] Tambah method `getAllLayananWithCabang()` di Service
-   [x] Tambah method `getLayananByCabang()` di Service
-   [x] Import `DB` facade di LayananService
-   [x] Inject `CabangService` di Controller
-   [x] Test UI/UX di browser
-   [x] Validasi tidak ada error
-   [x] Dokumentasi perubahan

---

## 🎯 Keuntungan Implementasi

### **1. Manajemen Harga Per Cabang**

-   Harga layanan bisa berbeda di setiap cabang
-   Mudah melihat perbandingan harga base vs cabang
-   Statistik harga tertinggi/terendah per cabang

### **2. Konsistensi UI/UX**

-   Pola yang sama dengan Inventaris & Transaksi
-   User familiar dengan navigasi
-   Pengalaman yang seamless

### **3. Statistik Kontekstual**

-   Statistik per cabang lebih relevan
-   Data lebih akurat dan spesifik
-   Memudahkan pengambilan keputusan

### **4. Efisiensi Ruang**

-   Filter collapsible hemat ruang
-   Tab mengelompokkan data dengan baik
-   Layout bersih dan proporsional

---

## 📱 Responsive Behavior

### **Desktop (≥1024px):**

-   Filter: 3 kolom + buttons
-   Statistik: 4 kolom grid
-   Tab: Horizontal scroll jika banyak cabang

### **Tablet (768px - 1023px):**

-   Filter: Tetap 3 kolom (lebih compact)
-   Statistik: 2 kolom grid
-   Tab: Horizontal scroll

### **Mobile (<768px):**

-   Filter: 1 kolom stack
-   Statistik: 1 kolom stack
-   Tab: Horizontal scroll dengan touch

---

## 🧪 Testing

### **Test Cases:**

1. ✅ Filter dapat dibuka/tutup dengan smooth animation
2. ✅ Indikator "X aktif" muncul saat ada filter
3. ✅ Tab switching berfungsi dengan baik
4. ✅ Statistik per cabang menampilkan data yang benar
5. ✅ Harga per cabang ditampilkan dengan benar
6. ✅ Badge "X cabang" muncul di tab Semua Cabang
7. ✅ Perbandingan harga base vs cabang terlihat
8. ✅ Status per cabang ditampilkan dengan benar
9. ✅ Pagination berfungsi di setiap tab
10. ✅ Alert auto-hide setelah 3 detik
11. ✅ Responsive di berbagai ukuran layar
12. ✅ Tidak ada error di console browser

---

## 📝 Database Schema

### **Tabel: `cabang_layanan`**

```sql
id              : bigint (PK)
cabang_id       : bigint (FK -> cabang.id)
layanan_id      : bigint (FK -> layanans.id)
harga           : decimal(10,2)    -- Harga spesifik per cabang
status          : enum('aktif', 'tidak_aktif')
created_at      : timestamp
updated_at      : timestamp

UNIQUE KEY (cabang_id, layanan_id)  -- Satu layanan hanya 1x per cabang
```

---

## 🔮 Future Improvements

Potensi peningkatan di masa depan:

1. **Bulk Edit Harga:** Edit harga multiple layanan sekaligus per cabang
2. **History Harga:** Track perubahan harga layanan dari waktu ke waktu
3. **Rekomendasi Harga:** AI-powered pricing recommendation
4. **Copy Harga:** Copy harga dari satu cabang ke cabang lain
5. **Quick Toggle Status:** Toggle aktif/tidak aktif layanan per cabang langsung dari tabel
6. **Export Report:** Export data layanan & harga per cabang ke Excel/PDF

---

## 💡 Catatan Penting

### **Relasi Many-to-Many**

-   Layanan bisa tersedia di banyak cabang
-   Setiap cabang bisa punya harga berbeda untuk layanan yang sama
-   Status layanan bisa berbeda per cabang

### **Harga Base vs Harga Cabang**

-   **Harga Base:** Harga default di tabel `layanans.harga`
-   **Harga Cabang:** Harga spesifik di tabel `cabang_layanan.harga`
-   Jika harga cabang ada, akan digunakan. Jika tidak, gunakan harga base.

---

## 👥 Credits

**Developer:** GitHub Copilot  
**Date:** 6 Oktober 2025  
**Version:** 1.0  
**Status:** Production Ready ✅

---

## 📞 Support

Jika ada masalah atau pertanyaan terkait implementasi ini, silakan dokumentasikan di issue tracker atau hubungi tim development.

---

**Catatan Akhir:** Implementasi ini mengikuti best practices Laravel dan modern UI/UX patterns. Struktur tab per cabang memudahkan manajemen layanan dengan harga berbeda di setiap lokasi barbershop. Semua perubahan telah ditest dan siap untuk production.
