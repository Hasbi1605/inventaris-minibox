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
        $query = Inventaris::query()->with(['kategoriRelasi', 'cabang']);

        // Filter by cabang
        if (!empty($filters['cabang_id'])) {
            $query->where('cabang_id', $filters['cabang_id']);
        }

        // Filter by tipe_penggunaan (retail/operasional) via kategori
        if (!empty($filters['tipe_penggunaan'])) {
            $query->whereHas('kategoriRelasi', function ($q) use ($filters) {
                if ($filters['tipe_penggunaan'] === 'retail') {
                    $q->whereIn('tipe_penggunaan', [Kategori::TIPE_RETAIL, Kategori::TIPE_BOTH]);
                } elseif ($filters['tipe_penggunaan'] === 'operasional') {
                    $q->whereIn('tipe_penggunaan', [Kategori::TIPE_OPERASIONAL, Kategori::TIPE_BOTH]);
                }
            });
        }

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
                $q->where('nama_barang', 'like', '%' . $filters['search'] . '%');
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
            'pcs' => 'pcs',
            'unit' => 'unit',
            'item' => 'item'
        ];
    }

    /**
     * Create new inventaris
     */
    public function createInventaris(array $data)
    {
        try {
            Log::info('Creating new inventaris', $data);

            // Auto-update status based on stock, unless it's manually set to discontinued
            if (isset($data['status']) && $data['status'] === 'discontinued') {
                // Keep discontinued status (manual override)
            } else {
                // Auto-determine status based on stock values
                $data['status'] = $this->determineStatus($data);
            }

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

            // Auto-update status based on stock, unless it's manually set to discontinued
            if (isset($data['status']) && $data['status'] === 'discontinued') {
                // Keep discontinued status (manual override)
            } else {
                // Auto-determine status based on new stock values
                $data['status'] = $this->determineStatus($data);
            }

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
     * Get inventaris statistics (adaptive: retail vs operasional)
     */
    public function getInventarisStatistics($cabangId = null)
    {
        $query = Inventaris::query()->with('kategoriRelasi');

        if ($cabangId) {
            $query->where('cabang_id', $cabangId);
        }

        $allItems = $query->get();

        // Pisahkan retail vs operasional
        $retailItems = $allItems->filter(function ($item) {
            $kategori = $item->kategoriRelasi->nama_kategori ?? '';
            return !(stripos($kategori, 'operasional') !== false ||
                stripos($kategori, 'aset') !== false ||
                stripos($kategori, 'peralatan') !== false);
        });

        $operasionalItems = $allItems->filter(function ($item) {
            $kategori = $item->kategoriRelasi->nama_kategori ?? '';
            return stripos($kategori, 'operasional') !== false ||
                stripos($kategori, 'aset') !== false ||
                stripos($kategori, 'peralatan') !== false;
        });

        return [
            'total' => $allItems->count(),
            'total_retail' => $retailItems->count(),
            'total_operasional' => $operasionalItems->count(),
            'has_operasional' => $operasionalItems->count() > 0,

            // Stats untuk retail (hanya jika ada retail items)
            'hampir_habis' => $retailItems->filter(function ($item) {
                return $item->stok_saat_ini <= $item->stok_minimal && $item->stok_saat_ini > 0;
            })->count(),
            'habis' => $retailItems->where('status', 'habis')->count(),

            // Total nilai (hanya dari retail yang punya harga)
            'total_nilai' => $retailItems->sum(function ($item) {
                return $item->stok_saat_ini * $item->harga_satuan;
            })
        ];
    }

    /**
     * Get inventaris by cabang for tabs
     */
    public function getInventarisByCabang(array $filters = [], $perPage = 10)
    {
        $query = Inventaris::query()->with(['kategoriRelasi', 'cabang']);

        // Filter by cabang
        if (!empty($filters['cabang_id'])) {
            $query->where('cabang_id', $filters['cabang_id']);
        }

        // Filter by tipe_penggunaan (retail/operasional) via kategori
        if (!empty($filters['tipe_penggunaan'])) {
            $query->whereHas('kategoriRelasi', function ($q) use ($filters) {
                if ($filters['tipe_penggunaan'] === 'retail') {
                    $q->whereIn('tipe_penggunaan', [Kategori::TIPE_RETAIL, Kategori::TIPE_BOTH]);
                } elseif ($filters['tipe_penggunaan'] === 'operasional') {
                    $q->whereIn('tipe_penggunaan', [Kategori::TIPE_OPERASIONAL, Kategori::TIPE_BOTH]);
                }
            });
        }

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
                $q->where('nama_barang', 'like', '%' . $filters['search'] . '%');
            });
        }

        return $query->latest()->paginate($perPage);
    }

    /**
     * Get low stock items
     */
    public function getLowStockItems($cabangId = null)
    {
        $query = Inventaris::stokRendah();

        if ($cabangId) {
            $query->where('cabang_id', $cabangId);
        }

        return $query->get();
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
     * Determine status based on stock levels
     */
    private function determineStatus(array $data)
    {
        $stokSaatIni = $data['stok_saat_ini'] ?? 0;
        $stokMinimal = $data['stok_minimal'] ?? 0;

        // Check stock levels
        if ($stokSaatIni <= 0) {
            return 'habis';
        } elseif ($stokSaatIni <= $stokMinimal) {
            return 'hampir_habis';
        }

        return 'tersedia';
    }
}
