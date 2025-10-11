# Implementasi Sistem Komisi Kapster

## Struktur Komisi

### Komisi Berdasarkan Kategori Layanan:

1. **40%** - Layanan kategori "Potong Rambut"
2. **25%** - Layanan kategori lain (Creambath, Toning, Smoothing, dll)
3. **25%** - Penjualan produk retail

---

## Opsi Implementasi

### **OPSI 1: Simple Settings-Based (RECOMMENDED)** ⭐

**Pros:**

-   ✅ Implementasi cepat
-   ✅ Mudah maintenance
-   ✅ Bisa diubah via dashboard
-   ✅ Tidak perlu migrasi kompleks

**Cons:**

-   ⚠️ Komisi sama untuk semua kapster di kategori yang sama

#### **Step 1: Create Settings Model & Migration**

```bash
php artisan make:model Setting -m
```

**Migration:**

```php
// database/migrations/xxxx_create_settings_table.php
public function up()
{
    Schema::create('settings', function (Blueprint $table) {
        $table->id();
        $table->string('key')->unique();
        $table->text('value');
        $table->string('group')->default('general'); // 'komisi', 'general', dll
        $table->string('type')->default('string'); // 'string', 'number', 'boolean'
        $table->text('description')->nullable();
        $table->timestamps();
    });

    // Insert default komisi settings
    DB::table('settings')->insert([
        [
            'key' => 'komisi_potong_rambut',
            'value' => '40',
            'group' => 'komisi',
            'type' => 'number',
            'description' => 'Persentase komisi untuk layanan kategori Potong Rambut',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'key' => 'komisi_layanan_lain',
            'value' => '25',
            'group' => 'komisi',
            'type' => 'number',
            'description' => 'Persentase komisi untuk layanan kategori selain Potong Rambut',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'key' => 'komisi_produk',
            'value' => '25',
            'group' => 'komisi',
            'type' => 'number',
            'description' => 'Persentase komisi untuk penjualan produk retail',
            'created_at' => now(),
            'updated_at' => now(),
        ],
    ]);
}
```

**Model:**

```php
// app/Models/Setting.php
class Setting extends Model
{
    protected $fillable = ['key', 'value', 'group', 'type', 'description'];

    // Helper method
    public static function get($key, $default = null)
    {
        $setting = self::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }

    public static function set($key, $value)
    {
        return self::updateOrCreate(['key' => $key], ['value' => $value]);
    }
}
```

#### **Step 2: Add Field to Kategori Table**

```php
// Migration
php artisan make:migration add_komisi_type_to_kategoris_table

public function up()
{
    Schema::table('kategoris', function (Blueprint $table) {
        $table->enum('komisi_type', ['potong_rambut', 'layanan_lain'])
              ->default('layanan_lain')
              ->after('tipe_penggunaan');
    });

    // Update existing data - set "Potong Rambut" kategori
    DB::table('kategoris')
        ->where('nama_kategori', 'LIKE', '%Potong%Rambut%')
        ->orWhere('nama_kategori', 'LIKE', '%Haircut%')
        ->update(['komisi_type' => 'potong_rambut']);
}
```

#### **Step 3: Create Komisi Service**

