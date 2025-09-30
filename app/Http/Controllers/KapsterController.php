<?php

namespace App\Http\Controllers;

use App\Models\Kapster;
use App\Models\Cabang;
use App\Http\Requests\KapsterRequest;
use Illuminate\Http\Request;

class KapsterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Kapster::with(['cabang']);

        // Filter by cabang
        if ($request->filled('cabang_id')) {
            $query->where('cabang_id', $request->cabang_id);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search by name
        if ($request->filled('search')) {
            $query->where('nama_kapster', 'like', '%' . $request->search . '%');
        }

        $kapster = $query->orderBy('nama_kapster')->paginate(10);
        $cabang = Cabang::orderBy('nama_cabang')->get();

        return view('pages.kelola-kapster.index', compact('kapster', 'cabang'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $cabang = Cabang::where('status', 'aktif')->orderBy('nama_cabang')->get();
        $statusOptions = [
            'aktif' => 'Aktif',
            'tidak_aktif' => 'Tidak Aktif',
        ];

        return view('pages.kelola-kapster.create', compact('cabang', 'statusOptions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(KapsterRequest $request)
    {
        try {
            Kapster::create($request->validated());

            return redirect()
                ->route('kelola-kapster.index')
                ->with('success', 'Kapster berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal menambahkan kapster. ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Kapster $kelola_kapster)
    {
        $kelola_kapster->load(['cabang', 'transaksi' => function ($query) {
            $query->orderBy('tanggal_transaksi', 'desc')->limit(10);
        }]);

        return view('pages.kelola-kapster.show', compact('kelola_kapster'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kapster $kelola_kapster)
    {
        $cabang = Cabang::where('status', 'aktif')->orderBy('nama_cabang')->get();
        $statusOptions = [
            'aktif' => 'Aktif',
            'tidak_aktif' => 'Tidak Aktif',
        ];

        return view('pages.kelola-kapster.edit', compact('kelola_kapster', 'cabang', 'statusOptions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(KapsterRequest $request, Kapster $kelola_kapster)
    {
        try {
            $kelola_kapster->update($request->validated());

            return redirect()
                ->route('kelola-kapster.index')
                ->with('success', 'Kapster berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui kapster. ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kapster $kelola_kapster)
    {
        try {
            // Check if kapster has transactions
            if ($kelola_kapster->transaksi()->count() > 0) {
                return redirect()
                    ->back()
                    ->with('error', 'Tidak dapat menghapus kapster yang sudah memiliki transaksi.');
            }

            $kelola_kapster->delete();

            return redirect()
                ->route('kelola-kapster.index')
                ->with('success', 'Kapster berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Gagal menghapus kapster. ' . $e->getMessage());
        }
    }
}
