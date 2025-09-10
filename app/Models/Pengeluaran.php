<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Pengeluaran extends Model
{
    use HasFactory;

    protected $table = 'pengeluarans';

    protected $fillable = [
        'nama_pengeluaran',
        'kategori',
        'jumlah',
        'tanggal_pengeluaran',
        'deskripsi',
        'bukti_pengeluaran',
        'status',
    ];

    protected $casts = [
        'tanggal_pengeluaran' => 'date',
        'jumlah' => 'decimal:2',
    ];

    /**
     * Get formatted jumlah
     *
     * @return string
     */
    public function getFormattedJumlahAttribute(): string
    {
        return 'Rp ' . number_format($this->jumlah, 0, ',', '.');
    }

    /**
     * Get kategori badge color based on kategori
     *
     * @return string
     */
    public function getKategoriBadgeColorAttribute(): string
    {
        $colors = [
            'operasional' => 'from-blue-600 to-cyan-400',
            'inventaris' => 'from-green-600 to-lime-400',
            'promosi' => 'from-purple-600 to-pink-400',
            'maintenance' => 'from-orange-600 to-yellow-400',
            'gaji' => 'from-indigo-600 to-blue-400',
            'utilitas' => 'from-gray-600 to-slate-400',
            'lainnya' => 'from-red-600 to-rose-400',
        ];

        return $colors[strtolower($this->kategori)] ?? 'from-gray-600 to-slate-400';
    }

    /**
     * Scope for filtering by date range
     */
    public function scopeDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('tanggal_pengeluaran', [$startDate, $endDate]);
    }

    /**
     * Scope for filtering by kategori
     */
    public function scopeKategori($query, $kategori)
    {
        return $query->where('kategori', $kategori);
    }

    /**
     * Scope for current month
     */
    public function scopeCurrentMonth($query)
    {
        return $query->whereYear('tanggal_pengeluaran', Carbon::now()->year)
            ->whereMonth('tanggal_pengeluaran', Carbon::now()->month);
    }

    /**
     * Scope for today
     */
    public function scopeToday($query)
    {
        return $query->whereDate('tanggal_pengeluaran', Carbon::today());
    }

    /**
     * Get all possible categories
     *
     * @return array
     */
    public static function getCategories(): array
    {
        return [
            'operasional' => 'Operasional',
            'inventaris' => 'Inventaris',
            'promosi' => 'Promosi',
            'maintenance' => 'Maintenance',
            'gaji' => 'Gaji',
            'utilitas' => 'Utilitas',
            'lainnya' => 'Lainnya',
        ];
    }
}
