<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Layanan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_layanan',
        'deskripsi',
        'harga',
        'durasi_estimasi',
        'status',
        'kategori',
        'kategori_id'
    ];

    protected $casts = [
        'harga' => 'decimal:2',
        'durasi_estimasi' => 'integer'
    ];

    // Accessor untuk format harga
    public function getFormattedHargaAttribute()
    {
        return 'Rp ' . number_format($this->harga, 0, ',', '.');
    }

    // Accessor untuk format durasi
    public function getFormattedDurasiAttribute()
    {
        return $this->durasi_estimasi . ' menit';
    }

    // Relasi dengan kategori
    public function kategoriRelasi()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    // Scope untuk layanan aktif
    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }

    // Scope berdasarkan kategori ID
    public function scopeByKategoriId($query, $kategoriId)
    {
        return $query->where('kategori_id', $kategoriId);
    }

    // Accessor untuk nama kategori
    public function getNamaKategoriAttribute()
    {
        return $this->kategoriRelasi ? $this->kategoriRelasi->nama_kategori : $this->kategori;
    }
}
