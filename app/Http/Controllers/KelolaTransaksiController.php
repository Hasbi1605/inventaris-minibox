<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Kapster;
use App\Services\TransaksiService;
use App\Http\Requests\TransaksiRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class KelolaTransaksiController extends Controller
{
    protected $transaksiService;

    public function __construct(TransaksiService $transaksiService)
    {
        $this->transaksiService = $transaksiService;
    }

    /**
     * Display a listing of the transaksi.
     */
    public function index(Request $request)
    {
        $filters = $request->only(['search', 'kategori', 'status', 'tanggal_dari', 'tanggal_sampai']);
        $transaksi = $this->transaksiService->getAllTransaksi($filters);
        $statistics = $this->transaksiService->getTransaksiStatistics();
        $categories = $this->transaksiService->getAvailableCategories();
        return view('pages.kelola-transaksi.index', compact('transaksi', 'statistics', 'categories', 'filters'));
    }

    /**
     * Show the form for creating a new transaksi.
     */
    public function create()
    {
        $layanan = $this->transaksiService->getAvailableLayanan();
        $inventaris = $this->transaksiService->getAvailableInventaris();
        $kapster = Kapster::with('cabang')->where('status', 'aktif')->orderBy('nama_kapster')->get();
        return view('pages.kelola-transaksi.create', compact('layanan', 'inventaris', 'kapster'));
    }

    /**
     * Store a newly created transaksi in storage.
     */
    public function store(TransaksiRequest $request)
    {
        try {
            // Get validated data from Form Request
            $validatedData = $request->validated();

            // Create transaksi using service
            $this->transaksiService->createTransaksi($validatedData);

            return redirect()->route('kelola-transaksi.index')
                ->with('success', 'Transaksi berhasil ditambahkan!');
        } catch (\Exception $e) {
            Log::error("Error creating transaksi: " . $e->getMessage(), [
                'request' => $request->all(),
                'trace' => $e->getTraceAsString(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menambahkan transaksi.')
                ->withInput();
        }
    }

    /**
     * Display the specified transaksi.
     */
    public function show(string $id)
    {
        try {
            Log::info('Menampilkan transaksi dengan ID: ' . $id);
            $transaksi = Transaksi::with(['layanan', 'produk'])->findOrFail($id);
            return view('pages.kelola-transaksi.show', compact('transaksi'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error("Error menampilkan transaksi: " . $e->getMessage(), [
                'request' => request()->all(),
                'trace' => $e->getTraceAsString(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            return redirect()->route('kelola-transaksi.index')
                ->with('error', 'Transaksi tidak ditemukan');
        }
    }

    /**
     * Show the form for editing the specified transaksi.
     */
    public function edit(string $id)
    {
        try {
            Log::info('Menampilkan form edit untuk transaksi dengan ID: ' . $id);
            $transaksi = Transaksi::with(['layanan', 'produk'])->findOrFail($id);
            $layanan = $this->transaksiService->getAvailableLayanan();
            $inventaris = $this->transaksiService->getAvailableInventaris();
            $kapster = Kapster::with('cabang')->where('status', 'aktif')->orderBy('nama_kapster')->get();
            return view('pages.kelola-transaksi.edit', compact('transaksi', 'layanan', 'inventaris', 'kapster'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error("Error menampilkan form edit: " . $e->getMessage(), [
                'request' => request()->all(),
                'trace' => $e->getTraceAsString(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            return redirect()->route('kelola-transaksi.index')
                ->with('error', 'Transaksi tidak ditemukan');
        }
    }

    /**
     * Update the specified transaksi in storage.
     */
    public function update(TransaksiRequest $request, string $id)
    {
        try {
            Log::info('Memperbarui transaksi dengan ID: ' . $id);
            $transaksi = Transaksi::findOrFail($id);

            // Get validated data from Form Request
            $validatedData = $request->validated();

            // Update transaksi using service
            $this->transaksiService->updateTransaksi($validatedData, $transaksi);

            return redirect()->route('kelola-transaksi.index')
                ->with('success', 'Transaksi berhasil diperbarui!');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error("Error memperbarui transaksi: " . $e->getMessage(), [
                'request' => $request->all(),
                'trace' => $e->getTraceAsString(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            return redirect()->route('kelola-transaksi.index')
                ->with('error', 'Transaksi tidak ditemukan');
        }
    }

    /**
     * Remove the specified transaksi from storage.
     */
    public function destroy(string $id)
    {
        try {
            Log::info('Menghapus transaksi dengan ID: ' . $id);
            $transaksi = Transaksi::findOrFail($id);

            // Delete transaksi using service
            $this->transaksiService->deleteTransaksi($transaksi);

            return redirect()->route('kelola-transaksi.index')
                ->with('success', 'Transaksi berhasil dihapus!');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error("Error menghapus transaksi: " . $e->getMessage(), [
                'request' => request()->all(),
                'trace' => $e->getTraceAsString(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            return redirect()->route('kelola-transaksi.index')
                ->with('error', 'Transaksi tidak ditemukan');
        }
    }
}
