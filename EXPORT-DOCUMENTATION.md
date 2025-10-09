# Dokumentasi Fitur Export Laporan

## 📋 Overview

Sistem export lengkap untuk laporan barbershop yang mendukung format PDF dan Excel dengan berbagai jenis laporan.

## 🎯 Fitur yang Telah Diimplementasikan

### 1. Export PDF Laporan Lengkap (Header Halaman)

**Lokasi Tombol:** Header halaman laporan (tombol merah-kuning "EXPORT PDF")

**Fungsi:**

-   Export semua laporan dalam satu dokumen PDF
-   Mencakup: Statistik, Gaji & Komisi Kapster, Per Cabang, Layanan
-   Format: PDF A4 Portrait
-   Otomatis menyesuaikan dengan filter aktif (bulan, tahun, cabang)

**Endpoint:** `GET /laporan/export-pdf`

**Parameter:**

-   `bulan` (required): Bulan laporan (1-12)
-   `tahun` (required): Tahun laporan
-   `cabang_id` (optional): ID cabang untuk filter

**Contoh URL:**

```
/laporan/export-pdf?bulan=10&tahun=2025
/laporan/export-pdf?bulan=10&tahun=2025&cabang_id=1
```

**Nama File Output:**

```
Laporan-Lengkap-10-2025.pdf
```

---

### 2. Export Excel Laporan (Header Halaman)

**Lokasi Tombol:** Header halaman laporan (tombol biru "EXPORT EXCEL")

**Fungsi:**

-   Export data laporan ke format Excel (.xlsx)
-   Otomatis detect tab aktif untuk menentukan tipe data
-   Format tabel dengan header berwarna biru
-   Auto-width untuk semua kolom
-   Border pada semua cell

**Endpoint:** `GET /laporan/export-excel`

**Parameter:**

-   `bulan` (required): Bulan laporan (1-12)
-   `tahun` (required): Tahun laporan
-   `type` (required): Tipe laporan (gaji-kapster, keuangan, cabang, layanan)
-   `cabang_id` (optional): ID cabang untuk filter

**Tipe Laporan:**

1. `gaji-kapster` - Laporan Gaji & Komisi Kapster
2. `keuangan` - Laporan Keuangan (Laba Rugi)
3. `cabang` - Laporan Performa Per Cabang
4. `layanan` - Laporan Layanan Terpopuler

**Contoh URL:**

```
/laporan/export-excel?bulan=10&tahun=2025&type=gaji-kapster
/laporan/export-excel?bulan=10&tahun=2025&type=cabang&cabang_id=1
```

**Nama File Output:**

```
Laporan-gaji-kapster-10-2025.xlsx
Laporan-cabang-10-2025.xlsx
```

---

### 3. Export Slip Gaji Individual (Tab Gaji & Komisi)

**Lokasi Tombol:** Kolom "AKSI" pada tabel Gaji & Komisi (tombol oranye dengan icon download)

**Fungsi:**

-   Generate slip gaji PDF untuk kapster tertentu
-   Mencakup: Info kapster, summary gaji, detail transaksi
-   Bagian signature untuk approval
-   Format professional dengan warna biru

**Endpoint:** `GET /laporan/slip-gaji/{kapster_id}`

**Parameter:**

-   `kapster_id` (required): ID kapster
-   `bulan` (required): Bulan laporan (1-12)
-   `tahun` (required): Tahun laporan

**Contoh URL:**

```
/laporan/slip-gaji/1?bulan=10&tahun=2025
/laporan/slip-gaji/2?bulan=10&tahun=2025
```

**Nama File Output:**

```
Slip-Gaji-Khusein-10-2025.pdf
Slip-Gaji-Panca-10-2025.pdf
```

**Isi Slip Gaji:**

1. Header dengan logo/judul
2. Info Kapster (nama, cabang, periode, tanggal cetak)
3. Summary Box:
    - Total Transaksi
    - Nilai Transaksi
    - Persentase Komisi
    - Gaji dari Komisi
    - **TOTAL GAJI** (highlight)
4. Detail Transaksi (tabel lengkap)
5. Bagian Signature (Kapster & Pemilik/Manager)
6. Footer dengan timestamp

---

### 4. Export Semua Slip Gaji (Tab Gaji & Komisi)

**Lokasi Tombol:** Header tab Gaji & Komisi (tombol biru "EXPORT SEMUA SLIP")

**Fungsi:**

-   Generate slip gaji PDF untuk SEMUA kapster
-   Otomatis dikompres dalam file ZIP
-   Masing-masing slip dalam file PDF terpisah
-   Loading indicator saat proses

**Endpoint:** `GET /laporan/export-all-slip`

**Parameter:**

-   `bulan` (required): Bulan laporan (1-12)
-   `tahun` (required): Tahun laporan
-   `cabang_id` (optional): ID cabang untuk filter

**Contoh URL:**

