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
        'telepon',
        'email',
        'manager',
        'status',
        'tanggal_buka',
        'jam_operasional_buka',
        'jam_operasional_tutup',
        'deskripsi',
    ];

    protected $casts = [
        'tanggal_buka' => 'date',
        'status' => 'string',
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
}
