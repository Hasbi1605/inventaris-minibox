# Dashboard Auto-Reset Setiap Hari Jam 00:00 WIB

## Implementasi

Dashboard akan otomatis reset setiap hari di jam 00:00 WIB untuk memastikan data harian selalu fresh dan akurat.

## Konfigurasi

### 1. Timezone Configuration (`config/app.php`)

```php
'timezone' => 'Asia/Jakarta',
```

**Perubahan:**

-   Timezone aplikasi diubah dari `UTC` ke `Asia/Jakarta` (WIB)
-   Semua operasi tanggal/waktu di aplikasi akan menggunakan WIB

### 2. Console Command (`app/Console/Commands/ClearDashboardCache.php`)

**Fungsi:**

-   Menghapus semua cache yang terkait dengan dashboard
-   Logging setiap kali cache dibersihkan
-   Dapat dijalankan manual atau via scheduler

**Cache yang dibersihkan:**

-   `dashboard_statistics`
-   `dashboard_grafik_pendapatan`
-   `dashboard_pengeluaran`
-   `dashboard_layanan_terlaris`
-   `dashboard_performa_cabang`
-   `dashboard_transaksi_terakhir`
-   `dashboard_alerts`
-   `dashboard_target_achievement`
-   `dashboard_top_kapster`
-   `dashboard_cash_flow`
-   `dashboard_daily_pattern`
-   `dashboard_profit_margin`
-   `dashboard_weekly_comparison`
-   `dashboard_kapster_utilization`

**Manual Command:**

```bash
php artisan dashboard:clear-cache
```

### 3. Scheduled Task (`routes/console.php`)

**Konfigurasi:**

```php
Schedule::command('dashboard:clear-cache')
    ->dailyAt('00:00')
    ->timezone('Asia/Jakarta')
    ->name('Clear Dashboard Cache')
    ->description('Reset dashboard data setiap hari jam 00:00 WIB')
    ->onSuccess(function () {
        Log::info('Dashboard cache cleared successfully via scheduler');
    })
    ->onFailure(function () {
        Log::error('Dashboard cache clear failed via scheduler');
    });
```

**Penjelasan:**

-   Berjalan setiap hari jam **00:00 WIB**
-   Menggunakan timezone `Asia/Jakarta`
-   Log success/failure untuk monitoring
-   Nama task: "Clear Dashboard Cache"

## Setup Scheduler di Server

### Untuk Development (Local)

Jalankan scheduler secara manual untuk testing:

```bash
php artisan schedule:run
```

Atau jalankan scheduler worker yang akan terus berjalan:

```bash
php artisan schedule:work
```

### Untuk Production (Server)

Tambahkan cron job di server (crontab):

```bash
# Edit crontab
crontab -e

# Tambahkan baris berikut
* * * * * cd /path/to/inventaris-barbershop && php artisan schedule:run >> /dev/null 2>&1
```

**Catatan:**

-   Ganti `/path/to/inventaris-barbershop` dengan path aplikasi Anda
-   Cron job ini berjalan setiap menit, tapi Laravel scheduler yang menentukan kapan command dijalankan
-   Tidak perlu worry, Laravel hanya akan execute command di jam 00:00 WIB saja

### Untuk Herd/Laravel Valet (macOS)

Scheduler sudah berjalan otomatis, tidak perlu setup tambahan.

## Verifikasi

### 1. Cek Schedule List

```bash
php artisan schedule:list
```

Output yang diharapkan:

```
0 0 * * * ............. dashboard:clear-cache .............. Next Due: 14 hours from now
```

### 2. Test Manual Run

```bash
php artisan dashboard:clear-cache
```

Output yang diharapkan:

```
✅ Dashboard cache cleared successfully at 2025-10-10 00:00:00 WIB
```

### 3. Cek Log File

```bash
tail -f storage/logs/laravel.log
```

Cari entry seperti:

```
[2025-10-10 00:00:00] local.INFO: Dashboard cache cleared successfully at 2025-10-10 00:00:00 WIB
[2025-10-10 00:00:01] local.INFO: Dashboard cache cleared successfully via scheduler
```

## Cara Kerja

### Alur Proses:

1. **Jam 00:00:00 WIB** → Laravel Scheduler mendeteksi waktu
2. **Command Execute** → `dashboard:clear-cache` dijalankan
3. **Clear Cache** → Semua cache dashboard dihapus
4. **Log Success** → Catat ke log file
5. **User Access** → Ketika user akses dashboard, data fresh di-generate ulang

### Timeline Harian:

```
23:59:59 WIB → Data hari kemarin masih di-cache
00:00:00 WIB → Scheduler trigger, cache cleared
00:00:01 WIB → Cache kosong, siap untuk hari baru
08:00:00 WIB → User akses dashboard, data hari ini di-generate
```

## Troubleshooting

### Scheduler tidak berjalan?

**1. Cek apakah scheduler running:**

```bash
php artisan schedule:list
```

**2. Test manual:**

```bash
php artisan dashboard:clear-cache
```

**3. Cek cron job (production):**

```bash
crontab -l
```

**4. Cek log:**

```bash
tail -100 storage/logs/laravel.log | grep "dashboard"
```

### Cache masih ada setelah reset?

**1. Clear all cache:**

```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

**2. Restart queue worker (jika pakai queue):**

```bash
php artisan queue:restart
```

### Timezone tidak sesuai?

**1. Verifikasi timezone di config:**

```bash
php artisan tinker
>>> config('app.timezone')
=> "Asia/Jakarta"
```

**2. Verifikasi timezone sistem:**

```bash
php artisan tinker
>>> now()->timezone
=> "Asia/Jakarta"
>>> now()->format('Y-m-d H:i:s T')
=> "2025-10-10 00:00:00 WIB"
```

## Monitoring

### Log Dashboard Cache Clears

Setiap cache clear akan tercatat di `storage/logs/laravel.log`:

```
[2025-10-10 00:00:00] local.INFO: Dashboard cache cleared successfully at 2025-10-10 00:00:00 WIB
[2025-10-10 00:00:01] local.INFO: Dashboard cache cleared successfully via scheduler
```

### Monitoring Command

Untuk monitoring real-time:

```bash
tail -f storage/logs/laravel.log | grep "dashboard"
```

## File yang Dimodifikasi

1. ✅ `config/app.php` - Timezone changed to Asia/Jakarta
2. ✅ `app/Console/Commands/ClearDashboardCache.php` - New command created
3. ✅ `routes/console.php` - Scheduled task configured

## Testing

### Test Timezone:

```bash
php artisan tinker
>>> now()
>>> now()->timezone
>>> now()->format('Y-m-d H:i:s T')
```

### Test Command:

```bash
php artisan dashboard:clear-cache
```

### Test Schedule:

```bash
php artisan schedule:list
php artisan schedule:run
```

## Benefits

✅ **Data Selalu Fresh**: Dashboard reset otomatis setiap hari
✅ **Performa Optimal**: Cache cleared di jam sepi (00:00)
✅ **Timezone Akurat**: Menggunakan WIB, sesuai lokasi Indonesia
✅ **Auto-Logging**: Semua aktivitas tercatat di log
✅ **Easy Monitoring**: Dapat dipantau via log file
✅ **Manual Override**: Bisa di-clear manual jika perlu

## Notes

-   Scheduler harus running di background (via cron atau supervisor)
-   Cache akan auto-regenerate ketika user mengakses dashboard
-   Tidak mempengaruhi data di database, hanya cache
-   Timezone WIB = UTC+7
-   Safe untuk production environment
