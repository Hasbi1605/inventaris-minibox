<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Pengeluaran;
use App\Models\Cabang;
use App\Models\Kapster;
use App\Services\LaporanService;
use Carbon\Carbon;

class LaporanController extends Controller
{
    protected $laporanService;

    public function __construct(LaporanService $laporanService)
    {
        $this->laporanService = $laporanService;
    }

    /**
     * Display the laporan page.
     */
    public function index(Request $request)
    {
        // Get filter parameters
        $bulan = $request->get('bulan', Carbon::now()->month);
        $tahun = $request->get('tahun', Carbon::now()->year);
        $cabangId = $request->get('cabang_id');

        $startDate = Carbon::create($tahun, $bulan, 1)->startOfMonth();
        $endDate = Carbon::create($tahun, $bulan, 1)->endOfMonth();

        // Get current month data for statistics
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        // Statistics
        $totalPendapatan = Transaksi::whereBetween('tanggal_transaksi', [$startOfMonth, $endOfMonth])
            ->where('status', 'selesai')
            ->sum('total_harga');

        $totalPengeluaran = Pengeluaran::whereBetween('tanggal_pengeluaran', [$startOfMonth, $endOfMonth])
            ->sum('jumlah');

        $totalTransaksi = Transaksi::whereBetween('tanggal_transaksi', [$startOfMonth, $endOfMonth])
            ->where('status', 'selesai')
            ->count();

        $pendapatanBersih = $totalPendapatan - $totalPengeluaran;

        $statistics = [
            'total_pendapatan' => $totalPendapatan,
            'total_pengeluaran' => $totalPengeluaran,
            'total_transaksi' => $totalTransaksi,
            'pendapatan_bersih' => $pendapatanBersih,
        ];

        // Get branches and kapster for filter
        $cabangList = Cabang::orderBy('nama_cabang')->get();
        $kapsterList = Kapster::with('cabang')->orderBy('nama_kapster')->get();

        // Get all laporan data
        $laporanGaji = $this->laporanService->getLaporanGajiKapster($bulan, $tahun, $cabangId);
        $laporanKeuangan = $this->laporanService->getLaporanKeuangan($startDate, $endDate, $cabangId);
        $laporanCabang = $this->laporanService->getLaporanPerCabang($startDate, $endDate);
        $laporanLayanan = $this->laporanService->getLaporanLayanan($startDate, $endDate, $cabangId);
        $laporanInventaris = $this->laporanService->getLaporanInventaris($cabangId);
        $laporanCashFlow = $this->laporanService->getLaporanCashFlow($startDate, $endDate, $cabangId);
        $laporanCustomer = $this->laporanService->getLaporanCustomerBehavior($startDate, $endDate, $cabangId);

        return view('pages.laporan.index', compact(
            'statistics',
            'cabangList',
            'kapsterList',
            'laporanGaji',
            'laporanKeuangan',
            'laporanCabang',
            'laporanLayanan',
            'laporanInventaris',
            'laporanCashFlow',
            'laporanCustomer',
            'bulan',
            'tahun',
            'cabangId'
        ));
    }

    /**
     * Get laporan gaji kapster (for AJAX)
     */
    public function getGajiKapster(Request $request)
    {
        $bulan = $request->get('bulan', Carbon::now()->month);
        $tahun = $request->get('tahun', Carbon::now()->year);
        $cabangId = $request->get('cabang_id');
        $kapsterId = $request->get('kapster_id');

        $laporan = $this->laporanService->getLaporanGajiKapster($bulan, $tahun, $cabangId, $kapsterId);

        return response()->json($laporan);
    }

    /**
     * Get laporan keuangan (for AJAX)
     */
    public function getKeuangan(Request $request)
    {
        $startDate = $request->get('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));
        $cabangId = $request->get('cabang_id');

        $laporan = $this->laporanService->getLaporanKeuangan($startDate, $endDate, $cabangId);

        return response()->json($laporan);
    }

    /**
     * Export slip gaji (PDF)
     */
    public function exportSlipGaji(Request $request, $kapsterId)
    {
        $bulan = $request->get('bulan', Carbon::now()->month);
        $tahun = $request->get('tahun', Carbon::now()->year);

        $laporan = $this->laporanService->getLaporanGajiKapster($bulan, $tahun, null, $kapsterId);

        if ($laporan['data']->isEmpty()) {
            return back()->with('error', 'Data gaji tidak ditemukan');
        }

        $dataKapster = $laporan['data']->first();

        // TODO: Implement PDF generation
        // For now, return JSON
        return response()->json([
            'message' => 'Export PDF will be implemented',
            'data' => $dataKapster
        ]);
    }
}
