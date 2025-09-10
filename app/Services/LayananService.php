<?php

namespace App\Services;

use App\Models\Layanan;
use Illuminate\Support\Facades\Log;

class LayananService
{
    /**
     * Get all layanan with pagination
     */
    public function getAllLayanan($perPage = 10)
    {
        return Layanan::latest()->paginate($perPage);
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
        return Layanan::distinct()->pluck('kategori')->filter()->values();
    }

    /**
     * Create new layanan
     */
    public function createLayanan(array $data)
    {
        try {
            Log::info('Creating new layanan', $data);

            $layanan = Layanan::create($data);

            Log::info('Layanan created successfully', ['id' => $layanan->id]);

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

            $layanan->update($data);

            Log::info('Layanan updated successfully', ['id' => $layanan->id]);

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
        return [
            'total' => Layanan::count(),
            'aktif' => Layanan::where('status', 'aktif')->count(),
            'nonaktif' => Layanan::where('status', 'nonaktif')->count(),
            'avg_harga' => Layanan::avg('harga'),
            'avg_durasi' => Layanan::avg('durasi_estimasi')
        ];
    }
}
