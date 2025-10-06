<?php

namespace App\Http\Controllers;

use App\Models\Pengeluaran;
use App\Services\PengeluaranService;
use App\Http\Requests\PengeluaranRequest;
use Illuminate\Http\Request;

class KelolaPengeluaranController extends Controller
{
    protected $pengeluaranService;

    public function __construct(PengeluaranService $pengeluaranService)
    {
        $this->pengeluaranService = $pengeluaranService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filters = $request->only(['kategori', 'tanggal_dari', 'tanggal_sampai', 'jumlah_min', 'jumlah_max', 'search']);
        $pengeluaran = $this->pengeluaranService->getAllPengeluaran($filters, 10);
        $statistics = $this->pengeluaranService->getPengeluaranStatistics();
        $categories = $this->pengeluaranService->getAvailableCategories();

        return view('pages.kelola-pengeluaran.index', compact('pengeluaran', 'statistics', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = $this->pengeluaranService->getAvailableCategories();
        return view('pages.kelola-pengeluaran.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PengeluaranRequest $request)
    {
        try {
            $pengeluaran = $this->pengeluaranService->createPengeluaran($request->validated());

            if ($pengeluaran) {
                return redirect()->route('kelola-pengeluaran.index')
                    ->with('success', 'Pengeluaran berhasil ditambahkan!');
            } else {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Gagal menambahkan pengeluaran. Silakan coba lagi.');
            }
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Pengeluaran $kelolaPengeluaran)
    {
        // Load kategori relationship
        $kelolaPengeluaran->load('kategori');

        return view('pages.kelola-pengeluaran.show', [
            'pengeluaran' => $kelolaPengeluaran
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pengeluaran $kelolaPengeluaran)
    {
        $categories = $this->pengeluaranService->getAvailableCategories();
        $pengeluaran = $kelolaPengeluaran;
        return view('pages.kelola-pengeluaran.edit', compact('pengeluaran', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PengeluaranRequest $request, Pengeluaran $kelolaPengeluaran)
    {
        try {
            $updated = $this->pengeluaranService->updatePengeluaran($kelolaPengeluaran->id, $request->validated());

            if ($updated) {
                return redirect()->route('kelola-pengeluaran.show', $kelolaPengeluaran->id)
                    ->with('success', 'Pengeluaran berhasil diperbarui!');
            } else {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Gagal memperbarui pengeluaran. Silakan coba lagi.');
            }
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pengeluaran $kelolaPengeluaran)
    {
        try {
            $this->pengeluaranService->deletePengeluaran($kelolaPengeluaran->id);
            return redirect()->route('kelola-pengeluaran.index')
                ->with('success', 'Pengeluaran berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
