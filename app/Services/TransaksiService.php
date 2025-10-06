<?php

namespace App\Services;

use App\Models\Transaksi;
use App\Models\Layanan;
use App\Models\Kategori;
use App\Models\Inventaris;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class TransaksiService
{
    /**
     * Get all transaksi with pagination
     */
    public function getAllTransaksi(array $filters = [], $perPage = 10)
    {
        $query = Transaksi::query()->with(['layanan', 'kapster.cabang', 'produk', 'cabang']);

        // Filter by cabang
        if (!empty($filters['cabang_id'])) {
            $query->where('cabang_id', $filters['cabang_id']);
        }

        // Filter by status
        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        // Filter by date range
        if (!empty($filters['tanggal_dari'])) {
            $query->whereDate('tanggal_transaksi', '>=', $filters['tanggal_dari']);
        }

        if (!empty($filters['tanggal_sampai'])) {
            $query->whereDate('tanggal_transaksi', '<=', $filters['tanggal_sampai']);
        }

        // Filter by layanan
        if (!empty($filters['kategori'])) {
            $query->where('layanan_id', $filters['kategori']);
        }

        // Search in nomor_transaksi only
        if (!empty($filters['search'])) {
            $query->where('nomor_transaksi', 'like', '%' . $filters['search'] . '%');
        }

        return $query->latest()->paginate($perPage);
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
     * Get available inventaris for product sales (filtered by cabang)
     */
    public function getAvailableInventaris($cabangId = null)
    {
        $query = Inventaris::whereHas('kategoriRelasi', function ($q) {
            // Hanya produk retail (tipe_penggunaan = 'retail' atau 'both'), bukan aset operasional
            $q->whereIn('tipe_penggunaan', ['retail', 'both']);
        })
            ->where('status', 'tersedia')
            ->where('stok_saat_ini', '>', 0);

        // Filter by cabang if provided
        if ($cabangId) {
            $query->where('cabang_id', $cabangId);
        }

        return $query->select('id', 'nama_barang', 'harga_satuan', 'stok_saat_ini', 'satuan', 'cabang_id')
            ->with('cabang:id,nama_cabang')
            ->orderBy('nama_barang')
            ->get();
    }

    /**
     * Get available layanan for transactions filter
     */
    public function getAvailableCategories()
    {
        return Layanan::orderBy('nama_layanan')
            ->get()
            ->pluck('nama_layanan', 'id');
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

            // Extract produk data if exists
            $produkData = $data['produk'] ?? [];
            unset($data['produk']);

            // Create transaksi
            $transaksi = Transaksi::create($data);

            // Process produk if exists
            if (!empty($produkData)) {
                foreach ($produkData as $produk) {
                    if (!empty($produk['inventaris_id']) && !empty($produk['quantity'])) {
                        // Get inventaris data
                        $inventaris = Inventaris::find($produk['inventaris_id']);
                        if ($inventaris) {
                            // Validate stock per cabang
                            if (isset($data['cabang_id']) && $inventaris->cabang_id != $data['cabang_id']) {
                                Log::warning('Inventaris cabang mismatch', [
                                    'transaksi_cabang' => $data['cabang_id'],
                                    'inventaris_cabang' => $inventaris->cabang_id,
                                    'inventaris_id' => $inventaris->id
                                ]);
                                throw new \Exception("Produk {$inventaris->nama_barang} tidak tersedia di cabang ini.");
                            }

                            // Validate sufficient stock
                            if ($inventaris->stok_saat_ini < $produk['quantity']) {
                                throw new \Exception("Stok {$inventaris->nama_barang} tidak mencukupi. Tersedia: {$inventaris->stok_saat_ini}");
                            }

                            // Calculate subtotal
                            $hargaSatuan = $inventaris->harga_satuan;
                            $quantity = $produk['quantity'];
                            $subtotal = $hargaSatuan * $quantity;

                            // Attach produk to transaksi with pivot data
                            $transaksi->produk()->attach($produk['inventaris_id'], [
                                'quantity' => $quantity,
                                'harga_satuan' => $hargaSatuan,
                                'subtotal' => $subtotal
                            ]);

                            // Update inventaris stock
                            $inventaris->stok_saat_ini -= $quantity;

                            // Auto-update status based on stock level
                            if ($inventaris->stok_saat_ini <= 0) {
                                $inventaris->status = 'habis';
                            } elseif ($inventaris->stok_saat_ini <= $inventaris->stok_minimal) {
                                $inventaris->status = 'hampir_habis';
                            }

                            $inventaris->save();

                            Log::info('Attached produk to transaksi and updated stock', [
                                'transaksi_id' => $transaksi->id,
                                'inventaris_id' => $produk['inventaris_id'],
                                'quantity_sold' => $quantity,
                                'remaining_stock' => $inventaris->stok_saat_ini,
                                'new_status' => $inventaris->status
                            ]);
                        }
                    }
                }
            }

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

            // Extract produk data if exists
            $produkData = $data['produk'] ?? [];
            unset($data['produk']);

            // Update transaksi basic data
            $transaksi->update($data);

            // Process produk updates
            if (!empty($produkData)) {
                // Get existing produk relationships
                $existingProduk = $transaksi->produk->pluck('id')->toArray();
                $newProdukIds = [];

                foreach ($produkData as $produk) {
                    if (!empty($produk['inventaris_id']) && !empty($produk['quantity'])) {
                        $inventaris = Inventaris::find($produk['inventaris_id']);
                        if ($inventaris) {
                            $hargaSatuan = $inventaris->harga_satuan;
                            $quantity = $produk['quantity'];
                            $subtotal = $hargaSatuan * $quantity;

                            // Check if product already exists in transaction
                            if (in_array($produk['inventaris_id'], $existingProduk)) {
                                // Update existing pivot
                                $existingQuantity = $transaksi->produk()->where('inventaris_id', $produk['inventaris_id'])->first()->pivot->quantity;
                                $quantityDiff = $quantity - $existingQuantity;

                                $transaksi->produk()->updateExistingPivot($produk['inventaris_id'], [
                                    'quantity' => $quantity,
                                    'harga_satuan' => $hargaSatuan,
                                    'subtotal' => $subtotal
                                ]);

                                // Adjust stock based on difference
                                $inventaris->stok_saat_ini -= $quantityDiff;

                                // Auto-update status based on stock level
                                if ($inventaris->stok_saat_ini <= 0) {
                                    $inventaris->status = 'habis';
                                } elseif ($inventaris->stok_saat_ini <= $inventaris->stok_minimal) {
                                    $inventaris->status = 'hampir_habis';
                                } else {
                                    $inventaris->status = 'tersedia';
                                }

                                $inventaris->save();
                            } else {
                                // Attach new product
                                $transaksi->produk()->attach($produk['inventaris_id'], [
                                    'quantity' => $quantity,
                                    'harga_satuan' => $hargaSatuan,
                                    'subtotal' => $subtotal
                                ]);

                                // Reduce stock
                                $inventaris->stok_saat_ini -= $quantity;

                                // Auto-update status based on stock level
                                if ($inventaris->stok_saat_ini <= 0) {
                                    $inventaris->status = 'habis';
                                } elseif ($inventaris->stok_saat_ini <= $inventaris->stok_minimal) {
                                    $inventaris->status = 'hampir_habis';
                                }

                                $inventaris->save();
                            }

                            $newProdukIds[] = $produk['inventaris_id'];
                        }
                    }
                }

                // Remove products that are no longer in the transaction
                $removedProdukIds = array_diff($existingProduk, $newProdukIds);
                foreach ($removedProdukIds as $removedId) {
                    $removedProduk = $transaksi->produk()->where('inventaris_id', $removedId)->first();
                    if ($removedProduk) {
                        // Return stock
                        $inventaris = Inventaris::find($removedId);
                        if ($inventaris) {
                            $inventaris->stok_saat_ini += $removedProduk->pivot->quantity;

                            // Auto-update status based on stock level
                            if ($inventaris->stok_saat_ini <= 0) {
                                $inventaris->status = 'habis';
                            } elseif ($inventaris->stok_saat_ini <= $inventaris->stok_minimal) {
                                $inventaris->status = 'hampir_habis';
                            } else {
                                $inventaris->status = 'tersedia';
                            }

                            $inventaris->save();
                        }

                        // Detach from transaction
                        $transaksi->produk()->detach($removedId);
                    }
                }
            } else {
                // If no products provided, remove all existing products and return stock
                foreach ($transaksi->produk as $produk) {
                    $inventaris = Inventaris::find($produk->id);
                    if ($inventaris) {
                        $inventaris->stok_saat_ini += $produk->pivot->quantity;

                        // Auto-update status based on stock level
                        if ($inventaris->stok_saat_ini <= 0) {
                            $inventaris->status = 'habis';
                        } elseif ($inventaris->stok_saat_ini <= $inventaris->stok_minimal) {
                            $inventaris->status = 'hampir_habis';
                        } else {
                            $inventaris->status = 'tersedia';
                        }

                        $inventaris->save();
                    }
                }
                $transaksi->produk()->detach();
            }

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

            // Return stock for all products in this transaction
            foreach ($transaksi->produk as $produk) {
                $inventaris = Inventaris::find($produk->id);
                if ($inventaris) {
                    $inventaris->stok_saat_ini += $produk->pivot->quantity;

                    // Auto-update status based on stock level
                    if ($inventaris->stok_saat_ini <= 0) {
                        $inventaris->status = 'habis';
                    } elseif ($inventaris->stok_saat_ini <= $inventaris->stok_minimal) {
                        $inventaris->status = 'hampir_habis';
                    } else {
                        $inventaris->status = 'tersedia';
                    }

                    $inventaris->save();

                    Log::info('Stock restored after transaction deletion', [
                        'inventaris_id' => $inventaris->id,
                        'quantity_restored' => $produk->pivot->quantity,
                        'new_stock' => $inventaris->stok_saat_ini,
                        'new_status' => $inventaris->status
                    ]);
                }
            }

            $transaksi->delete();

            // Renumber remaining transactions to keep sequential order
            Transaksi::renumberTransactions();

            Log::info('Transaksi deleted successfully and transactions renumbered', ['id' => $transaksi->id]);

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
        // Gunakan method dari model untuk generate nomor transaksi
        return Transaksi::generateNomorTransaksi();
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

    /**
     * Get transaksi statistics by cabang
     */
    public function getTransaksiStatisticsByCabang($cabangId)
    {
        $today = Carbon::today();
        $thisMonth = Carbon::now()->startOfMonth();
        $thisYear = Carbon::now()->startOfYear();

        return [
            'total' => Transaksi::where('cabang_id', $cabangId)->count(),
            'today' => Transaksi::where('cabang_id', $cabangId)
                ->whereDate('created_at', $today)->count(),
            'this_month' => Transaksi::where('cabang_id', $cabangId)
                ->whereDate('created_at', '>=', $thisMonth)->count(),
            'this_year' => Transaksi::where('cabang_id', $cabangId)
                ->whereDate('created_at', '>=', $thisYear)->count(),
            'pending' => Transaksi::where('cabang_id', $cabangId)
                ->where('status', 'pending')->count(),
            'selesai' => Transaksi::where('cabang_id', $cabangId)
                ->where('status', 'selesai')->count(),
            'dibatalkan' => Transaksi::where('cabang_id', $cabangId)
                ->where('status', 'dibatalkan')->count(),
            'total_pendapatan_today' => Transaksi::where('cabang_id', $cabangId)
                ->whereDate('created_at', $today)
                ->where('status', 'selesai')
                ->sum('total_harga'),
            'total_pendapatan_month' => Transaksi::where('cabang_id', $cabangId)
                ->whereDate('created_at', '>=', $thisMonth)
                ->where('status', 'selesai')
                ->sum('total_harga'),
            'total_pendapatan_year' => Transaksi::where('cabang_id', $cabangId)
                ->whereDate('created_at', '>=', $thisYear)
                ->where('status', 'selesai')
                ->sum('total_harga')
        ];
    }
}
