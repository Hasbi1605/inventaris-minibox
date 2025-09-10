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
        'kategori'
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

    // Scope untuk layanan aktif
    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }
}