```php
// app/Services/KomisiService.php
<?php

namespace App\Services;

use App\Models\Setting;
use App\Models\Transaksi;
use App\Models\Kapster;
use Illuminate\Support\Facades\DB;

class KomisiService
{
    /**
     * Hitung komisi untuk satu transaksi
     */
    public function hitungKomisiTransaksi(Transaksi $transaksi)
    {
        $komisi = 0;

        // 1. Komisi dari layanan
        if ($transaksi->layanan) {
            $kategori = $transaksi->layanan->kategori;

            if ($kategori) {
                $persenKomisi = $kategori->komisi_type === 'potong_rambut'
                    ? Setting::get('komisi_potong_rambut', 40)
                    : Setting::get('komisi_layanan_lain', 25);

                // Hitung komisi dari harga layanan
                $hargaLayanan = $transaksi->layanan->getHargaForCabang($transaksi->cabang_id);
                $komisi += ($hargaLayanan * $persenKomisi / 100);
            }
        }

        // 2. Komisi dari produk
        if ($transaksi->produk && $transaksi->produk->count() > 0) {
            $persenKomisiProduk = Setting::get('komisi_produk', 25);

            foreach ($transaksi->produk as $produk) {
                $subtotal = $produk->pivot->subtotal;
                $komisi += ($subtotal * $persenKomisiProduk / 100);
            }
        }

        return round($komisi, 2);
    }

    /**
     * Hitung total komisi kapster dalam periode
     */
    public function hitungKomisiKapster($kapsterId, $startDate, $endDate)
    {
        $transaksis = Transaksi::where('kapster_id', $kapsterId)
            ->whereBetween('tanggal_transaksi', [$startDate, $endDate])
            ->where('status', 'selesai')
            ->with(['layanan.kategori', 'produk'])
            ->get();

        $totalKomisi = 0;
        $detail = [];

        foreach ($transaksis as $transaksi) {
            $komisiTransaksi = $this->hitungKomisiTransaksi($transaksi);
            $totalKomisi += $komisiTransaksi;

            $detail[] = [
                'transaksi_id' => $transaksi->id,
                'nomor_transaksi' => $transaksi->nomor_transaksi,
                'tanggal' => $transaksi->tanggal_transaksi,
                'total_harga' => $transaksi->total_harga,
                'komisi' => $komisiTransaksi,
            ];
        }

        return [
            'total_komisi' => $totalKomisi,
            'jumlah_transaksi' => $transaksis->count(),
            'detail' => $detail,
        ];
    }

    /**
     * Get komisi settings untuk display
     */
    public function getKomisiSettings()
    {
        return [
            'potong_rambut' => Setting::get('komisi_potong_rambut', 40),
            'layanan_lain' => Setting::get('komisi_layanan_lain', 25),
            'produk' => Setting::get('komisi_produk', 25),
        ];
    }
}
```

#### **Step 4: Update Laporan Gaji Kapster**

```php
// Di LaporanController atau GajiKapsterController

public function gajiKapster(Request $request)
{
    $kapsterId = $request->kapster_id;
    $bulan = $request->bulan ?? now()->month;
    $tahun = $request->tahun ?? now()->year;

    $startDate = Carbon::create($tahun, $bulan, 1)->startOfMonth();
    $endDate = Carbon::create($tahun, $bulan, 1)->endOfMonth();

    $komisiService = new KomisiService();
    $dataKomisi = $komisiService->hitungKomisiKapster($kapsterId, $startDate, $endDate);

    return view('pages.laporan.gaji-kapster', [
        'komisi' => $dataKomisi,
        'settings' => $komisiService->getKomisiSettings(),
    ]);
}
```

---

### **OPSI 2: Advanced Per-Kapster Override**

**Pros:**

-   ✅ Komisi bisa berbeda per kapster
-   ✅ Support kapster senior/junior
-   ✅ Lebih fleksibel

**Cons:**

-   ⚠️ Lebih kompleks
-   ⚠️ Perlu UI management lebih detail

#### **Additional Table:**

```php
Schema::create('kapster_komisi_rules', function (Blueprint $table) {
    $table->id();
    $table->foreignId('kapster_id')->constrained('kapster')->onDelete('cascade');
    $table->enum('jenis', ['potong_rambut', 'layanan_lain', 'produk']);
    $table->decimal('komisi_persen', 5, 2);
    $table->date('berlaku_dari');
    $table->date('berlaku_sampai')->nullable();
    $table->timestamps();
});
```

**Modified Service:**