```
/laporan/export-all-slip?bulan=10&tahun=2025
/laporan/export-all-slip?bulan=10&tahun=2025&cabang_id=1
```

**Nama File Output:**

```
Slip-Gaji-Semua-10-2025.zip
```

**Isi ZIP:**

```
Slip-Gaji-Semua-10-2025.zip
├── Slip-Gaji-Khusein.pdf
├── Slip-Gaji-Panca.pdf
├── Slip-Gaji-Andi.pdf
└── Slip-Gaji-Budi.pdf
```

---

## 🛠️ Teknologi yang Digunakan

### 1. DomPDF (barryvdh/laravel-dompdf v3.1.1)

**Untuk:** Generate PDF dari HTML/Blade templates

**Fitur:**

-   Convert HTML ke PDF
-   Support CSS styling
-   Custom page size dan orientation
-   Font embedding

**Config:** `config/dompdf.php`

### 2. Maatwebsite Excel (maatwebsite/excel v3.1.67)

**Untuk:** Generate Excel files dengan format tabel

**Fitur:**

-   Export collection ke Excel
-   Custom headers dan styling
-   Multiple sheets support
-   Cell formatting (border, color, alignment)

**Config:** `config/excel.php`

---

## 📁 Struktur File

### Controllers

```
app/Http/Controllers/LaporanController.php
├── index()                    # Display laporan page
├── exportSlipGaji()           # Export single slip PDF
├── exportAllSlipGaji()        # Export all slips ZIP
├── exportLaporanPDF()         # Export full report PDF
└── exportLaporanExcel()       # Export data to Excel
```

### Exports

```
app/Exports/LaporanExport.php
├── collection()               # Get data
├── headings()                # Table headers
├── map()                     # Format data
├── styles()                  # Apply Excel styling
└── title()                   # Sheet title
```

### Views (PDF Templates)

```
resources/views/pages/laporan/pdf/
├── slip-gaji.blade.php       # Template slip gaji individual
└── laporan-lengkap.blade.php # Template laporan lengkap
```

### Routes

```
routes/web.php
├── GET /laporan/slip-gaji/{kapster}    # Single slip PDF
├── GET /laporan/export-all-slip        # All slips ZIP
├── GET /laporan/export-pdf             # Full report PDF
└── GET /laporan/export-excel           # Data to Excel
```

---

## 🎨 Styling PDF

### Slip Gaji

-   **Font:** Arial
-   **Primary Color:** #2563eb (Blue)
-   **Background:** #f8fafc (Light gray)
-   **Border:** #cbd5e1 (Gray)
-   **Size:** A4 Portrait

**Sections:**

1. Header (center, blue border bottom)
2. Info Section (2 columns layout)
3. Summary Box (colored background with blue border)
4. Transaction Table (striped rows)
5. Signature Section (2 columns)
6. Footer (center, small text)

### Laporan Lengkap

-   **Font:** Arial
-   **Primary Color:** #2563eb (Blue)
-   **Size:** A4 Portrait
-   **Multi-page:** Yes (automatic page breaks)

**Sections:**

1. Header (center)
2. Statistics Grid (4 boxes)
3. Multiple report sections (each with title)
4. Data tables (blue headers)
5. Footer

---

## 💡 Cara Penggunaan

### 1. Export PDF Laporan Lengkap

```javascript
// Klik tombol "EXPORT PDF" di header
// Akan mendownload PDF dengan nama: Laporan-Lengkap-{bulan}-{tahun}.pdf
```

### 2. Export Excel Laporan

```javascript
// Buka tab yang ingin diexport (Gaji & Komisi, Laba Rugi, Per Cabang, atau Layanan)
// Klik tombol "EXPORT EXCEL" di header
// Akan mendownload Excel dengan nama: Laporan-{type}-{bulan}-{tahun}.xlsx
```

### 3. Export Slip Gaji Individual

```javascript
// Pada tabel Gaji & Komisi
// Klik icon download (oranye) di kolom "AKSI" pada baris kapster
// Akan mendownload PDF dengan nama: Slip-Gaji-{nama_kapster}-{bulan}-{tahun}.pdf
```

### 4. Export Semua Slip Gaji

```javascript
// Pada tab Gaji & Komisi
// Klik tombol "EXPORT SEMUA SLIP" di header tab
// Akan mendownload ZIP dengan nama: Slip-Gaji-Semua-{bulan}-{tahun}.zip
// Loading indicator akan muncul selama proses (± 3 detik)
```

---

## 🔧 Konfigurasi

### DomPDF Configuration

File: `config/dompdf.php`

```php
return [
    'show_warnings' => false,
    'public_path' => null,
    'convert_entities' => true,
    'options' => [
        'font_dir' => storage_path('fonts/'),
        'font_cache' => storage_path('fonts/'),
        'temp_dir' => sys_get_temp_dir(),
        'enable_font_subsetting' => false,
        'pdf_backend' => 'CPDF',
        'default_media_type' => 'screen',
        'default_paper_size' => 'a4',
        'default_paper_orientation' => 'portrait',
        'default_font' => 'serif',
        'dpi' => 96,
        'enable_php' => false,
        'enable_javascript' => true,
        'enable_remote' => true,
        'font_height_ratio' => 1.1,
        'enable_html5_parser' => true,
    ],
];
```

