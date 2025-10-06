<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Transaksi extends Model
{
    /** @use HasFactory<\Database\Factories\TransaksiFactory> */
    use HasFactory;

    protected $table = 'transaksis';

    protected $fillable = [
        'nomor_transaksi',
        'cabang_id',
        'layanan_id',
        'kapster_id',
        'tanggal_transaksi',
        'total_harga',
        'metode_pembayaran',
        'status',
        'catatan'
    ];

    protected $casts = [
        'tanggal_transaksi' => 'date',
        'total_harga' => 'decimal:2'
    ];

    // Relationship with Layanan
    public function layanan()
    {
        return $this->belongsTo(Layanan::class);
    }

    // Relationship with Kapster
    public function kapster()
    {
        return $this->belongsTo(Kapster::class);
    }

    // Relationship with Cabang
    public function cabang()
    {
        return $this->belongsTo(Cabang::class);
    }

    // Relationship with Inventaris (Produk)
    public function produk()
    {
        return $this->belongsToMany(Inventaris::class, 'transaksi_produk')
            ->withPivot('quantity', 'harga_satuan', 'subtotal')
            ->withTimestamps();
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

    // Scope for filtering by cabang
    public function scopeByCabang($query, $cabangId)
    {
        return $query->where('cabang_id', $cabangId);
    }

    /**
     * Generate nomor transaksi otomatis dengan format sequential
     * Format: TRX + Tahun + Bulan + Nomor Urut
     */
    public static function generateNomorTransaksi()
    {
        $year = date('Y');
        $month = date('m');
        $prefix = 'TRX' . $year . $month;

        // Hitung jumlah transaksi yang ada saat ini
        $count = self::count();
        $nextNumber = $count + 1;

        // Format dengan padding 5 digit
        return $prefix . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
    }

    /**
     * Renumber all transactions sequentially after delete
     */
    public static function renumberTransactions()
    {
        $transaksis = self::orderBy('id')->get();
        $year = date('Y');
        $month = date('m');
        $prefix = 'TRX' . $year . $month;

        foreach ($transaksis as $index => $transaksi) {
            $newNumber = $prefix . str_pad($index + 1, 5, '0', STR_PAD_LEFT);
            $transaksi->update(['nomor_transaksi' => $newNumber]);
        }
    }

    /**
     * Get sequential number for this transaction
     * Returns the position of this transaction in the ordered list
     */
    public function getSequentialNumberAttribute()
    {
        // Get all transaction IDs ordered by ID
        $allIds = self::orderBy('id')->pluck('id')->toArray();

        // Find position of current transaction (1-based index)
        $position = array_search($this->id, $allIds);

        return $position !== false ? $position + 1 : 0;
    }
}
