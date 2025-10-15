<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Kapster;
use App\Services\TransaksiService;
use App\Services\CabangService;
use App\Services\CabangLayananService;
use App\Http\Requests\TransaksiRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class KelolaTransaksiController extends Controller
{
    protected $transaksiService;
    protected $cabangService;
    protected $cabangLayananService;

    public function __construct(
        TransaksiService $transaksiService,
        CabangService $cabangService,
        CabangLayananService $cabangLayananService
    ) {
        $this->transaksiService = $transaksiService;
        $this->cabangService = $cabangService;
        $this->cabangLayananService = $cabangLayananService;
    }

    /**
     * Display a listing of the transaksi.
     */
    public function index(Request $request)
    {
        $filters = $request->only(['search', 'kategori', 'status', 'tanggal_dari', 'tanggal_sampai']);

        // Get all cabang untuk tab
        $cabangList = $this->cabangService->getAllCabangForDropdown();

        // Get semua transaksi (tanpa filter cabang) untuk tab "Semua Cabang" with pagination
        $semuaTransaksi = $this->transaksiService->getAllTransaksi($filters, 10);

        // Get transaksi per cabang with pagination
        $transaksiPerCabang = [];
        $statisticsPerCabang = [];
        foreach ($cabangList as $cabang) {
            $filtersCabang = array_merge($filters, ['cabang_id' => $cabang->id]);
            $transaksiPerCabang[$cabang->id] = $this->transaksiService->getAllTransaksi($filtersCabang, 10);
            $statisticsPerCabang[$cabang->id] = $this->transaksiService->getTransaksiStatisticsByCabang($cabang->id);
        }

        // Get statistics untuk semua cabang
        $statisticsSemuaCabang = $this->transaksiService->getTransaksiStatistics();
        $categories = $this->transaksiService->getAvailableCategories();

        return view('pages.kelola-transaksi.index', compact('semuaTransaksi', 'transaksiPerCabang', 'statisticsSemuaCabang', 'statisticsPerCabang', 'categories', 'cabangList', 'filters'));
    }

    /**
     * Show the form for creating a new transaksi.
     */
    public function create(Request $request)
    {
        $cabangId = $request->get('cabang_id');

        // Get layanan with prices for the selected cabang
        $layanan = $this->transaksiService->getAvailableLayananForCabang($cabangId);
        $inventaris = $this->transaksiService->getAvailableInventaris($cabangId);
        $kapster = Kapster::with('cabang')->where('status', 'aktif');

        // Filter kapster by cabang if selected
        if ($cabangId) {
            $kapster->where('cabang_id', $cabangId);
        }

        $kapster = $kapster->orderBy('nama_kapster')->get();
        $cabangList = $this->cabangService->getAllCabangForDropdown();

        return view('pages.kelola-transaksi.create', compact('layanan', 'inventaris', 'kapster', 'cabangList', 'cabangId'));
    }

    /**
     * Store a newly created transaksi in storage.
     */
    public function store(TransaksiRequest $request)
    {
        try {
            // Get validated data from Form Request
            $validatedData = $request->validated();

            // Get quantity of transactions to create
            $quantity = $validatedData['quantity_transaksi'] ?? 1;
            unset($validatedData['quantity_transaksi']); // Remove from data as it's not needed for individual transaction

            $createdTransactions = [];
            $errors = [];

            // Create multiple transactions
            for ($i = 0; $i < $quantity; $i++) {
                try {
                    // Create transaksi using service
                    $transaksi = $this->transaksiService->createTransaksi($validatedData);
                    $createdTransactions[] = $transaksi;
                } catch (\Exception $e) {
                    $errors[] = "Transaksi " . ($i + 1) . ": " . $e->getMessage();
                    Log::error("Error creating transaksi " . ($i + 1) . ": " . $e->getMessage(), [
                        'attempt' => $i + 1,
                        'data' => $validatedData,
                        'trace' => $e->getTraceAsString()
                    ]);
                }
            }

            // Check results
            $successCount = count($createdTransactions);
            $errorCount = count($errors);

            if ($successCount > 0 && $errorCount == 0) {
                // All successful
                return redirect()->route('kelola-transaksi.index')
                    ->with('success', "Berhasil membuat {$successCount} transaksi!");
            } elseif ($successCount > 0 && $errorCount > 0) {
                // Partial success
                $errorMessages = implode("\n", $errors);
                return redirect()->route('kelola-transaksi.index')
                    ->with('warning', "Berhasil membuat {$successCount} transaksi, namun {$errorCount} transaksi gagal:\n{$errorMessages}");
            } else {
                // All failed
                $errorMessages = implode("\n", $errors);
                return redirect()->back()
                    ->with('error', "Gagal membuat transaksi:\n{$errorMessages}")
                    ->withInput();
            }
        } catch (\Exception $e) {
            Log::error("Error in transaksi store: " . $e->getMessage(), [
                'request' => $request->all(),
                'trace' => $e->getTraceAsString(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menambahkan transaksi: ' . $e->getMessage())
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
            $transaksi = Transaksi::with(['layanan', 'produk', 'kapster', 'cabang'])->findOrFail($id);
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
            $transaksi = Transaksi::with(['layanan', 'produk', 'cabang'])->findOrFail($id);

            // Get layanan with prices for the transaksi's cabang
            $layanan = $this->transaksiService->getAvailableLayananForCabang($transaksi->cabang_id);
            $inventaris = $this->transaksiService->getAvailableInventaris($transaksi->cabang_id);
            $kapster = Kapster::with('cabang')
                ->where('status', 'aktif')
                ->where('cabang_id', $transaksi->cabang_id)
                ->orderBy('nama_kapster')
                ->get();
            $cabangList = $this->cabangService->getAllCabangForDropdown();

            return view('pages.kelola-transaksi.edit', compact('transaksi', 'layanan', 'inventaris', 'kapster', 'cabangList'));
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

    /**
     * Cetak struk transaksi
     */
    public function cetakStruk(string $id)
    {
        try {
            Log::info('Mencetak struk transaksi dengan ID: ' . $id);

            $transaksi = Transaksi::with(['layanan', 'cabang', 'kapster', 'produk'])->findOrFail($id);

            // Check if transaction is completed
            if ($transaksi->status !== 'selesai') {
                return redirect()->back()
                    ->with('error', 'Hanya transaksi dengan status "Selesai" yang dapat dicetak struknya.');
            }

            return view('pages.kelola-transaksi.cetak-struk', compact('transaksi'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error("Error mencetak struk: " . $e->getMessage(), [
                'id' => $id,
                'trace' => $e->getTraceAsString(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            return redirect()->route('kelola-transaksi.index')
                ->with('error', 'Transaksi tidak ditemukan');
        }
    }
}
