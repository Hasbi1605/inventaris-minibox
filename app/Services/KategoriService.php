<?php

namespace App\Services;

use App\Models\Kategori;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Exception;

class KategoriService
{
    /**
     * Mendapatkan semua kategori berdasarkan jenis
     *
     * @param string|null $jenisKategori
     * @param bool $includeInactive
     * @return Collection
     */
    public function getKategoris(?string $jenisKategori = null, bool $includeInactive = false): Collection
    {
        $query = Kategori::withCount(['inventarises', 'layanan', 'pengeluarans'])->orderBy('urutan');

        if ($jenisKategori) {
            $query->where('jenis_kategori', $jenisKategori);
        }

        if (!$includeInactive) {
            $query->aktif();
        }

        return $query->get();
    }

    /**
     * Mendapatkan kategori dalam struktur hierarki
     *
     * @param string|null $jenisKategori
     * @return Collection
     */
    public function getKategoriHierarki(?string $jenisKategori = null): Collection
    {
        $query = Kategori::with(['children' => function ($q) {
            $q->aktif()->orderBy('urutan');
        }])->parent()->aktif()->orderBy('urutan');

        if ($jenisKategori) {
            $query->where('jenis_kategori', $jenisKategori);
        }

        return $query->get();
    }

    /**
     * Mendapatkan kategori berdasarkan ID
     *
     * @param int $id
     * @return Kategori|null
     */
    public function getKategoriById(int $id): ?Kategori
    {
        return Kategori::with('parent', 'children')->find($id);
    }