```php
public function hitungKomisiTransaksi(Transaksi $transaksi)
{
    $kapster = $transaksi->kapster;
    $komisi = 0;

    // Cek apakah kapster punya custom komisi
    $customRules = KapsterKomisiRule::where('kapster_id', $kapster->id)
        ->where('berlaku_dari', '<=', $transaksi->tanggal_transaksi)
        ->where(function($q) use ($transaksi) {
            $q->whereNull('berlaku_sampai')
              ->orWhere('berlaku_sampai', '>=', $transaksi->tanggal_transaksi);
        })
        ->get()
        ->keyBy('jenis');

    // Komisi layanan
    if ($transaksi->layanan) {
        $kategori = $transaksi->layanan->kategori;
        $jenisKomisi = $kategori->komisi_type;

        // Cek custom rule dulu
        if ($customRules->has($jenisKomisi)) {
            $persenKomisi = $customRules[$jenisKomisi]->komisi_persen;
        } else {
            // Pakai default setting
            $persenKomisi = $jenisKomisi === 'potong_rambut'
                ? Setting::get('komisi_potong_rambut', 40)
                : Setting::get('komisi_layanan_lain', 25);
        }

        $hargaLayanan = $transaksi->layanan->getHargaForCabang($transaksi->cabang_id);
        $komisi += ($hargaLayanan * $persenKomisi / 100);
    }

    // Komisi produk
    if ($transaksi->produk && $transaksi->produk->count() > 0) {
        $persenKomisiProduk = $customRules->has('produk')
            ? $customRules['produk']->komisi_persen
            : Setting::get('komisi_produk', 25);

        foreach ($transaksi->produk as $produk) {
            $subtotal = $produk->pivot->subtotal;
            $komisi += ($subtotal * $persenKomisiProduk / 100);
        }
    }

    return round($komisi, 2);
}
```

---

## 🎯 **Rekomendasi Final**

**Untuk MVP (Minimum Viable Product):**
👉 **Gunakan OPSI 1** - Simple Settings-Based

**Alasan:**

1. ✅ Quick to implement (1-2 hari)
2. ✅ Mudah ditest dan debug
3. ✅ Cukup untuk mayoritas use case
4. ✅ Bisa upgrade ke Opsi 2 nanti kalau perlu

**Roadmap:**

-   **Phase 1** (Now): Implementasi Opsi 1 - Settings global
-   **Phase 2** (Future): Tambah override per kapster kalau dibutuhkan
-   **Phase 3** (Future): Tambah history komisi dan incentive bonus

---

## 📋 **Checklist Implementasi**

### **Phase 1: Core System**

-   [ ] Create `settings` table & model
-   [ ] Add `komisi_type` field to `kategoris` table
-   [ ] Create `KomisiService`
-   [ ] Update existing kategori data (set Potong Rambut)
-   [ ] Test komisi calculation

### **Phase 2: Integration**

-   [ ] Update laporan gaji kapster
-   [ ] Add komisi breakdown di detail transaksi
-   [ ] Create settings page untuk admin (edit komisi %)

### **Phase 3: UI/UX**

-   [ ] Dashboard komisi per kapster
-   [ ] Export slip gaji dengan detail komisi
-   [ ] History perubahan komisi

---

## 💰 **Contoh Perhitungan**

### Transaksi 1:

-   Layanan: Potong Rambut (Rp 45.000)
-   Komisi: 45.000 × 40% = **Rp 18.000**

### Transaksi 2:

-   Layanan: Creambath (Rp 25.000)
-   Produk: Hair Powder (Rp 20.000)
-   Komisi:
    -   Layanan: 25.000 × 25% = Rp 6.250
    -   Produk: 20.000 × 25% = Rp 5.000
    -   **Total: Rp 11.250**

### Total Komisi Bulan:

-   20 transaksi potong rambut = Rp 360.000
-   10 transaksi layanan lain = Rp 62.500
-   5 penjualan produk = Rp 25.000
-   **Total Komisi: Rp 447.500**

---

**Mau saya implementasikan yang mana? Opsi 1 (Simple) atau Opsi 2 (Advanced)?**

Saya sarankan mulai dengan **Opsi 1** dulu untuk validasi bisnis logic, baru upgrade ke Opsi 2 kalau memang dibutuhkan differensiasi per kapster.
