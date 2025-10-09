<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use App\Services\LayananService;
use App\Services\CabangService;
use App\Http\Requests\LayananRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class KelolaLayananController extends Controller
{
    protected $layananService;
    protected $cabangService;

    public function __construct(LayananService $layananService, CabangService $cabangService)
    {
        $this->layananService = $layananService;
        $this->cabangService = $cabangService;
    }

    /**
     * Display a listing of the layanan.
     */
    public function index(Request $request)
    {
        $filters = $request->only(['search', 'kategori', 'status']);

        // Get all cabang untuk tab
        $cabangList = $this->cabangService->getAllCabangForDropdown();

        // Get semua layanan (untuk tab "Semua Cabang") with pagination
        $semuaLayanan = $this->layananService->getAllLayananWithCabang($filters, 10);

        // Get layanan per cabang with pagination
        $layananPerCabang = [];
        $statisticsPerCabang = [];
        foreach ($cabangList as $cabang) {
            $layananPerCabang[$cabang->id] = $this->layananService->getLayananByCabang($cabang->id, $filters, 10);
            $statisticsPerCabang[$cabang->id] = $this->layananService->getLayananStatisticsByCabang($cabang->id);
        }

        // Get statistics untuk semua cabang
        $statisticsSemuaCabang = $this->layananService->getLayananStatistics();
        $categories = $this->layananService->getAvailableCategories();

        return view('pages.kelola-layanan.index', compact(
            'semuaLayanan',
            'layananPerCabang',
            'statisticsSemuaCabang',
            'statisticsPerCabang',
            'categories',
            'cabangList',
            'filters'
        ));
    }

    /**
     * Show the form for creating a new layanan.
     */
    public function create()
    {
        $categories = $this->layananService->getAvailableCategories();
        $cabangList = $this->cabangService->getAllCabangForDropdown();
        return view('pages.kelola-layanan.create', compact('categories', 'cabangList'));
    }

    /**
     * Store a newly created layanan in storage.
     */
    public function store(LayananRequest $request)
    {
        try {
            // Get validated data from Form Request
            $validatedData = $request->validated();

            // Create layanan using service
            $this->layananService->createLayanan($validatedData);

            return redirect()->route('kelola-layanan.index')
                ->with('success', 'Layanan berhasil ditambahkan!');
        } catch (\Exception $e) {
            Log::error("Error creating layanan: " . $e->getMessage(), [
                'request' => $request->all(),
                'trace' => $e->getTraceAsString(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menambahkan layanan.')
                ->withInput();
        }
    }

    /**
     * Display the specified layanan.
     */
    public function show(string $id)
    {
        try {
            Log::info('Menampilkan layanan dengan ID: ' . $id);
            $layanan = Layanan::with('kategori')->findOrFail($id);
            return view('pages.kelola-layanan.show', compact('layanan'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error("Error menampilkan layanan: " . $e->getMessage(), [
                'request' => request()->all(),
                'trace' => $e->getTraceAsString(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            return redirect()->route('kelola-layanan.index')
                ->with('error', 'Layanan tidak ditemukan');
        }
    }

    /**
     * Show the form for editing the specified layanan.
     */
    public function edit(string $id)
    {
        try {
            Log::info('Menampilkan form edit untuk layanan dengan ID: ' . $id);
            $layanan = Layanan::with('cabangs')->findOrFail($id);
            $categories = $this->layananService->getAvailableCategories();
            $cabangList = $this->cabangService->getAllCabangForDropdown();
            return view('pages.kelola-layanan.edit', compact('layanan', 'categories', 'cabangList'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error("Error menampilkan form edit: " . $e->getMessage(), [
                'request' => request()->all(),
                'trace' => $e->getTraceAsString(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            return redirect()->route('kelola-layanan.index')
                ->with('error', 'Layanan tidak ditemukan');
        }
    }

    /**
     * Update the specified layanan in storage.
     */
    public function update(LayananRequest $request, string $id)
    {
        try {
            Log::info('Memperbarui layanan dengan ID: ' . $id);
            $layanan = Layanan::findOrFail($id);

            // Get validated data from Form Request
            $validatedData = $request->validated();

            // Update layanan using service
            $this->layananService->updateLayanan($validatedData, $layanan);

            return redirect()->route('kelola-layanan.index')
                ->with('success', 'Layanan berhasil diperbarui!');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error("Error memperbarui layanan: " . $e->getMessage(), [
                'request' => $request->all(),
                'trace' => $e->getTraceAsString(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            return redirect()->route('kelola-layanan.index')
                ->with('error', 'Layanan tidak ditemukan');
        }
    }

    /**
     * Remove the specified layanan from storage.
     */
    public function destroy(string $id)
    {
        try {
            Log::info('Menghapus layanan dengan ID: ' . $id);
            $layanan = Layanan::findOrFail($id);

            // Delete layanan using service
            $this->layananService->deleteLayanan($layanan);

            return redirect()->route('kelola-layanan.index')
                ->with('success', 'Layanan berhasil dihapus!');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error("Error menghapus layanan: " . $e->getMessage(), [
                'request' => request()->all(),
                'trace' => $e->getTraceAsString(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            return redirect()->route('kelola-layanan.index')
                ->with('error', 'Layanan tidak ditemukan');
        }
    }
}
