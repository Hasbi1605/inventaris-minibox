<?php

namespace App\Services;

use App\Models\Inventaris;
use App\Models\Kategori;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class InventarisService
{
    /**
     * Get all inventaris with pagination
     */
    public function getAllInventaris(array $filters = [], $perPage = 10)
    {
        $query = Inventaris::query()->with('kategoriRelasi');

        // Filter by kategori
        if (!empty($filters['kategori'])) {
            $query->where('kategori_id', $filters['kategori']);
        }

        // Filter by status
        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        // Search in nama_barang or deskripsi
        if (!empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('nama_barang', 'like', '%' . $filters['search'] . '%')
                    ->orWhere('deskripsi', 'like', '%' . $filters['search'] . '%');
            });
        }

        return $query->latest()->paginate($perPage);
    }

    /**
     * Get inventaris by category
     */
    public function getInventarisByKategori($kategori)
    {
        return Inventaris::byKategori($kategori)->latest()->get();
    }

    /**
     * Get available categories
     */
    public function getAvailableCategories()
    {
        return Kategori::inventaris()
            ->aktif()
            ->orderBy('urutan')
            ->get()
            ->pluck('nama_kategori', 'id');
    }

    /**
     * Get available units
     */
    public function getAvailableUnits()
    {
        return [
            'pcs' => 'Pieces (pcs)',
            'botol' => 'Botol',
            'tube' => 'Tube',
            'kotak' => 'Kotak',
            'pack' => 'Pack',
            'liter' => 'Liter',
            'ml' => 'Mililiter (ml)',
            'kg' => 'Kilogram (kg)',
            'gram' => 'Gram (g)'
        ];
    }

    /**
     * Create new inventaris
     */
    public function createInventaris(array $data)
    {
        try {
            Log::info('Creating new inventaris', $data);

            // Update status based on stock and expiry
            $data['status'] = $this->determineStatus($data);

            $inventaris = Inventaris::create($data);

            Log::info('Inventaris created successfully', ['id' => $inventaris->id]);

            return $inventaris;
        } catch (\Exception $e) {
            Log::error('Error creating inventaris: ' . $e->getMessage(), [
                'data' => $data,
                'trace' => $e->getTraceAsString(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);

            throw $e;
        }
    }

    /**
     * Update existing inventaris
     */
    public function updateInventaris(array $data, Inventaris $inventaris)
    {
        try {
            Log::info('Updating inventaris', ['id' => $inventaris->id, 'data' => $data]);

            // Update status based on stock and expiry
            $data['status'] = $this->determineStatus($data);

            $inventaris->update($data);

            Log::info('Inventaris updated successfully', ['id' => $inventaris->id]);

            return $inventaris;
        } catch (\Exception $e) {
            Log::error('Error updating inventaris: ' . $e->getMessage(), [
                'id' => $inventaris->id,
                'data' => $data,
                'trace' => $e->getTraceAsString(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);

            throw $e;
        }
    }

    /**
     * Delete inventaris
     */
    public function deleteInventaris(Inventaris $inventaris)
    {
        try {
            Log::info('Deleting inventaris', ['id' => $inventaris->id]);

            $inventaris->delete();

            Log::info('Inventaris deleted successfully', ['id' => $inventaris->id]);

            return true;
        } catch (\Exception $e) {
            Log::error('Error deleting inventaris: ' . $e->getMessage(), [
                'id' => $inventaris->id,
                'trace' => $e->getTraceAsString(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);

            throw $e;
        }
    }

    /**
     * Get inventaris statistics
     */
    public function getInventarisStatistics()
    {
        return [
            'total' => Inventaris::count(),
            'tersedia' => Inventaris::where('status', 'tersedia')->count(),
            'hampir_habis' => Inventaris::stokRendah()->count(),
            'habis' => Inventaris::where('status', 'habis')->count(),
            'hampir_kadaluarsa' => Inventaris::hampirKadaluarsa()->count(),
            'kadaluarsa' => Inventaris::kadaluarsa()->count(),
            'total_nilai' => Inventaris::sum(DB::raw('stok_saat_ini * harga_satuan'))
        ];
    }

    /**
     * Get low stock items
     */
    public function getLowStockItems()
    {
        return Inventaris::stokRendah()->get();
    }

    /**
     * Get items near expiry
     */
    public function getItemsNearExpiry()
    {
        return Inventaris::hampirKadaluarsa()->get();
    }

    /**
     * Get expired items
     */
    public function getExpiredItems()
    {
        return Inventaris::kadaluarsa()->get();
    }

    /**
     * Update stock quantity
     */
    public function updateStock(Inventaris $inventaris, int $newStock, string $reason = '')
    {
        try {
            Log::info('Updating stock for inventaris', [
                'id' => $inventaris->id,
                'old_stock' => $inventaris->stok_saat_ini,
                'new_stock' => $newStock,
                'reason' => $reason
            ]);

            $inventaris->stok_saat_ini = $newStock;
            $inventaris->status = $this->determineStatus($inventaris->toArray());
            $inventaris->save();

            Log::info('Stock updated successfully', ['id' => $inventaris->id]);

            return $inventaris;
        } catch (\Exception $e) {
            Log::error('Error updating stock: ' . $e->getMessage(), [
                'id' => $inventaris->id,
                'trace' => $e->getTraceAsString(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);

            throw $e;
        }
    }

    /**
     * Determine status based on stock and expiry date
     */
    private function determineStatus(array $data)
    {
        $stokSaatIni = $data['stok_saat_ini'] ?? 0;
        $stokMinimal = $data['stok_minimal'] ?? 0;
        $tanggalKadaluarsa = isset($data['tanggal_kadaluarsa']) ? Carbon::parse($data['tanggal_kadaluarsa']) : null;

        // Check if expired
        if ($tanggalKadaluarsa && $tanggalKadaluarsa->isPast()) {
            return 'kadaluarsa';
        }

        // Check stock levels
        if ($stokSaatIni <= 0) {
            return 'habis';
        } elseif ($stokSaatIni <= $stokMinimal) {
            return 'hampir_habis';
        }

        return 'tersedia';
    }
}
