<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use App\Services\LayananService;
use App\Http\Requests\LayananRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class KelolaLayananController extends Controller
{
    protected $layananService;

    public function __construct(LayananService $layananService)
    {
        $this->layananService = $layananService;
    }

    /**
     * Display a listing of the layanan.
     */
    public function index(Request $request)
    {
        $filters = $request->only(['search', 'kategori', 'status']);
        $layanan = $this->layananService->getAllLayanan($filters);
        $statistics = $this->layananService->getLayananStatistics();
        $categories = $this->layananService->getAvailableCategories();
        return view('pages.kelola-layanan.index', compact('layanan', 'statistics', 'categories', 'filters'));
    }

    /**
     * Show the form for creating a new layanan.
     */
    public function create()
    {
        $categories = $this->layananService->getAvailableCategories();
        return view('pages.kelola-layanan.create', compact('categories'));
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
            $layanan = Layanan::findOrFail($id);
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
            $layanan = Layanan::findOrFail($id);
            $categories = $this->layananService->getAvailableCategories();
            return view('pages.kelola-layanan.edit', compact('layanan', 'categories'));
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
