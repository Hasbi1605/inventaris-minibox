<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kapster extends Model
{
    use HasFactory;

    protected $table = 'kapster';

    protected $fillable = [
        'nama_kapster',
        'cabang_id',
        'spesialisasi',
        'status',
        'telepon',
        'komisi_persen',
    ];

    protected $casts = [
        'komisi_persen' => 'decimal:2',
    ];

    /**
     * Relasi ke Cabang (Many to One)
     */
    public function cabang(): BelongsTo
    {
        return $this->belongsTo(Cabang::class);
    }

    /**
     * Relasi ke Transaksi (One to Many)
     */
    public function transaksi(): HasMany
    {
        return $this->hasMany(Transaksi::class);
    }

    /**
     * Scope untuk kapster aktif
     */
    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }

    /**
     * Scope untuk kapster di cabang tertentu
     */
    public function scopeByCabang($query, $cabangId)
    {
        return $query->where('cabang_id', $cabangId);
    }
}
