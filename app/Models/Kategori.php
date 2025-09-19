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
        'jenis_kategori', // inventaris, layanan, pengeluaran, cabang, transaksi
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
    public const JENIS_TRANSAKSI = 'transaksi';

    public static function getJenisKategori()
    {
        return [
            self::JENIS_INVENTARIS => 'Inventaris',
            self::JENIS_LAYANAN => 'Layanan',
            self::JENIS_PENGELUARAN => 'Pengeluaran',
            self::JENIS_CABANG => 'Cabang',
            self::JENIS_TRANSAKSI => 'Transaksi'
        ];
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

    public function scopeTransaksi($query)
    {
        return $query->where('jenis_kategori', self::JENIS_TRANSAKSI);
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
