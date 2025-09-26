<?php

namespace App\Services;

use App\Models\Cabang;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class CabangService
{
    /**
     * Get all cabang with pagination and filtering
     *
     * @param array $filters
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getAllCabang(array $filters = [], int $perPage = 10): LengthAwarePaginator
    {
        try {
            $query = Cabang::query();

            // Filter by status
            if (!empty($filters['status'])) {
                $query->where('status', $filters['status']);
            }

            // Filter by kategori
            if (!empty($filters['kategori_id'])) {
                $query->where('kategori_id', $filters['kategori_id']);
            }

            // Filter by manager
            if (!empty($filters['manager'])) {
                $query->where('manager', 'like', '%' . $filters['manager'] . '%');
            }

            // Filter by date range
            if (!empty($filters['tanggal_dari'])) {
                $query->whereDate('tanggal_buka', '>=', $filters['tanggal_dari']);
            }

            if (!empty($filters['tanggal_sampai'])) {
                $query->whereDate('tanggal_buka', '<=', $filters['tanggal_sampai']);
            }

            // Search in nama_cabang, alamat, or telepon
            if (!empty($filters['search'])) {
                $query->where(function ($q) use ($filters) {
                    $q->where('nama_cabang', 'like', '%' . $filters['search'] . '%')
                        ->orWhere('alamat', 'like', '%' . $filters['search'] . '%')
                        ->orWhere('telepon', 'like', '%' . $filters['search'] . '%')
                        ->orWhere('manager', 'like', '%' . $filters['search'] . '%');
                });
            }

            return $query->orderBy('status', 'desc')
                ->orderBy('tanggal_buka', 'desc')
                ->paginate($perPage);
        } catch (\Exception $e) {
            Log::error('Error getting cabang: ' . $e->getMessage());
            return new LengthAwarePaginator([], 0, $perPage);
        }
    }

    /**
     * Get cabang by ID
     *
     * @param int $id
     * @return Cabang|null
     */
    public function getCabangById(int $id): ?Cabang
    {
        try {
            return Cabang::findOrFail($id);
        } catch (\Exception $e) {
            Log::error('Error getting cabang by ID: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Create new cabang
     *
     * @param array $data
     * @return Cabang|null
     */
    public function createCabang(array $data): ?Cabang
    {
        try {
            $cabang = Cabang::create([
                'nama_cabang' => $data['nama_cabang'],
                'alamat' => $data['alamat'],
                'telepon' => $data['telepon'],
                'email' => $data['email'] ?? null,
                'manager' => $data['manager'],
                'status' => $data['status'],
                'tanggal_buka' => $data['tanggal_buka'],
                'jam_operasional_buka' => $data['jam_operasional_buka'] ?? null,
                'jam_operasional_tutup' => $data['jam_operasional_tutup'] ?? null,
                'deskripsi' => $data['deskripsi'] ?? null,
            ]);

            Log::info('Cabang created successfully', ['id' => $cabang->id]);
            return $cabang;
        } catch (\Exception $e) {
            Log::error('Error creating cabang: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Update cabang
     *
     * @param int $id
     * @param array $data
     * @return Cabang|null
     */
    public function updateCabang(int $id, array $data): ?Cabang
    {
        try {
            $cabang = Cabang::findOrFail($id);

            $cabang->update([
                'nama_cabang' => $data['nama_cabang'],
                'alamat' => $data['alamat'],
                'telepon' => $data['telepon'],
                'email' => $data['email'] ?? null,
                'manager' => $data['manager'],
                'status' => $data['status'],
                'tanggal_buka' => $data['tanggal_buka'],
                'jam_operasional_buka' => $data['jam_operasional_buka'] ?? null,
                'jam_operasional_tutup' => $data['jam_operasional_tutup'] ?? null,
                'deskripsi' => $data['deskripsi'] ?? null,
            ]);

            Log::info('Cabang updated successfully', ['id' => $cabang->id]);
            return $cabang->fresh();
        } catch (\Exception $e) {
            Log::error('Error updating cabang: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Delete cabang
     *
     * @param int $id
     * @return bool
     */
    public function deleteCabang(int $id): bool
    {
        try {
            $cabang = Cabang::findOrFail($id);
            $cabang->delete();

            Log::info('Cabang deleted successfully', ['id' => $id]);
            return true;
        } catch (\Exception $e) {
            Log::error('Error deleting cabang: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Get cabang statistics
     *
     * @return array
     */
    public function getCabangStatistics(): array
    {
        try {
            $now = Carbon::now();

            // Total cabang
            $totalCabang = Cabang::count();

            // Cabang aktif
            $cabangAktif = Cabang::where('status', 'aktif')->count();

            // Cabang tidak aktif
            $cabangTidakAktif = Cabang::where('status', '!=', 'aktif')->count();

            // Cabang baru (30 hari terakhir)
            $cabangBaru = Cabang::where('tanggal_buka', '>=', $now->subDays(30))->count();

            // Cabang sedang buka saat ini
            $cabangSedangBuka = 0;
            $currentTime = $now->format('H:i');

            $activeBranches = Cabang::where('status', 'aktif')
                ->whereNotNull('jam_operasional_buka')
                ->whereNotNull('jam_operasional_tutup')
                ->get();

            foreach ($activeBranches as $branch) {
                if ($currentTime >= $branch->jam_operasional_buka && $currentTime <= $branch->jam_operasional_tutup) {
                    $cabangSedangBuka++;
                }
            }

            // Rata-rata usia cabang (dalam hari)
            $rataRataUsia = 0;
            if ($totalCabang > 0) {
                $totalUsia = Cabang::whereNotNull('tanggal_buka')
                    ->get()
                    ->sum(function ($cabang) {
                        return $cabang->tanggal_buka->diffInDays(Carbon::now());
                    });
                $rataRataUsia = round($totalUsia / $totalCabang, 0);
            }

            return [
                'total_cabang' => $totalCabang,
                'cabang_aktif' => $cabangAktif,
                'cabang_tidak_aktif' => $cabangTidakAktif,
                'cabang_baru' => $cabangBaru,
                'cabang_sedang_buka' => $cabangSedangBuka,
                'rata_rata_usia' => $rataRataUsia,
            ];
        } catch (\Exception $e) {
            Log::error('Error getting cabang statistics: ' . $e->getMessage());
            return [
                'total_cabang' => 0,
                'cabang_aktif' => 0,
                'cabang_tidak_aktif' => 0,
                'cabang_baru' => 0,
                'cabang_sedang_buka' => 0,
                'rata_rata_usia' => 0,
            ];
        }
    }

    /**
     * Get cabang by status
     *
     * @param string $status
     * @return Collection
     */
    public function getCabangByStatus(string $status): Collection
    {
        try {
            return Cabang::where('status', $status)
                ->orderBy('nama_cabang')
                ->get();
        } catch (\Exception $e) {
            Log::error('Error getting cabang by status: ' . $e->getMessage());
            return collect([]);
        }
    }

    /**
     * Get active cabang
     *
     * @return Collection
     */
    public function getActiveCabang(): Collection
    {
        return $this->getCabangByStatus('aktif');
    }

    /**
     * Get available managers
     *
     * @return Collection
     */
    public function getAvailableManagers(): Collection
    {
        try {
            return Cabang::select('manager')
                ->distinct()
                ->whereNotNull('manager')
                ->orderBy('manager')
                ->pluck('manager');
        } catch (\Exception $e) {
            Log::error('Error getting available managers: ' . $e->getMessage());
            return collect([]);
        }
    }

    /**
     * Get cabang with operating hours
     *
     * @return Collection
     */
    public function getCabangWithOperatingHours(): Collection
    {
        try {
            return Cabang::where('status', 'aktif')
                ->whereNotNull('jam_operasional_buka')
                ->whereNotNull('jam_operasional_tutup')
                ->orderBy('jam_operasional_buka')
                ->get();
        } catch (\Exception $e) {
            Log::error('Error getting cabang with operating hours: ' . $e->getMessage());
            return collect([]);
        }
    }

    /**
     * Toggle cabang status
     *
     * @param int $id
     * @return Cabang|null
     */
    public function toggleCabangStatus(int $id): ?Cabang
    {
        try {
            $cabang = Cabang::findOrFail($id);
            $newStatus = $cabang->status === 'aktif' ? 'tidak_aktif' : 'aktif';

            $cabang->update(['status' => $newStatus]);

            Log::info('Cabang status toggled', ['id' => $id, 'old_status' => $cabang->status, 'new_status' => $newStatus]);
            return $cabang->fresh();
        } catch (\Exception $e) {
            Log::error('Error toggling cabang status: ' . $e->getMessage());
            return null;
        }
    }
}
