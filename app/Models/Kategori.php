<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kategori extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_kategori',
        'kode_kategori',
        'deskripsi',
        'jenis_kategori', // inventaris, layanan, pengeluaran, cabang
        'tipe_penggunaan', // retail, operasional, both (untuk inventaris)
        'komisi_type', // potong_rambut, layanan_lain (untuk layanan)
        'parent_id',
        'urutan',
        'status',
        'warna',
        'ikon'
    ];

    protected $casts = [
        'urutan' => 'integer',
        'status' => 'boolean'
    ];

    // Konstanta untuk jenis kategori
    public const JENIS_INVENTARIS = 'inventaris';
    public const JENIS_LAYANAN = 'layanan';
    public const JENIS_PENGELUARAN = 'pengeluaran';
    public const JENIS_CABANG = 'cabang';

    // Konstanta untuk tipe penggunaan inventaris
    public const TIPE_RETAIL = 'retail';
    public const TIPE_OPERASIONAL = 'operasional';
    public const TIPE_BOTH = 'both';

    // Konstanta untuk komisi layanan
    public const KOMISI_POTONG_RAMBUT = 'potong_rambut';
    public const KOMISI_LAYANAN_LAIN = 'layanan_lain';

    public static function getJenisKategori()
    {
        return [
            self::JENIS_INVENTARIS => 'Inventaris',
            self::JENIS_LAYANAN => 'Layanan',
            self::JENIS_PENGELUARAN => 'Pengeluaran',
            self::JENIS_CABANG => 'Cabang',
        ];
    }

    public static function getTipePenggunaan()
    {
        return [
            self::TIPE_RETAIL => 'Produk Retail (untuk dijual)',
            self::TIPE_OPERASIONAL => 'Aset/Peralatan (operasional)',
            self::TIPE_BOTH => 'Keduanya',
        ];
    }

    public static function getKomisiType()
    {
        return [
            self::KOMISI_POTONG_RAMBUT => 'Potong Rambut (40%)',
            self::KOMISI_LAYANAN_LAIN => 'Layanan Lain (25%)',
        ];
    }

    /**
     * Check if kategori is for retail products
     */
    public function isRetail(): bool
    {
        return in_array($this->tipe_penggunaan, [self::TIPE_RETAIL, self::TIPE_BOTH]);
    }

    /**
     * Check if kategori is for operational assets
     */
    public function isOperasional(): bool
    {
        return in_array($this->tipe_penggunaan, [self::TIPE_OPERASIONAL, self::TIPE_BOTH]);
    }

    /**
     * Get komisi percentage for this kategori
     */
    public function getKomisiPercentage(): float
    {
        if ($this->jenis_kategori !== self::JENIS_LAYANAN) {
            return 0;
        }

        return $this->komisi_type === self::KOMISI_POTONG_RAMBUT
            ? (float) Setting::get('komisi_potong_rambut', 40)
            : (float) Setting::get('komisi_layanan_lain', 25);
    }

    // Relasi parent-child untuk kategori bertingkat
    public function parent()
    {
        return $this->belongsTo(Kategori::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Kategori::class, 'parent_id')->orderBy('urutan');
    }

    // Relasi dengan model-model yang menggunakan kategori
    public function inventarises()
    {
        return $this->hasMany(Inventaris::class, 'kategori_id');
    }

    public function layanan()
    {
        return $this->hasMany(Layanan::class, 'kategori_id');
    }

    public function pengeluarans()
    {
        return $this->hasMany(Pengeluaran::class, 'kategori_id');
    }

    // Scope untuk filter berdasarkan jenis kategori
    public function scopeInventaris($query)
    {
        return $query->where('jenis_kategori', self::JENIS_INVENTARIS);
    }

    public function scopeLayanan($query)
    {
        return $query->where('jenis_kategori', self::JENIS_LAYANAN);
    }

    public function scopePengeluaran($query)
    {
        return $query->where('jenis_kategori', self::JENIS_PENGELUARAN);
    }

    public function scopeCabang($query)
    {
        return $query->where('jenis_kategori', self::JENIS_CABANG);
    }

    // Scope untuk filter berdasarkan tipe penggunaan
    public function scopeRetail($query)
    {
        return $query->whereIn('tipe_penggunaan', [self::TIPE_RETAIL, self::TIPE_BOTH]);
    }

    public function scopeOperasional($query)
    {
        return $query->whereIn('tipe_penggunaan', [self::TIPE_OPERASIONAL, self::TIPE_BOTH]);
    }

    // Scope untuk kategori aktif
    public function scopeAktif($query)
    {
        return $query->where('status', true);
    }

    // Scope untuk kategori parent (tidak memiliki parent)
    public function scopeParent($query)
    {
        return $query->whereNull('parent_id');
    }

    // Accessor untuk nama lengkap dengan hierarki
    public function getNamaLengkapAttribute()
    {
        $nama = $this->nama_kategori;
        if ($this->parent) {
            $nama = $this->parent->nama_lengkap . ' > ' . $nama;
        }
        return $nama;
    }

    // Method untuk mendapatkan semua anak kategori (recursive)
    public function getAllChildren()
    {
        $children = collect();

        foreach ($this->children as $child) {
            $children->push($child);
            $children = $children->merge($child->getAllChildren());
        }

        return $children;
    }

    // Method untuk mengecek apakah kategori adalah parent
    public function isParent()
    {
        return $this->children()->count() > 0;
    }

    // Method untuk mengecek apakah kategori adalah child
    public function isChild()
    {
        return !is_null($this->parent_id);
    }
}
