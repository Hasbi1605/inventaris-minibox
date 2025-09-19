<?php

namespace App\Http\Controllers;

use App\Models\Inventaris;
use App\Services\InventarisService;
use App\Http\Requests\InventarisRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class KelolaInventarisController extends Controller
{
    protected $inventarisService;

    public function __construct(InventarisService $inventarisService)
    {
        $this->inventarisService = $inventarisService;
    }

    /**
     * Display a listing of the inventaris.
     */
    public function index(Request $request)
    {
        $filters = $request->only(['search', 'kategori', 'status']);
        $inventaris = $this->inventarisService->getAllInventaris($filters);
        $statistics = $this->inventarisService->getInventarisStatistics();
        $lowStockItems = $this->inventarisService->getLowStockItems();
        $nearExpiryItems = $this->inventarisService->getItemsNearExpiry();
        $categories = $this->inventarisService->getAvailableCategories();
        return view('pages.kelola-inventaris.index', compact('inventaris', 'statistics', 'lowStockItems', 'nearExpiryItems', 'categories', 'filters'));
    }

    /**
     * Show the form for creating a new inventaris.
     */
    public function create()
    {
        $categories = $this->inventarisService->getAvailableCategories();
        $units = $this->inventarisService->getAvailableUnits();
        return view('pages.kelola-inventaris.create', compact('categories', 'units'));
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
            return view('pages.kelola-inventaris.edit', compact('inventaris', 'categories', 'units'));
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
