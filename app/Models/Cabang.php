<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Cabang extends Model
{
    use HasFactory;

    protected $table = 'cabang';

    protected $fillable = [
        'nama_cabang',
        'alamat',
        'status',
        'tanggal_buka',
        'jam_operasional_buka',
        'jam_operasional_tutup',
        'deskripsi',
        'kategori_id',
    ];

    protected $casts = [
        'status' => 'string',
        'tanggal_buka' => 'date',
    ];

    /**
     * Get status badge color based on status
     *
     * @return string
     */
    public function getStatusBadgeColorAttribute(): string
    {
        $colors = [
            'aktif' => 'from-green-600 to-lime-400',
            'tidak_aktif' => 'from-red-600 to-rose-400',
            'maintenance' => 'from-orange-600 to-yellow-400',
            'renovasi' => 'from-purple-600 to-pink-400',
        ];

        return $colors[strtolower($this->status)] ?? 'from-gray-600 to-slate-400';
    }

    /**
     * Get formatted jam operasional
     *
     * @return string
     */
    public function getJamOperasionalAttribute(): string
    {
        if (!$this->jam_operasional_buka || !$this->jam_operasional_tutup) {
            return 'Belum diatur';
        }

        return $this->jam_operasional_buka . ' - ' . $this->jam_operasional_tutup;
    }

    /**
     * Check if cabang is currently open
     *
     * @return bool
     */
    public function getIsOpenAttribute(): bool
    {
        if ($this->status !== 'aktif') {
            return false;
        }

        if (!$this->jam_operasional_buka || !$this->jam_operasional_tutup) {
            return false;
        }

        $now = Carbon::now()->format('H:i');
        return $now >= $this->jam_operasional_buka && $now <= $this->jam_operasional_tutup;
    }

    /**
     * Get formatted alamat (shortened)
     *
     * @return string
     */
    public function getShortAlamatAttribute(): string
    {
        return strlen($this->alamat) > 50 ? substr($this->alamat, 0, 50) . '...' : $this->alamat;
    }

    /**
     * Scope for active branches
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'aktif');
    }

    /**
     * Scope for inactive branches
     */
    public function scopeInactive($query)
    {
        return $query->where('status', '!=', 'aktif');
    }

    /**
     * Scope for recently opened branches (last 30 days)
     */
    public function scopeRecentlyOpened($query)
    {
        return $query->where('tanggal_buka', '>=', Carbon::now()->subDays(30));
    }

    /**
     * Get age of cabang in days
     *
     * @return int
     */
    public function getAgeInDaysAttribute(): int
    {
        return $this->tanggal_buka ? $this->tanggal_buka->diffInDays(Carbon::now()) : 0;
    }

    /**
     * Get all possible status options
     *
     * @return array
     */
    public static function getStatusOptions(): array
    {
        return [
            'aktif' => 'Aktif',
            'tidak_aktif' => 'Tidak Aktif',
            'maintenance' => 'Maintenance',
            'renovasi' => 'Renovasi',
        ];
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    /**
     * Relasi ke Kapster (One to Many)
     */
    public function kapster()
    {
        return $this->hasMany(Kapster::class);
    }

    /**
     * Relasi ke Kapster aktif
     */
    public function kapsterAktif()
    {
        return $this->hasMany(Kapster::class)->where('status', 'aktif');
    }

    /**
     * Relasi ke Inventaris (One to Many)
     */
    public function inventaris()
    {
        return $this->hasMany(Inventaris::class);
    }

    /**
     * Relasi ke Transaksi (One to Many)
     */
    public function transaksi()
    {
        return $this->hasMany(Transaksi::class);
    }

    /**
     * Relasi ke Pengeluaran (One to Many)
     */
    public function pengeluaran()
    {
        return $this->hasMany(Pengeluaran::class);
    }

    /**
     * Relasi many-to-many dengan Layanan (untuk harga per cabang)
     */
    public function layanans()
    {
        return $this->belongsToMany(Layanan::class, 'cabang_layanan')
            ->withPivot('harga', 'status')
            ->withTimestamps();
    }
}
