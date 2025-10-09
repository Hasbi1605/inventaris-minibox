<?php

namespace App\Http\Controllers;

use App\Models\Inventaris;
use App\Services\InventarisService;
use App\Services\CabangService;
use App\Http\Requests\InventarisRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class KelolaInventarisController extends Controller
{
    protected $inventarisService;
    protected $cabangService;

    public function __construct(InventarisService $inventarisService, CabangService $cabangService)
    {
        $this->inventarisService = $inventarisService;
        $this->cabangService = $cabangService;
    }

    /**
     * Display a listing of the inventaris.
     */
    public function index(Request $request)
    {
        $filters = $request->only(['search', 'kategori', 'status']);

        // Get all cabang for tabs
        $cabangList = $this->cabangService->getAllCabangForDropdown();

        // Get statistics for all cabang (untuk tab semua cabang)
        $statisticsSemuaCabang = $this->inventarisService->getInventarisStatistics();

        // Get all inventaris untuk semua cabang (produk + aset) with pagination
        $semuaInventaris = $this->inventarisService->getAllInventaris($filters, 10);

        // Get data per cabang (gabungan produk + aset) + statistics per cabang
        $inventarisPerCabang = [];
        $statisticsPerCabang = [];

        foreach ($cabangList as $cabang) {
            // Semua inventaris per cabang with pagination
            $filtersCabang = array_merge($filters, [
                'cabang_id' => $cabang->id
            ]);
            $inventarisPerCabang[$cabang->id] = $this->inventarisService->getInventarisByCabang($filtersCabang, 10);

            // Statistics per cabang
            $statisticsPerCabang[$cabang->id] = $this->inventarisService->getInventarisStatistics($cabang->id);
        }

        $categories = $this->inventarisService->getAvailableCategories();

        return view('pages.kelola-inventaris.index', compact(
            'semuaInventaris',
            'inventarisPerCabang',
            'statisticsSemuaCabang',
            'statisticsPerCabang',
            'categories',
            'cabangList',
            'filters'
        ));
    }

    /**
     * Show the form for creating a new inventaris.
     */
    public function create()
    {
        $categories = $this->inventarisService->getAvailableCategories();
        $units = $this->inventarisService->getAvailableUnits();
        $cabangList = $this->cabangService->getAllCabangForDropdown();

        return view('pages.kelola-inventaris.create', compact('categories', 'units', 'cabangList'));
    }

    /**
     * Store a newly created inventaris in storage.
     */
    public function store(InventarisRequest $request)
    {
        try {
            // Get validated data from Form Request
            $validatedData = $request->validated();

            // Create inventaris using service
            $this->inventarisService->createInventaris($validatedData);

            return redirect()->route('kelola-inventaris.index')
                ->with('success', 'Item inventaris berhasil ditambahkan!');
        } catch (\Exception $e) {
            Log::error("Error creating inventaris: " . $e->getMessage(), [
                'request' => $request->all(),
                'trace' => $e->getTraceAsString(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menambahkan item inventaris.')
                ->withInput();
        }
    }

    /**
     * Display the specified inventaris.
     */
    public function show(string $id)
    {
        try {
            Log::info('Menampilkan inventaris dengan ID: ' . $id);
            $inventaris = Inventaris::findOrFail($id);
            return view('pages.kelola-inventaris.show', compact('inventaris'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error("Error menampilkan inventaris: " . $e->getMessage(), [
                'request' => request()->all(),
                'trace' => $e->getTraceAsString(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            return redirect()->route('kelola-inventaris.index')
                ->with('error', 'Item inventaris tidak ditemukan');
        }
    }

    /**
     * Show the form for editing the specified inventaris.
     */
    public function edit(string $id)
    {
        try {
            Log::info('Menampilkan form edit untuk inventaris dengan ID: ' . $id);
            $inventaris = Inventaris::findOrFail($id);
            $categories = $this->inventarisService->getAvailableCategories();
            $units = $this->inventarisService->getAvailableUnits();
            $cabangList = $this->cabangService->getAllCabangForDropdown();

            return view('pages.kelola-inventaris.edit', compact('inventaris', 'categories', 'units', 'cabangList'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error("Error menampilkan form edit: " . $e->getMessage(), [
                'request' => request()->all(),
                'trace' => $e->getTraceAsString(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            return redirect()->route('kelola-inventaris.index')
                ->with('error', 'Item inventaris tidak ditemukan');
        }
    }

    /**
     * Update the specified inventaris in storage.
     */
    public function update(InventarisRequest $request, string $id)
    {
        try {
            Log::info('Memperbarui inventaris dengan ID: ' . $id);
            $inventaris = Inventaris::findOrFail($id);

            // Get validated data from Form Request
            $validatedData = $request->validated();

            // Update inventaris using service
            $this->inventarisService->updateInventaris($validatedData, $inventaris);

            return redirect()->route('kelola-inventaris.index')
                ->with('success', 'Item inventaris berhasil diperbarui!');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error("Error memperbarui inventaris: " . $e->getMessage(), [
                'request' => $request->all(),
                'trace' => $e->getTraceAsString(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            return redirect()->route('kelola-inventaris.index')
                ->with('error', 'Item inventaris tidak ditemukan');
        }
    }

    /**
     * Remove the specified inventaris from storage.
     */
    public function destroy(string $id)
    {
        try {
            Log::info('Menghapus inventaris dengan ID: ' . $id);
            $inventaris = Inventaris::findOrFail($id);

            // Delete inventaris using service
            $this->inventarisService->deleteInventaris($inventaris);

            return redirect()->route('kelola-inventaris.index')
                ->with('success', 'Item inventaris berhasil dihapus!');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error("Error menghapus inventaris: " . $e->getMessage(), [
                'request' => request()->all(),
                'trace' => $e->getTraceAsString(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            return redirect()->route('kelola-inventaris.index')
                ->with('error', 'Item inventaris tidak ditemukan');
        }
    }
}
