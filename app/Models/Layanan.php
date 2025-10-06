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
        'status',
        'kategori_id'
    ];

    protected $casts = [
        'harga' => 'decimal:2'
    ];

    // Accessor untuk format harga
    public function getFormattedHargaAttribute()
    {
        return 'Rp ' . number_format($this->harga, 0, ',', '.');
    }

    // Relasi dengan kategori
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    // Alias untuk backward compatibility
    public function kategoriRelasi()
    {
        return $this->kategori();
    }

    // Relasi many-to-many dengan Cabang (untuk harga per cabang)
    public function cabangs()
    {
        return $this->belongsToMany(Cabang::class, 'cabang_layanan')
            ->withPivot('harga', 'status')
            ->withTimestamps();
    }

    // Helper: Dapatkan harga untuk cabang tertentu
    public function getHargaForCabang($cabangId)
    {
        $cabangLayanan = $this->cabangs()->where('cabang_id', $cabangId)->first();
        return $cabangLayanan ? $cabangLayanan->pivot->harga : $this->harga; // fallback ke harga default
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
        return $this->kategori ? $this->kategori->nama_kategori : '-';
    }

    /**
     * Get sequential number for this layanan
     * Returns the position of this layanan in the ordered list
     */
    public function getSequentialNumberAttribute()
    {
        // Get all layanan IDs ordered by ID
        $allIds = self::orderBy('id')->pluck('id')->toArray();

        // Find position of current layanan (1-based index)
        $position = array_search($this->id, $allIds);

        return $position !== false ? $position + 1 : 0;
    }
}
