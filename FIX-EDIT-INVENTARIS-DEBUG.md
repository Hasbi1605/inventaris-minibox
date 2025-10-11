# Debug Guide - Edit Inventaris Tidak Bisa Submit

## Masalah

Form edit inventaris untuk produk dengan stok 0 tidak bisa disubmit (tidak terjadi apa-apa saat klik tombol submit).

## Langkah Debugging

### 1. Cek Browser Console

-   Buka halaman edit Hair Powder Minibox Balong (ID 9)
-   Tekan F12 atau Cmd+Option+I (Mac) untuk buka Developer Tools
-   Pilih tab "Console"
-   Coba ubah stok dan klik submit
-   Lihat apakah ada error JavaScript

### 2. Cek Network Request

-   Di Developer Tools, pilih tab "Network"
-   Coba submit form
-   Lihat apakah ada request POST ke `/kelola-inventaris/9`
-   Jika ada, klik request tersebut dan lihat:
    -   Status code (200, 302, 422, 500, dll)
    -   Response body
    -   Form Data yang dikirim

### 3. Cek Laravel Log

```bash
tail -f storage/logs/laravel.log
```

Lalu coba submit form dan lihat apakah ada log error atau validation error.

### 4. Temporary Fix - Disable JavaScript Validation

Jika masalah persisten, bisa temporary disable JavaScript dengan menambahkan di form:

```html
<form ... novalidate></form>
```

### 5. Cek Database

```bash
php artisan tinker
```

Lalu jalankan:

```php
DB::table('inventaris')->where('id', 9)->first();
```

Lihat data saat ini untuk memastikan nama_barang dan cabang_id.

## Kemungkinan Penyebab

1. **JavaScript Error** - Ada error di console yang mencegah form submit
2. **CSRF Token** - Token expired atau tidak valid
3. **Browser HTML5 Validation** - Browser mencegah submit karena field tidak valid
4. **Unique Validation** - Nama "Hair Powder" sudah ada di cabang yang sama
5. **Event Listener Conflict** - Ada multiple event listener yang conflict

## Solusi Sementara

Jika masih tidak bisa, coba:

1. Clear browser cache (Cmd+Shift+R di Mac, Ctrl+Shift+R di Windows)
2. Gunakan browser berbeda (Chrome, Firefox, Safari)
3. Disable extensions/add-ons browser yang mungkin interfere
