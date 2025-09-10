<?php

namespace App\Http\Controllers;

use App\Http\Requests\PengeluaranRequest;
use App\Services\PengeluaranService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class PengeluaranController extends Controller
{
    protected PengeluaranService $pengeluaranService;

    public function __construct(PengeluaranService $pengeluaranService)
    {
        $this->pengeluaranService = $pengeluaranService;
    }

    /**
     * Display a listing of pengeluaran.
     */
    public function index(Request $request): View
    {
        $filters = $request->only(['kategori', 'tanggal_dari', 'tanggal_sampai', 'jumlah_min', 'jumlah_max', 'search']);
        $perPage = $request->get('per_page', 10);

        $pengeluaran = $this->pengeluaranService->getAllPengeluaran($filters, $perPage);
        $statistics = $this->pengeluaranService->getPengeluaranStatistics();
        $categories = $this->pengeluaranService->getAvailableCategories();

        return view('pages.kelola-pengeluaran.index', compact('pengeluaran', 'statistics', 'categories', 'filters'));
    }

    /**
     * Show the form for creating a new pengeluaran.
     */
    public function create(): View
    {
        $categories = [
            'operasional' => 'Operasional',
            'inventaris' => 'Inventaris',
            'promosi' => 'Promosi & Marketing',
            'maintenance' => 'Maintenance',
            'gaji' => 'Gaji & Tunjangan',
            'utilitas' => 'Utilitas',
            'lainnya' => 'Lainnya',
        ];

        return view('pages.kelola-pengeluaran.create', compact('categories'));
    }

    /**
     * Store a newly created pengeluaran in storage.
     */
    public function store(PengeluaranRequest $request): RedirectResponse
    {
        try {
            $pengeluaran = $this->pengeluaranService->createPengeluaran($request->validated());

            if ($pengeluaran) {
                return redirect()->route('kelola-pengeluaran.index')
                    ->with('success', 'Pengeluaran berhasil ditambahkan.');
            }

            return redirect()->back()
                ->with('error', 'Gagal menambahkan pengeluaran.')
                ->withInput();
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified pengeluaran.
     */
    public function show(int $id): View|RedirectResponse
    {
        try {
            $pengeluaran = $this->pengeluaranService->getPengeluaranById($id);

            if (!$pengeluaran) {
                return redirect()->route('kelola-pengeluaran.index')
                    ->with('error', 'Pengeluaran tidak ditemukan.');
            }

            return view('pages.kelola-pengeluaran.show', compact('pengeluaran'));
        } catch (\Exception $e) {
            return redirect()->route('kelola-pengeluaran.index')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified pengeluaran.
     */
    public function edit(int $id): View|RedirectResponse
    {
        try {
            $pengeluaran = $this->pengeluaranService->getPengeluaranById($id);

            if (!$pengeluaran) {
                return redirect()->route('kelola-pengeluaran.index')
                    ->with('error', 'Pengeluaran tidak ditemukan.');
            }

            $categories = [
                'operasional' => 'Operasional',
                'inventaris' => 'Inventaris',
                'promosi' => 'Promosi & Marketing',
                'maintenance' => 'Maintenance',
                'gaji' => 'Gaji & Tunjangan',
                'utilitas' => 'Utilitas',
                'lainnya' => 'Lainnya',
            ];

            return view('pages.kelola-pengeluaran.edit', compact('pengeluaran', 'categories'));
        } catch (\Exception $e) {
            return redirect()->route('kelola-pengeluaran.index')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified pengeluaran in storage.
     */
    public function update(PengeluaranRequest $request, int $id): RedirectResponse
    {
        try {
            $pengeluaran = $this->pengeluaranService->updatePengeluaran($id, $request->validated());

            if ($pengeluaran) {
                return redirect()->route('kelola-pengeluaran.index')
                    ->with('success', 'Pengeluaran berhasil diperbarui.');
            }

            return redirect()->back()
                ->with('error', 'Gagal memperbarui pengeluaran.')
                ->withInput();
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified pengeluaran from storage.
     */
    public function destroy(int $id): RedirectResponse
    {
        try {
            $success = $this->pengeluaranService->deletePengeluaran($id);

            if ($success) {
                return redirect()->route('kelola-pengeluaran.index')
                    ->with('success', 'Pengeluaran berhasil dihapus.');
            }

            return redirect()->back()
                ->with('error', 'Gagal menghapus pengeluaran.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
