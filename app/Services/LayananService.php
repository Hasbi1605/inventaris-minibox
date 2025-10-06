<?php

namespace App\Services;

use App\Models\Layanan;
use App\Models\Kategori;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class LayananService
{
    /**
     * Get all layanan with pagination
     */
    public function getAllLayanan(array $filters = [], $perPage = 10)
    {
        $query = Layanan::query()->with('kategori');

        // Filter by kategori
        if (!empty($filters['kategori'])) {
            $query->where('kategori_id', $filters['kategori']);
        }

        // Filter by status
        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        // Search in nama_layanan or deskripsi
        if (!empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('nama_layanan', 'like', '%' . $filters['search'] . '%')
                    ->orWhere('deskripsi', 'like', '%' . $filters['search'] . '%');
            });
        }

        return $query->latest()->paginate($perPage);
    }

    /**
     * Get layanan by status
     */
    public function getLayananByStatus($status = 'aktif')
    {
        return Layanan::where('status', $status)->latest()->get();
    }

    /**
     * Get available categories
     */
    public function getAvailableCategories()
    {
        return Kategori::where('jenis_kategori', Kategori::JENIS_LAYANAN)
            ->aktif()
            ->orderBy('urutan')
            ->get()
            ->pluck('nama_kategori', 'id');
    }

    /**
     * Create new layanan
     */
    public function createLayanan(array $data)
    {
        try {
            Log::info('Creating new layanan', $data);

            // Separate cabang data from main data
            $cabangIds = $data['cabang_ids'] ?? [];
            $hargaCabang = $data['harga_cabang'] ?? [];

            // Remove cabang fields from main data
            unset($data['cabang_ids'], $data['harga_cabang']);

            // Create layanan
            $layanan = Layanan::create($data);

            // Attach to cabangs with specific prices
            $syncData = [];
            foreach ($cabangIds as $cabangId) {
                $syncData[$cabangId] = [
                    'harga' => isset($hargaCabang[$cabangId]) && !empty($hargaCabang[$cabangId])
                        ? $hargaCabang[$cabangId]
                        : $data['harga'], // Use base price if no specific price
                    'status' => $data['status']
                ];
            }

            $layanan->cabangs()->sync($syncData);

            Log::info('Layanan created successfully', ['id' => $layanan->id, 'cabangs_count' => count($syncData)]);

            return $layanan;
        } catch (\Exception $e) {
            Log::error('Error creating layanan: ' . $e->getMessage(), [
                'data' => $data,
                'trace' => $e->getTraceAsString(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);

            throw $e;
        }
    }

    /**
     * Update existing layanan
     */
    public function updateLayanan(array $data, Layanan $layanan)
    {
        try {
            Log::info('Updating layanan', ['id' => $layanan->id, 'data' => $data]);

            // Separate cabang data from main data
            $cabangIds = $data['cabang_ids'] ?? [];
            $hargaCabang = $data['harga_cabang'] ?? [];

            // Remove cabang fields from main data
            unset($data['cabang_ids'], $data['harga_cabang']);

            // Update layanan
            $layanan->update($data);

            // Sync cabangs with specific prices
            $syncData = [];
            foreach ($cabangIds as $cabangId) {
                $syncData[$cabangId] = [
                    'harga' => isset($hargaCabang[$cabangId]) && !empty($hargaCabang[$cabangId])
                        ? $hargaCabang[$cabangId]
                        : $data['harga'], // Use base price if no specific price
                    'status' => $data['status']
                ];
            }

            $layanan->cabangs()->sync($syncData);

            Log::info('Layanan updated successfully', ['id' => $layanan->id, 'cabangs_count' => count($syncData)]);

            return $layanan;
        } catch (\Exception $e) {
            Log::error('Error updating layanan: ' . $e->getMessage(), [
                'id' => $layanan->id,
                'data' => $data,
                'trace' => $e->getTraceAsString(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);

            throw $e;
        }
    }

    /**
     * Delete layanan
     */
    public function deleteLayanan(Layanan $layanan)
    {
        try {
            Log::info('Deleting layanan', ['id' => $layanan->id]);

            $layanan->delete();

            Log::info('Layanan deleted successfully', ['id' => $layanan->id]);

            return true;
        } catch (\Exception $e) {
            Log::error('Error deleting layanan: ' . $e->getMessage(), [
                'id' => $layanan->id,
                'trace' => $e->getTraceAsString(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);

            throw $e;
        }
    }

    /**
     * Get layanan statistics
     */
    public function getLayananStatistics()
    {
        // Get most popular service
        $mostPopular = Layanan::select('layanans.id', 'layanans.nama_layanan')
            ->leftJoin('transaksis', 'layanans.id', '=', 'transaksis.layanan_id')
            ->selectRaw('COUNT(transaksis.id) as total_transaksi')
            ->groupBy('layanans.id', 'layanans.nama_layanan')
            ->orderByDesc('total_transaksi')
            ->first();

        return [
            'total' => Layanan::count(),
            'aktif' => Layanan::where('status', 'aktif')->count(),
            'nonaktif' => Layanan::where('status', 'nonaktif')->count(),
            'avg_harga' => Layanan::avg('harga'),
            'total_cabang' => DB::table('cabang')->count(),
            'most_popular' => $mostPopular ? [
                'nama' => $mostPopular->nama_layanan,
                'total' => $mostPopular->total_transaksi
            ] : [
                'nama' => '-',
                'total' => 0
            ]
        ];
    }

    /**
     * Get layanan statistics by cabang
     */
    public function getLayananStatisticsByCabang($cabangId)
    {
        // Get layanan aktif di cabang
        $layananAktifCount = DB::table('cabang_layanan')
            ->where('cabang_id', $cabangId)
            ->where('status', 'aktif')
            ->count();

        // Get total layanan di cabang
        $totalLayananCount = DB::table('cabang_layanan')
            ->where('cabang_id', $cabangId)
            ->count();

        // Get harga tertinggi dan terendah di cabang
        $hargaStats = DB::table('cabang_layanan')
            ->where('cabang_id', $cabangId)
            ->where('status', 'aktif')
            ->selectRaw('MAX(harga) as max_harga, MIN(harga) as min_harga')
            ->first();

        return [
            'total' => $totalLayananCount,
            'aktif' => $layananAktifCount,
            'tidak_aktif' => $totalLayananCount - $layananAktifCount,
            'max_harga' => $hargaStats->max_harga ?? 0,
            'min_harga' => $hargaStats->min_harga ?? 0,
        ];
    }

    /**
     * Get all layanan with cabang relation
     */
    public function getAllLayananWithCabang(array $filters = [], $perPage = 10)
    {
        $query = Layanan::query()->with(['kategori', 'cabangs']);

        // Filter by kategori
        if (!empty($filters['kategori'])) {
            $query->where('kategori_id', $filters['kategori']);
        }

        // Filter by status
        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        // Search in nama_layanan or deskripsi
        if (!empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('nama_layanan', 'like', '%' . $filters['search'] . '%')
                    ->orWhere('deskripsi', 'like', '%' . $filters['search'] . '%');
            });
        }

        return $query->latest()->paginate($perPage);
    }

    /**
     * Get layanan by cabang
     */
    public function getLayananByCabang($cabangId, array $filters = [], $perPage = 10)
    {
        $query = Layanan::query()
            ->with(['kategori', 'cabangs' => function ($q) use ($cabangId) {
                $q->where('cabang_id', $cabangId);
            }])
            ->whereHas('cabangs', function ($q) use ($cabangId) {
                $q->where('cabang_id', $cabangId);
            });

        // Filter by kategori
        if (!empty($filters['kategori'])) {
            $query->where('kategori_id', $filters['kategori']);
        }

        // Filter by status di cabang
        if (!empty($filters['status'])) {
            $query->whereHas('cabangs', function ($q) use ($cabangId, $filters) {
                $q->where('cabang_id', $cabangId)
                    ->where('cabang_layanan.status', $filters['status']);
            });
        }

        // Search in nama_layanan or deskripsi
        if (!empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('nama_layanan', 'like', '%' . $filters['search'] . '%')
                    ->orWhere('deskripsi', 'like', '%' . $filters['search'] . '%');
            });
        }

        return $query->latest()->paginate($perPage);
    }
}
