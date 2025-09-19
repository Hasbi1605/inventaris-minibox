<?php

namespace App\Http\Controllers;

use App\Http\Requests\KategoriStoreRequest;
use App\Http\Requests\KategoriUpdateRequest;
use App\Models\Kategori;
use App\Services\KategoriService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Exception;

class KategoriController extends Controller
{
    protected KategoriService $kategoriService;

    public function __construct(KategoriService $kategoriService)
    {
        $this->kategoriService = $kategoriService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $jenisKategori = $request->get('jenis');
        $includeInactive = $request->boolean('include_inactive');

        $kategoris = $this->kategoriService->getKategoris($jenisKategori, $includeInactive);
        $jenisOptions = Kategori::getJenisKategori();
        $statistik = $this->kategoriService->getStatistikKategori($jenisKategori);

        return view('pages.kelola-kategori.index', compact(
            'kategoris',
            'jenisOptions',
            'jenisKategori',
            'statistik',
            'includeInactive'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $jenisKategori = $request->get('jenis');
        $parentId = $request->get('parent_id');

        $jenisOptions = Kategori::getJenisKategori();
        $parentKategoris = [];

        if ($jenisKategori) {
            $parentKategoris = $this->kategoriService->getKategoris($jenisKategori, false);
        }

        return view('pages.kelola-kategori.create', compact(
            'jenisOptions',
            'parentKategoris',
            'jenisKategori',
            'parentId'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(KategoriStoreRequest $request): RedirectResponse
    {
        try {
            $kategori = $this->kategoriService->createKategori($request->validated());

            return redirect()
                ->route('kelola-kategori.index', ['jenis' => $kategori->jenis_kategori])
                ->with('success', "Kategori '{$kategori->nama_kategori}' berhasil dibuat.");
        } catch (Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal membuat kategori: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): View
    {
        $kategori = $this->kategoriService->getKategoriById($id);

        if (!$kategori) {
            abort(404, 'Kategori tidak ditemukan');
        }

        $statistik = [
            'inventaris' => $kategori->inventarises()->count(),
            'layanan' => $kategori->layanan()->count(),
            'pengeluaran' => $kategori->pengeluarans()->count()
        ];

        return view('pages.kelola-kategori.show', compact('kategori', 'statistik'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id): View
    {
        $kategori = $this->kategoriService->getKategoriById($id);

        if (!$kategori) {
            abort(404, 'Kategori tidak ditemukan');
        }

        $jenisOptions = Kategori::getJenisKategori();
        $parentKategoris = $this->kategoriService->getKategoris($kategori->jenis_kategori, false)
            ->where('id', '!=', $id); // Exclude current kategori from parent options

        return view('pages.kelola-kategori.edit', compact(
            'kategori',
            'jenisOptions',
            'parentKategoris'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(KategoriUpdateRequest $request, int $id): RedirectResponse
    {
        try {
            $kategori = $this->kategoriService->updateKategori($id, $request->validated());

            return redirect()
                ->route('kelola-kategori.index', ['jenis' => $kategori->jenis_kategori])
                ->with('success', "Kategori '{$kategori->nama_kategori}' berhasil diperbarui.");
        } catch (Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui kategori: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): RedirectResponse
    {
        try {
            $kategori = $this->kategoriService->getKategoriById($id);

            if (!$kategori) {
                return redirect()
                    ->back()
                    ->with('error', 'Kategori tidak ditemukan.');
            }

            $jenisKategori = $kategori->jenis_kategori;
            $namaKategori = $kategori->nama_kategori;

            $this->kategoriService->deleteKategori($id);

            return redirect()
                ->route('kelola-kategori.index', ['jenis' => $jenisKategori])
                ->with('success', "Kategori '{$namaKategori}' berhasil dihapus.");
        } catch (Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Gagal menghapus kategori: ' . $e->getMessage());
        }
    }

    /**
     * Reorder kategori berdasarkan drag and drop
     */
    public function reorder(Request $request)
    {
        try {
            $request->validate([
                'urutan_ids' => 'required|array',
                'urutan_ids.*' => 'integer|exists:kategoris,id'
            ]);

            $this->kategoriService->reorderKategori($request->urutan_ids);

            return response()->json([
                'success' => true,
                'message' => 'Urutan kategori berhasil diperbarui.'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui urutan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get kategori berdasarkan jenis untuk AJAX
     */
    public function getByJenis(Request $request)
    {
        $jenisKategori = $request->get('jenis');

        if (!$jenisKategori) {
            return response()->json([
                'success' => false,
                'message' => 'Jenis kategori tidak boleh kosong.'
            ], 400);
        }

        $kategoris = $this->kategoriService->getKategoris($jenisKategori);

        return response()->json([
            'success' => true,
            'data' => $kategoris->map(function ($kategori) {
                return [
                    'id' => $kategori->id,
                    'nama_kategori' => $kategori->nama_kategori,
                    'nama_lengkap' => $kategori->nama_lengkap,
                    'parent_id' => $kategori->parent_id
                ];
            })
        ]);
    }
}
