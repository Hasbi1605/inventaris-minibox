<?php

namespace App\Services;

use App\Models\Cabang;
use App\Models\Layanan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CabangLayananService
{
    /**
     * Get harga layanan untuk cabang tertentu
     * Fallback ke harga default jika tidak ada harga khusus
     */
    public function getHargaLayananForCabang($layananId, $cabangId)
    {
        $layanan = Layanan::find($layananId);
        if (!$layanan) {
            return null;
        }

        // Check if cabang has custom price
        $cabangLayanan = DB::table('cabang_layanan')
            ->where('layanan_id', $layananId)
            ->where('cabang_id', $cabangId)
            ->where('status', 'aktif')
            ->first();

        return $cabangLayanan ? $cabangLayanan->harga : $layanan->harga;
    }

    /**
     * Get all layanan untuk cabang dengan harga masing-masing
     */
    public function getLayananForCabang($cabangId)
    {
        $cabang = Cabang::with('layanans')->find($cabangId);
        if (!$cabang) {
            return collect();
        }

        // Get all active layanan
        $allLayanan = Layanan::where('status', 'aktif')->get();

        return $allLayanan->map(function ($layanan) use ($cabang) {
            // Check if this layanan has custom price for this cabang
            $customPrice = $cabang->layanans()->where('layanan_id', $layanan->id)->first();

            return [
                'id' => $layanan->id,
                'nama_layanan' => $layanan->nama_layanan,
                'deskripsi' => $layanan->deskripsi,
                'harga_default' => $layanan->harga,
                'harga_cabang' => $customPrice ? $customPrice->pivot->harga : $layanan->harga,
                'is_custom' => $customPrice !== null,
                'status' => $customPrice ? $customPrice->pivot->status : 'aktif'
            ];
        });
    }

    /**
     * Set harga khusus layanan untuk cabang
     */
    public function setHargaLayananCabang($cabangId, $layananId, $harga, $status = 'aktif')
    {
        try {
            DB::table('cabang_layanan')->updateOrInsert(
                [
                    'cabang_id' => $cabangId,
                    'layanan_id' => $layananId
                ],
                [
                    'harga' => $harga,
                    'status' => $status,
                    'updated_at' => now()
                ]
            );

            Log::info('Set harga layanan untuk cabang', [
                'cabang_id' => $cabangId,
                'layanan_id' => $layananId,
                'harga' => $harga
            ]);

            return true;
        } catch (\Exception $e) {
            Log::error('Error setting harga layanan cabang: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Reset harga layanan cabang ke default
     */
    public function resetHargaLayananCabang($cabangId, $layananId)
    {
        try {
            DB::table('cabang_layanan')
                ->where('cabang_id', $cabangId)
                ->where('layanan_id', $layananId)
                ->delete();

            Log::info('Reset harga layanan cabang ke default', [
                'cabang_id' => $cabangId,
                'layanan_id' => $layananId
            ]);

            return true;
        } catch (\Exception $e) {
            Log::error('Error resetting harga layanan cabang: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Bulk set harga layanan untuk cabang
     */
    public function bulkSetHargaLayanan($cabangId, array $layananHarga)
    {
        try {
            DB::beginTransaction();

            foreach ($layananHarga as $item) {
                $this->setHargaLayananCabang(
                    $cabangId,
                    $item['layanan_id'],
                    $item['harga'],
                    $item['status'] ?? 'aktif'
                );
            }

            DB::commit();

            Log::info('Bulk set harga layanan untuk cabang', [
                'cabang_id' => $cabangId,
                'count' => count($layananHarga)
            ]);

            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error bulk setting harga layanan: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Get all cabang yang bisa dipilih
     */
    public function getAllCabang()
    {
        return Cabang::where('status', 'aktif')
            ->orderBy('nama_cabang')
            ->get();
    }
}
