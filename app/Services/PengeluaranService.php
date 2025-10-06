<?php

namespace App\Services;

use App\Models\Pengeluaran;
use App\Models\Kategori;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class PengeluaranService
{
    /**
     * Get all pengeluaran with pagination and filtering
     *
     * @param array $filters
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getAllPengeluaran(array $filters = [], int $perPage = 10): LengthAwarePaginator
    {
        try {
            $query = Pengeluaran::query()->with('kategori');

            // Filter by kategori_id
            if (!empty($filters['kategori'])) {
                $query->where('kategori_id', $filters['kategori']);
            }

            // Filter by date range
            if (!empty($filters['tanggal_dari'])) {
                $query->whereDate('tanggal_pengeluaran', '>=', $filters['tanggal_dari']);
            }

            if (!empty($filters['tanggal_sampai'])) {
                $query->whereDate('tanggal_pengeluaran', '<=', $filters['tanggal_sampai']);
            }

            // Filter by amount range
            if (!empty($filters['jumlah_min'])) {
                $query->where('jumlah', '>=', $filters['jumlah_min']);
            }

            if (!empty($filters['jumlah_max'])) {
                $query->where('jumlah', '<=', $filters['jumlah_max']);
            }

            // Search in deskripsi and nama_pengeluaran
            if (!empty($filters['search'])) {
                $query->where(function ($q) use ($filters) {
                    $q->where('deskripsi', 'like', '%' . $filters['search'] . '%')
                        ->orWhere('nama_pengeluaran', 'like', '%' . $filters['search'] . '%');
                });
            }

            return $query->orderBy('tanggal_pengeluaran', 'desc')
                ->orderBy('created_at', 'desc')
                ->paginate($perPage);
        } catch (\Exception $e) {
            Log::error('Error getting pengeluaran: ' . $e->getMessage());
            return new LengthAwarePaginator([], 0, $perPage);
        }
    }

    /**
     * Get pengeluaran by ID
     *
     * @param int $id
     * @return Pengeluaran|null
     */
    public function getPengeluaranById(int $id): ?Pengeluaran
    {
        try {
            return Pengeluaran::findOrFail($id);
        } catch (\Exception $e) {
            Log::error('Error getting pengeluaran by ID: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Create new pengeluaran
     *
     * @param array $data
     * @return Pengeluaran|null
     */
    public function createPengeluaran(array $data): ?Pengeluaran
    {
        try {
            // Debug log untuk melihat data yang diterima
            Log::info('Creating pengeluaran with data:', $data);

            $pengeluaran = Pengeluaran::create([
                'nama_pengeluaran' => $data['deskripsi'],
                'kategori_id' => $data['kategori_id'],
                'jumlah' => $data['jumlah'],
                'tanggal_pengeluaran' => $data['tanggal_pengeluaran'],
                'deskripsi' => $data['catatan'] ?? null,
            ]);

            Log::info('Pengeluaran created successfully', ['id' => $pengeluaran->id]);
            return $pengeluaran;
        } catch (\Exception $e) {
            Log::error('Error creating pengeluaran: ' . $e->getMessage(), [
                'data' => $data,
                'trace' => $e->getTraceAsString(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            return null;
        }
    }

    /**
     * Update pengeluaran
     *
     * @param int $id
     * @param array $data
     * @return Pengeluaran|null
     */
    public function updatePengeluaran(int $id, array $data): ?Pengeluaran
    {
        try {
            $pengeluaran = Pengeluaran::findOrFail($id);

            $pengeluaran->update([
                'nama_pengeluaran' => $data['deskripsi'],
                'kategori_id' => $data['kategori_id'],
                'jumlah' => $data['jumlah'],
                'tanggal_pengeluaran' => $data['tanggal_pengeluaran'],
                'deskripsi' => $data['catatan'] ?? null,
            ]);

            Log::info('Pengeluaran updated successfully', ['id' => $pengeluaran->id]);
            return $pengeluaran->fresh();
        } catch (\Exception $e) {
            Log::error('Error updating pengeluaran: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Delete pengeluaran
     *
     * @param int $id
     * @return bool
     */
    public function deletePengeluaran(int $id): bool
    {
        try {
            $pengeluaran = Pengeluaran::findOrFail($id);
            $pengeluaran->delete();

            Log::info('Pengeluaran deleted successfully', ['id' => $id]);
            return true;
        } catch (\Exception $e) {
            Log::error('Error deleting pengeluaran: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Get pengeluaran statistics
     *
     * @return array
     */
    public function getPengeluaranStatistics(): array
    {
        try {
            $now = Carbon::now();

            // Total pengeluaran
            $totalPengeluaran = Pengeluaran::sum('jumlah');

            // Pengeluaran bulan ini
            $pengeluaranBulanIni = Pengeluaran::whereYear('tanggal_pengeluaran', $now->year)
                ->whereMonth('tanggal_pengeluaran', $now->month)
                ->sum('jumlah');

            // Pengeluaran hari ini
            $pengeluaranHariIni = Pengeluaran::whereDate('tanggal_pengeluaran', $now->toDateString())
                ->sum('jumlah');

            // Jumlah record pengeluaran
            $jumlahPengeluaran = Pengeluaran::count();

            // Kategori pengeluaran terbanyak
            $kategoriTerbanyak = Pengeluaran::selectRaw('kategori, COUNT(*) as count')
                ->groupBy('kategori')
                ->orderBy('count', 'desc')
                ->first();

            // Pengeluaran terbesar bulan ini
            $pengeluaranTerbesar = Pengeluaran::whereYear('tanggal_pengeluaran', $now->year)
                ->whereMonth('tanggal_pengeluaran', $now->month)
                ->orderBy('jumlah', 'desc')
                ->first();

            // Rata-rata pengeluaran per hari bulan ini
            $hariDalamBulan = $now->daysInMonth;
            $rataRataHarian = $pengeluaranBulanIni / $hariDalamBulan;

            return [
                'total_pengeluaran' => $totalPengeluaran,
                'pengeluaran_bulan_ini' => $pengeluaranBulanIni,
                'pengeluaran_hari_ini' => $pengeluaranHariIni,
                'jumlah_pengeluaran' => $jumlahPengeluaran,
                'kategori_terbanyak' => $kategoriTerbanyak?->kategori ?? 'Belum ada data',
                'pengeluaran_terbesar' => $pengeluaranTerbesar?->jumlah ?? 0,
                'rata_rata_harian' => round($rataRataHarian, 0),
            ];
        } catch (\Exception $e) {
            Log::error('Error getting pengeluaran statistics: ' . $e->getMessage());
            return [
                'total_pengeluaran' => 0,
                'pengeluaran_bulan_ini' => 0,
                'pengeluaran_hari_ini' => 0,
                'jumlah_pengeluaran' => 0,
                'kategori_terbanyak' => 'Error',
                'pengeluaran_terbesar' => 0,
                'rata_rata_harian' => 0,
            ];
        }
    }

    /**
     * Get pengeluaran by kategori
     *
     * @param string $kategori
     * @return Collection
     */
    public function getPengeluaranByKategori(string $kategori): Collection
    {
        try {
            return Pengeluaran::where('kategori', $kategori)
                ->orderBy('tanggal_pengeluaran', 'desc')
                ->get();
        } catch (\Exception $e) {
            Log::error('Error getting pengeluaran by kategori: ' . $e->getMessage());
            return collect([]);
        }
    }

    /**
     * Get available categories
     *
     * @return Collection
     */
    public function getAvailableCategories(): Collection
    {
        try {
            return Kategori::pengeluaran()
                ->aktif()
                ->orderBy('urutan')
                ->get()
                ->pluck('nama_kategori', 'id');
        } catch (\Exception $e) {
            Log::error('Error getting available categories: ' . $e->getMessage());
            return collect([]);
        }
    }

    /**
     * Get monthly expense summary
     *
     * @param int $year
     * @return array
     */
    public function getMonthlyExpenseSummary(int $year = null): array
    {
        try {
            $year = $year ?? Carbon::now()->year;

            $monthlyData = Pengeluaran::selectRaw('MONTH(tanggal_pengeluaran) as month, SUM(jumlah) as total')
                ->whereYear('tanggal_pengeluaran', $year)
                ->groupBy('month')
                ->orderBy('month')
                ->get()
                ->pluck('total', 'month')
                ->toArray();

            // Fill missing months with 0
            $result = [];
            for ($i = 1; $i <= 12; $i++) {
                $result[$i] = $monthlyData[$i] ?? 0;
            }

            return $result;
        } catch (\Exception $e) {
            Log::error('Error getting monthly expense summary: ' . $e->getMessage());
            return array_fill(1, 12, 0);
        }
    }
}
