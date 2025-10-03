<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Pengeluaran;
use App\Models\Cabang;
use Carbon\Carbon;

class LaporanController extends Controller
{
    /**
     * Display the laporan page.
     */
    public function index()
    {
        // Get current month data
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        // Statistics
        $totalPendapatan = Transaksi::whereBetween('tanggal_transaksi', [$startOfMonth, $endOfMonth])
            ->sum('total_harga');

        $totalPengeluaran = Pengeluaran::whereBetween('tanggal_pengeluaran', [$startOfMonth, $endOfMonth])
            ->sum('jumlah');

        $totalTransaksi = Transaksi::whereBetween('tanggal_transaksi', [$startOfMonth, $endOfMonth])
            ->count();

        $pendapatanBersih = $totalPendapatan - $totalPengeluaran;

        $statistics = [
            'total_pendapatan' => $totalPendapatan,
            'total_pengeluaran' => $totalPengeluaran,
            'total_transaksi' => $totalTransaksi,
            'pendapatan_bersih' => $pendapatanBersih,
        ];

        // Get branches for filter
        $cabang = Cabang::orderBy('nama_cabang')->get();

        return view('pages.laporan.index', compact('statistics', 'cabang'));
    }
}
