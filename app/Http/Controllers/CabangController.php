<?php

namespace App\Http\Controllers;

use App\Http\Requests\CabangRequest;
use App\Services\CabangService;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class CabangController extends Controller
{
    protected CabangService $cabangService;

    public function __construct(CabangService $cabangService)
    {
        $this->cabangService = $cabangService;
    }

    /**
     * Display a listing of cabang.
     */
    public function index(Request $request): View
    {
        $filters = $request->only(['status', 'tanggal_dari', 'tanggal_sampai', 'search']);
        $perPage = $request->get('per_page', 10);

        $cabang = $this->cabangService->getAllCabang($filters, $perPage);
        $statistics = $this->cabangService->getCabangStatistics();

        return view('pages.kelola-cabang.index', compact('cabang', 'statistics', 'filters'));
    }

    /**
     * Show the form for creating a new cabang.
     */
    public function create(): View
    {
        $statusOptions = [
            'aktif' => 'Aktif',
            'tidak_aktif' => 'Tidak Aktif',
            'maintenance' => 'Maintenance',
            'renovasi' => 'Renovasi',
        ];

        $kategori = Kategori::orderBy('nama_kategori')->get();

        return view('pages.kelola-cabang.create', compact('statusOptions', 'kategori'));
    }

    /**
     * Store a newly created cabang in storage.
     */
    public function store(CabangRequest $request): RedirectResponse
    {
        try {
            $cabang = $this->cabangService->createCabang($request->validated());

            if ($cabang) {
                return redirect()->route('kelola-cabang.index')
                    ->with('success', 'Cabang berhasil ditambahkan.');
            }

            return redirect()->back()
                ->with('error', 'Gagal menambahkan cabang.')
                ->withInput();
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified cabang.
     */
    public function show(int $id): View|RedirectResponse
    {
        try {
            $cabang = $this->cabangService->getCabangById($id);

            if (!$cabang) {
                return redirect()->route('kelola-cabang.index')
                    ->with('error', 'Cabang tidak ditemukan.');
            }

            return view('pages.kelola-cabang.show', compact('cabang'));
        } catch (\Exception $e) {
            return redirect()->route('kelola-cabang.index')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified cabang.
     */
    public function edit(int $id): View|RedirectResponse
    {
        try {
            $cabang = $this->cabangService->getCabangById($id);

            if (!$cabang) {
                return redirect()->route('kelola-cabang.index')
                    ->with('error', 'Cabang tidak ditemukan.');
            }

            $statusOptions = [
                'aktif' => 'Aktif',
                'tidak_aktif' => 'Tidak Aktif',
                'maintenance' => 'Maintenance',
                'renovasi' => 'Renovasi',
            ];

            return view('pages.kelola-cabang.edit', compact('cabang', 'statusOptions'));
        } catch (\Exception $e) {
            return redirect()->route('kelola-cabang.index')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified cabang in storage.
     */
    public function update(CabangRequest $request, int $id): RedirectResponse
    {
        try {
            $cabang = $this->cabangService->updateCabang($id, $request->validated());

            if ($cabang) {
                return redirect()->route('kelola-cabang.index')
                    ->with('success', 'Cabang berhasil diperbarui.');
            }

            return redirect()->back()
                ->with('error', 'Gagal memperbarui cabang.')
                ->withInput();
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified cabang from storage.
     */
    public function destroy(int $id): RedirectResponse
    {
        try {
            $success = $this->cabangService->deleteCabang($id);

            if ($success) {
                return redirect()->route('kelola-cabang.index')
                    ->with('success', 'Cabang berhasil dihapus.');
            }

            return redirect()->back()
                ->with('error', 'Gagal menghapus cabang.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Toggle cabang status.
     */
    public function toggleStatus(int $id): RedirectResponse
    {
        try {
            $cabang = $this->cabangService->toggleCabangStatus($id);

            if ($cabang) {
                $status = $cabang->status === 'aktif' ? 'aktif' : 'tidak aktif';
                return redirect()->back()
                    ->with('success', "Status cabang berhasil diubah menjadi {$status}.");
            }

            return redirect()->back()
                ->with('error', 'Gagal mengubah status cabang.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