    /**
     * Membuat kategori baru
     *
     * @param array $data
     * @return Kategori
     * @throws Exception
     */
    public function createKategori(array $data): Kategori
    {
        DB::beginTransaction();

        try {
            // Generate kode kategori jika tidak ada
            if (empty($data['kode_kategori'])) {
                $data['kode_kategori'] = $this->generateKodeKategori($data['jenis_kategori']);
            }

            // Set urutan otomatis jika tidak ada
            if (empty($data['urutan'])) {
                $data['urutan'] = $this->getNextUrutan($data['jenis_kategori'], $data['parent_id'] ?? null);
            }

            $kategori = Kategori::create($data);

            DB::commit();
            return $kategori->load('parent', 'children');
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    /**
     * Update kategori
     *
     * @param int $id
     * @param array $data
     * @return Kategori
     * @throws Exception
     */
    public function updateKategori(int $id, array $data): Kategori
    {
        DB::beginTransaction();

        try {
            $kategori = Kategori::findOrFail($id);

            // Hapus kode_kategori dari data karena tidak boleh diubah
            unset($data['kode_kategori']);

            // Validasi parent kategori (tidak boleh circular reference)
            if (isset($data['parent_id']) && $data['parent_id']) {
                $this->validateParentKategori($id, $data['parent_id']);
            }

            $kategori->update($data);

            DB::commit();
            return $kategori->load('parent', 'children');
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    /**
     * Hapus kategori
     *
     * @param int $id
     * @return bool
     * @throws Exception
     */
    public function deleteKategori(int $id): bool
    {
        DB::beginTransaction();

        try {
            $kategori = Kategori::findOrFail($id);

            // Cek apakah kategori masih digunakan
            $this->checkKategoriUsage($kategori);

            // Jika ada child kategori, pindahkan ke parent atau null
            if ($kategori->isParent()) {
                $kategori->children()->update(['parent_id' => $kategori->parent_id]);
            }

            $kategori->delete();

            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    /**
     * Reorder kategori
     *
     * @param array $urutanIds
     * @return bool
     * @throws Exception
     */
    public function reorderKategori(array $urutanIds): bool
    {
        DB::beginTransaction();

        try {
            foreach ($urutanIds as $index => $id) {
                Kategori::where('id', $id)->update(['urutan' => $index + 1]);
            }

            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    /**
     * Generate kode kategori otomatis
     *
     * @param string $jenisKategori
     * @return string
     */
    private function generateKodeKategori(string $jenisKategori): string
    {
        $prefix = strtoupper(substr($jenisKategori, 0, 3));
        $lastKode = Kategori::where('jenis_kategori', $jenisKategori)
            ->where('kode_kategori', 'LIKE', $prefix . '%')
            ->orderBy('kode_kategori', 'desc')
            ->first();

        if ($lastKode) {
            $lastNumber = (int) substr($lastKode->kode_kategori, 3);
            $nextNumber = $lastNumber + 1;
        } else {
            $nextNumber = 1;
        }

        return $prefix . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
    }

    /**
     * Mendapatkan urutan selanjutnya
     *
     * @param string $jenisKategori
     * @param int|null $parentId
     * @return int
     */
    private function getNextUrutan(string $jenisKategori, ?int $parentId = null): int
    {
        $query = Kategori::where('jenis_kategori', $jenisKategori);

        if ($parentId) {
            $query->where('parent_id', $parentId);
        } else {
            $query->whereNull('parent_id');
        }

        $maxUrutan = $query->max('urutan') ?? 0;
        return $maxUrutan + 1;
    }

    /**
     * Validasi parent kategori untuk mencegah circular reference
     *
     * @param int $kategoriId
     * @param int $parentId
     * @throws Exception
     */
    private function validateParentKategori(int $kategoriId, int $parentId): void
    {
        if ($kategoriId === $parentId) {
            throw new Exception('Kategori tidak boleh menjadi parent dari dirinya sendiri');
        }

        $parent = Kategori::find($parentId);
        if ($parent && $this->isDescendant($kategoriId, $parentId)) {
            throw new Exception('Kategori tidak boleh menjadi parent dari kategori yang merupakan ancestornya');
        }
    }

    /**
     * Cek apakah kategori adalah descendant dari kategori lain
     *
     * @param int $ancestorId
     * @param int $descendantId
     * @return bool
     */
    private function isDescendant(int $ancestorId, int $descendantId): bool
    {
        $parent = Kategori::find($descendantId);

        while ($parent && $parent->parent_id) {
            if ($parent->parent_id === $ancestorId) {
                return true;
            }
            $parent = Kategori::find($parent->parent_id);
        }

        return false;
    }

    /**
     * Cek penggunaan kategori pada model lain
     *
     * @param Kategori $kategori
     * @throws Exception
     */
    private function checkKategoriUsage(Kategori $kategori): void
    {
        $usageCount = 0;
        $usedIn = [];

        // Cek penggunaan di inventaris
        if ($kategori->inventarises()->count() > 0) {
            $usageCount += $kategori->inventarises()->count();
            $usedIn[] = 'Inventaris';
        }

        // Cek penggunaan di layanan
        if ($kategori->layanan()->count() > 0) {
            $usageCount += $kategori->layanan()->count();
            $usedIn[] = 'Layanan';
        }

        // Cek penggunaan di pengeluaran
        if ($kategori->pengeluarans()->count() > 0) {
            $usageCount += $kategori->pengeluarans()->count();
            $usedIn[] = 'Pengeluaran';
        }

        if ($usageCount > 0) {
            $message = "Kategori '{$kategori->nama_kategori}' tidak dapat dihapus karena masih digunakan di: " . implode(', ', $usedIn);
            throw new Exception($message);
        }
    }

    /**
     * Mendapatkan statistik penggunaan kategori
     *
     * @param string|null $jenisKategori
     * @return array
     */
    public function getStatistikKategori(?string $jenisKategori = null): array
    {
        $query = Kategori::query();

        if ($jenisKategori) {
            $query->where('jenis_kategori', $jenisKategori);
        }

        $kategoris = $query->with(['inventarises', 'layanan', 'pengeluarans'])->get();

        $statistik = [];
        foreach ($kategoris as $kategori) {
            $statistik[] = [
                'kategori' => $kategori,
                'penggunaan' => [
                    'inventaris' => $kategori->inventarises->count(),
                    'layanan' => $kategori->layanan->count(),
                    'pengeluaran' => $kategori->pengeluarans->count()
                ],
                'total_penggunaan' => $kategori->inventarises->count() +
                    $kategori->layanan->count() +
                    $kategori->pengeluarans->count()
            ];
        }

        return $statistik;
    }
}
