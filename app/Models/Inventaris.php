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
        'deskripsi',
        'kategori',
        'stok_minimal',
        'stok_saat_ini',
        'harga_satuan',
        'satuan',
        'merek',
        'tanggal_kadaluarsa',
        'status'
    ];

    protected $casts = [
        'harga_satuan' => 'decimal:2',
        'stok_minimal' => 'integer',
        'stok_saat_ini' => 'integer',
        'tanggal_kadaluarsa' => 'date'
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
        } elseif ($this->tanggal_kadaluarsa && $this->tanggal_kadaluarsa->isPast()) {
            return 'kadaluarsa';
        }
        return 'tersedia';
    }

    // Accessor untuk informasi kadaluarsa
    public function getKadaluarsaInfoAttribute()
    {
        if (!$this->tanggal_kadaluarsa) {
            return null;
        }

        $today = Carbon::today();
        $kadaluarsa = $this->tanggal_kadaluarsa;

        if ($kadaluarsa->isPast()) {
            return 'Sudah kadaluarsa';
        } elseif ($kadaluarsa->diffInDays($today) <= 30) {
            return 'Akan kadaluarsa dalam ' . $kadaluarsa->diffInDays($today) . ' hari';
        }

        return null;
    }

    // Scope untuk barang dengan stok rendah
    public function scopeStokRendah($query)
    {
        return $query->whereRaw('stok_saat_ini <= stok_minimal');
    }

    // Scope untuk barang hampir kadaluarsa
    public function scopeHampirKadaluarsa($query)
    {
        return $query->where('tanggal_kadaluarsa', '<=', Carbon::today()->addDays(30))
            ->where('tanggal_kadaluarsa', '>', Carbon::today());
    }

    // Scope untuk barang kadaluarsa
    public function scopeKadaluarsa($query)
    {
        return $query->where('tanggal_kadaluarsa', '<', Carbon::today());
    }

    // Scope berdasarkan kategori
    public function scopeByKategori($query, $kategori)
    {
        return $query->where('kategori', $kategori);
    }
}
