<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Inventaris extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_barang',

        'kategori',
        'kategori_id',
        'jenis',
        'cabang_id',
        'stok_minimal',
        'stok_saat_ini',
        'harga_satuan',
        'satuan',
        'status'
    ];

    protected $casts = [
        'harga_satuan' => 'decimal:2',
        'stok_minimal' => 'integer',
        'stok_saat_ini' => 'integer'
    ];

    // Accessor untuk format harga
    public function getFormattedHargaAttribute()
    {
        return 'Rp ' . number_format($this->harga_satuan, 0, ',', '.');
    }

    // Accessor untuk status stok
    public function getStatusStokAttribute()
    {
        if ($this->stok_saat_ini <= 0) {
            return 'habis';
        } elseif ($this->stok_saat_ini <= $this->stok_minimal) {
            return 'hampir_habis';
        }
        return 'tersedia';
    }

    // Scope untuk barang dengan stok rendah
    public function scopeStokRendah($query)
    {
        return $query->whereRaw('stok_saat_ini <= stok_minimal');
    }

    // Scope berdasarkan jenis
    public function scopeProduk($query)
    {
        return $query->where('jenis', 'produk');
    }

    public function scopeAset($query)
    {
        return $query->where('jenis', 'aset');
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

    // Relasi dengan cabang
    public function cabang()
    {
        return $this->belongsTo(Cabang::class, 'cabang_id');
    }

    // Scope berdasarkan kategori
    public function scopeByKategori($query, $kategori)
    {
        return $query->where('kategori', $kategori);
    }

    // Scope berdasarkan kategori ID
    public function scopeByKategoriId($query, $kategoriId)
    {
        return $query->where('kategori_id', $kategoriId);
    }

    // Scope berdasarkan cabang
    public function scopeByCabang($query, $cabangId)
    {
        return $query->where('cabang_id', $cabangId);
    }

    // Accessor untuk nama kategori
    public function getNamaKategoriAttribute()
    {
        // Cek apakah relasi kategori sudah dimuat dan merupakan object
        if ($this->relationLoaded('kategori') && $this->kategori instanceof Kategori) {
            return $this->kategori->nama_kategori;
        }

        // Jika relasi belum dimuat, coba load terlebih dahulu
        if ($this->kategori_id) {
            $kategori = $this->kategori()->first();
            if ($kategori) {
                return $kategori->nama_kategori;
            }
        }

        // Fallback ke kolom kategori string jika ada
        return $this->attributes['kategori'] ?? '-';
    }
}
