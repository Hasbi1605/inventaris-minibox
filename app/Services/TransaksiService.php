<?php

namespace App\Services;

use App\Models\Transaksi;
use App\Models\Layanan;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class TransaksiService
{
    /**
     * Get all transaksi with pagination
     */
    public function getAllTransaksi($perPage = 10)
    {
        return Transaksi::with('layanan')->latest()->paginate($perPage);
    }

    /**
     * Get transaksi by status
     */
    public function getTransaksiByStatus($status = 'selesai')
    {
        return Transaksi::with('layanan')->where('status', $status)->latest()->get();
    }

    /**
     * Get transaksi by date range
     */
    public function getTransaksiByDateRange($startDate, $endDate)
    {
        return Transaksi::with('layanan')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->latest()
            ->get();
    }

    /**
     * Get available layanan for dropdown
     */
    public function getAvailableLayanan()
    {
        return Layanan::where('status', 'aktif')->get();
    }

    /**
     * Create new transaksi
     */
    public function createTransaksi(array $data)
    {
        try {
            Log::info('Creating new transaksi', $data);

            // Generate nomor transaksi
            $data['nomor_transaksi'] = $this->generateNomorTransaksi();

            $transaksi = Transaksi::create($data);

            Log::info('Transaksi created successfully', ['id' => $transaksi->id]);

            return $transaksi;
        } catch (\Exception $e) {
            Log::error('Error creating transaksi: ' . $e->getMessage(), [
                'data' => $data,
                'trace' => $e->getTraceAsString(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);

            throw $e;
        }
    }

    /**
     * Update existing transaksi
     */
    public function updateTransaksi(array $data, Transaksi $transaksi)
    {
        try {
            Log::info('Updating transaksi', ['id' => $transaksi->id, 'data' => $data]);

            $transaksi->update($data);

            Log::info('Transaksi updated successfully', ['id' => $transaksi->id]);

            return $transaksi;
        } catch (\Exception $e) {
            Log::error('Error updating transaksi: ' . $e->getMessage(), [
                'id' => $transaksi->id,
                'data' => $data,
                'trace' => $e->getTraceAsString(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);

            throw $e;
        }
    }

    /**
     * Delete transaksi
     */
    public function deleteTransaksi(Transaksi $transaksi)
    {
        try {
            Log::info('Deleting transaksi', ['id' => $transaksi->id]);

            $transaksi->delete();

            Log::info('Transaksi deleted successfully', ['id' => $transaksi->id]);

            return true;
        } catch (\Exception $e) {
            Log::error('Error deleting transaksi: ' . $e->getMessage(), [
                'id' => $transaksi->id,
                'trace' => $e->getTraceAsString(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);

            throw $e;
        }
    }

    /**
     * Generate nomor transaksi
     */
    private function generateNomorTransaksi()
    {
        $date = Carbon::now()->format('Ymd');
        $lastTransaksi = Transaksi::whereDate('created_at', Carbon::today())
            ->orderBy('created_at', 'desc')
            ->first();

        $sequence = 1;
        if ($lastTransaksi) {
            $lastNumber = substr($lastTransaksi->nomor_transaksi, -4);
            $sequence = intval($lastNumber) + 1;
        }

        return 'TRX' . $date . str_pad($sequence, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Get transaksi statistics
     */
    public function getTransaksiStatistics()
    {
        $today = Carbon::today();
        $thisMonth = Carbon::now()->startOfMonth();
        $thisYear = Carbon::now()->startOfYear();

        return [
            'total' => Transaksi::count(),
            'today' => Transaksi::whereDate('created_at', $today)->count(),
            'this_month' => Transaksi::whereDate('created_at', '>=', $thisMonth)->count(),
            'this_year' => Transaksi::whereDate('created_at', '>=', $thisYear)->count(),
            'pending' => Transaksi::where('status', 'pending')->count(),
            'selesai' => Transaksi::where('status', 'selesai')->count(),
            'dibatalkan' => Transaksi::where('status', 'dibatalkan')->count(),
            'total_pendapatan_today' => Transaksi::whereDate('created_at', $today)
                ->where('status', 'selesai')
                ->sum('total_harga'),
            'total_pendapatan_month' => Transaksi::whereDate('created_at', '>=', $thisMonth)
                ->where('status', 'selesai')
                ->sum('total_harga'),
            'total_pendapatan_year' => Transaksi::whereDate('created_at', '>=', $thisYear)
                ->where('status', 'selesai')
                ->sum('total_harga')
        ];
    }
}
