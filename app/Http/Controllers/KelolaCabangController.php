<?php

namespace App\Http\Controllers;

use App\Models\Cabang;
use App\Services\CabangService;
use App\Services\KategoriService;
use App\Http\Requests\CabangRequest;
use Illuminate\Http\Request;

class KelolaCabangController extends Controller
{
    protected $cabangService;
    protected $kategoriService;

    public function __construct(CabangService $cabangService, KategoriService $kategoriService)
    {
        $this->cabangService = $cabangService;
        $this->kategoriService = $kategoriService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filters = $request->only(['status', 'tanggal_dari', 'tanggal_sampai', 'search', 'kategori_id']);
        $cabang = $this->cabangService->getAllCabang($filters, 10);
        $statistics = $this->cabangService->getGeneralStatistics();

        // Perbaiki method call - gunakan getKategoris dengan parameter 'cabang'
        $kategori = $this->kategoriService->getKategoris('cabang');

        return view('pages.kelola-cabang.index', compact('cabang', 'statistics', 'kategori'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $statusOptions = Cabang::getStatusOptions();

        // Perbaiki method call - gunakan getKategoris dengan parameter 'cabang'
        $kategori = $this->kategoriService->getKategoris('cabang');

        return view('pages.kelola-cabang.create', compact('statusOptions', 'kategori'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CabangRequest $request)
    {
        try {
            $this->cabangService->createCabang($request->validated());
            return redirect()->route('kelola-cabang.index')
                ->with('success', 'Cabang berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Cabang $kelolaCabang)
    {
        return view('pages.kelola-cabang.show', [
            'cabang' => $kelolaCabang
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cabang $kelolaCabang)
    {
        $statusOptions = Cabang::getStatusOptions();

        // Perbaiki method call - gunakan getKategoris dengan parameter 'cabang'
        $kategori = $this->kategoriService->getKategoris('cabang');
        $cabang = $kelolaCabang; // Fix variable name

        return view('pages.kelola-cabang.edit', compact('cabang', 'statusOptions', 'kategori'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CabangRequest $request, Cabang $kelolaCabang)
    {
        try {
            $this->cabangService->updateCabang($kelolaCabang->id, $request->validated());
            return redirect()->route('kelola-cabang.index')
                ->with('success', 'Cabang berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cabang $kelolaCabang)
    {
        try {
            $this->cabangService->deleteCabang($kelolaCabang->id);
            return redirect()->route('kelola-cabang.index')
                ->with('success', 'Cabang berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Toggle the status of the specified resource.
     */
    public function toggleStatus(Cabang $kelolaCabang)
    {
        try {
            $updatedCabang = $this->cabangService->toggleCabangStatus($kelolaCabang->id);

            if (!$updatedCabang) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal mengubah status cabang!'
                ], 500);
            }

            $statusText = $updatedCabang->status === 'aktif' ? 'diaktifkan' : 'dinonaktifkan';

            return response()->json([
                'success' => true,
                'message' => "Cabang berhasil {$statusText}!",
                'new_status' => $updatedCabang->status,
                'status_badge' => $updatedCabang->status_badge
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}
