<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Transaksi extends Model
{
    /** @use HasFactory<\Database\Factories\TransaksiFactory> */
    use HasFactory;

    protected $fillable = [
        'nomor_transaksi',
        'nama_pelanggan',
        'telepon_pelanggan',
        'layanan_id',
        'tanggal_transaksi',
        'waktu_mulai',
        'waktu_selesai',
        'total_harga',
        'metode_pembayaran',
        'status',
        'catatan'
    ];

    protected $casts = [
        'tanggal_transaksi' => 'date',
        'waktu_mulai' => 'datetime:H:i',
        'waktu_selesai' => 'datetime:H:i',
        'total_harga' => 'decimal:2'
    ];

    // Relationship with Layanan
    public function layanan()
    {
        return $this->belongsTo(Layanan::class);
    }

    // Accessor for formatted total harga
    public function getFormattedTotalHargaAttribute()
    {
        return 'Rp ' . number_format($this->total_harga, 0, ',', '.');
    }

    // Accessor for status badge color
    public function getStatusBadgeColorAttribute()
    {
        return match ($this->status) {
            'pending' => 'from-yellow-600 to-orange-400',
            'sedang_proses' => 'from-blue-600 to-cyan-400',
            'selesai' => 'from-green-600 to-lime-400',
            'dibatalkan' => 'from-red-600 to-rose-400',
            default => 'from-gray-600 to-slate-400'
        };
    }

    // Scope for filtering by status
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    // Scope for filtering by date range
    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('tanggal_transaksi', [$startDate, $endDate]);
    }
}