### Excel Configuration

File: `config/excel.php`

Key settings:

-   **Cache:** File cache for large exports
-   **Chunk Size:** 1000 rows
-   **Transaction:** Enable database transactions

---

## 📊 Format Data Export

### Excel - Gaji Kapster

| No  | Nama Kapster | Cabang | Total Transaksi | Nilai Transaksi | Persentase Komisi | Gaji Komisi | Total Gaji |
| --- | ------------ | ------ | --------------- | --------------- | ----------------- | ----------- | ---------- |

### Excel - Keuangan

| No  | Tanggal | Jenis | Kategori | Deskripsi | Debit | Kredit | Saldo |
| --- | ------- | ----- | -------- | --------- | ----- | ------ | ----- |

### Excel - Cabang

| No  | Nama Cabang | Total Transaksi | Total Pendapatan | Total Pengeluaran | Laba Bersih | Persentase Kontribusi |
| --- | ----------- | --------------- | ---------------- | ----------------- | ----------- | --------------------- |

### Excel - Layanan

| No  | Nama Layanan | Kategori | Jumlah Transaksi | Total Pendapatan | Rata-rata per Transaksi |
| --- | ------------ | -------- | ---------------- | ---------------- | ----------------------- |

---

## 🚀 Performance

### Optimizations

1. **Lazy Loading:** Data dimuat on-demand
2. **Chunking:** Excel export menggunakan chunks untuk data besar
3. **Caching:** Font dan config di-cache
4. **Compression:** ZIP untuk multiple PDFs
5. **Temp Files:** Otomatis dihapus setelah download

### Recommendations

-   Export all slips: Maksimal 50 kapster per batch
-   Excel export: Maksimal 10,000 rows per sheet
-   PDF generation: Timeout 60 seconds

---

## 🐛 Troubleshooting

### Error: "Class 'ZipArchive' not found"

**Solusi:**

```bash
# Install PHP ZIP extension
brew install php-zip  # macOS
apt-get install php-zip  # Ubuntu
```

### Error: "Failed to load PDF document"

**Solusi:**

1. Check permissions di `storage/app/temp/`
2. Pastikan DomPDF config sudah publish
3. Clear cache: `php artisan config:clear`

### Error: "Memory limit exceeded"

**Solusi:**
Tingkatkan memory limit di `php.ini`:

```ini
memory_limit = 256M
```

### Export ZIP kosong

**Solusi:**

1. Check apakah ada data di periode yang dipilih
2. Pastikan folder `storage/app/temp/` exists dan writable
3. Check log di `storage/logs/laravel.log`

---

## 📝 Notes

### Filter Behavior

-   Semua export akan **otomatis menggunakan filter** yang aktif di halaman
-   Filter yang tersedia: Bulan, Tahun, Cabang
-   Filter bulan/tahun: Default = bulan/tahun sekarang
-   Filter cabang: Default = semua cabang

### File Naming Convention

```
Laporan-Lengkap-{bulan}-{tahun}.pdf
Laporan-{type}-{bulan}-{tahun}.xlsx
Slip-Gaji-{nama_kapster}-{bulan}-{tahun}.pdf
Slip-Gaji-Semua-{bulan}-{tahun}.zip
```

### Auto-cleanup

-   ZIP files: Otomatis dihapus setelah download
-   Temp PDFs: Cleanup manual tidak diperlukan
-   Browser downloads: Sesuai setting browser

---

## 🎯 Testing Checklist

-   [x] Export PDF Laporan Lengkap
-   [x] Export Excel (4 tipe laporan)
-   [x] Export Slip Gaji Individual
-   [x] Export Semua Slip Gaji (ZIP)
-   [x] Filter bulan/tahun apply ke export
-   [x] Filter cabang apply ke export
-   [x] Loading indicator pada export all
-   [x] Error handling untuk data kosong
-   [x] File naming convention
-   [x] Auto-cleanup temp files

---

## 📚 Dependencies

```json
{
    "require": {
        "barryvdh/laravel-dompdf": "^3.1",
        "maatwebsite/excel": "^3.1",
        "php": "^8.2",
        "ext-zip": "*"
    }
}
```

---

## 📞 Support

Untuk pertanyaan atau issue terkait export:

1. Check log di `storage/logs/laravel.log`
2. Verify routes dengan `php artisan route:list --name=laporan`
3. Test API endpoint dengan Postman/Insomnia
4. Check browser console untuk JavaScript errors

---

**Last Updated:** October 9, 2025
**Version:** 1.0.0
**Status:** ✅ Production Ready
