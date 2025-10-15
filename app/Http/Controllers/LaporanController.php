<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Transaksi;
use App\Models\Pengeluaran;
use App\Models\Cabang;
use App\Models\Kapster;
use App\Services\LaporanService;
use App\Exports\LaporanExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
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

        $kapster = $laporan['data']->first();

        // Get transaksi detail for this kapster
        $startDate = Carbon::create($tahun, $bulan, 1)->startOfMonth();
        $endDate = Carbon::create($tahun, $bulan, 1)->endOfMonth();

        $transaksi = Transaksi::where('kapster_id', $kapsterId)
            ->whereBetween('tanggal_transaksi', [$startDate, $endDate])
            ->where('status', 'selesai')
            ->with(['layanan.kategori', 'layanan.cabangs', 'produk', 'cabang'])
            ->orderBy('tanggal_transaksi', 'desc')
            ->get();

        $periode = Carbon::create($tahun, $bulan, 1)->format('F Y');

        $pdf = Pdf::loadView('pages.laporan.pdf.slip-gaji', compact('kapster', 'transaksi', 'periode'));

        $filename = 'Slip-Gaji-' . str_replace(' ', '-', $kapster['nama_kapster']) . '-' . $bulan . '-' . $tahun . '.pdf';

        return $pdf->download($filename);
    }

    /**
     * Export all slip gaji (PDF ZIP)
     */
    public function exportAllSlipGaji(Request $request)
    {
        $bulan = $request->get('bulan', Carbon::now()->month);
        $tahun = $request->get('tahun', Carbon::now()->year);
        $cabangId = $request->get('cabang_id');

        $laporan = $this->laporanService->getLaporanGajiKapster($bulan, $tahun, $cabangId);

        if ($laporan['data']->isEmpty()) {
            return back()->with('error', 'Tidak ada data gaji untuk periode ini');
        }

        $periode = Carbon::create($tahun, $bulan, 1)->format('F Y');
        $startDate = Carbon::create($tahun, $bulan, 1)->startOfMonth();
        $endDate = Carbon::create($tahun, $bulan, 1)->endOfMonth();

        // Create ZIP file
        $zipFileName = 'Slip-Gaji-Semua-' . $bulan . '-' . $tahun . '.zip';
        $zip = new \ZipArchive();
        $zipPath = storage_path('app/temp/' . $zipFileName);

        // Create temp directory if not exists
        if (!file_exists(storage_path('app/temp'))) {
            mkdir(storage_path('app/temp'), 0755, true);
        }

        // Open ZIP file
        $zipOpenResult = $zip->open($zipPath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

        if ($zipOpenResult !== TRUE) {
            return back()->with('error', 'Gagal membuat file ZIP. Error code: ' . $zipOpenResult);
        }

        $pdfCount = 0;

        foreach ($laporan['data'] as $kapster) {
            try {
                // Skip if no kapster_id
                if (!isset($kapster['kapster_id']) || !isset($kapster['nama_kapster'])) {
                    continue;
                }

                // Get transaksi for this kapster
                $transaksi = Transaksi::where('kapster_id', $kapster['kapster_id'])
                    ->whereBetween('tanggal_transaksi', [$startDate, $endDate])
                    ->where('status', 'selesai')
                    ->with(['layanan.kategori', 'layanan.cabangs', 'produk', 'cabang'])
                    ->orderBy('tanggal_transaksi', 'desc')
                    ->get();

                // Generate PDF
                $pdf = Pdf::loadView('pages.laporan.pdf.slip-gaji', compact('kapster', 'transaksi', 'periode'));
                $pdfContent = $pdf->output();

                $filename = 'Slip-Gaji-' . str_replace(' ', '-', $kapster['nama_kapster']) . '.pdf';
                $zip->addFromString($filename, $pdfContent);
                $pdfCount++;
            } catch (\Exception $e) {
                // Log error but continue with other PDFs
                Log::error('Error generating slip gaji for kapster: ' . ($kapster['nama_kapster'] ?? 'unknown'), [
                    'error' => $e->getMessage()
                ]);
                continue;
            }
        }

        $zip->close();

        // Check if ZIP file was created successfully
        if (!file_exists($zipPath)) {
            return back()->with('error', 'Gagal membuat file ZIP');
        }

        // Check if any PDFs were added
        if ($pdfCount === 0) {
            @unlink($zipPath); // Delete empty ZIP
            return back()->with('error', 'Tidak ada slip gaji yang berhasil dibuat');
        }

        // Return ZIP file with proper headers
        return response()->download($zipPath, $zipFileName, [
            'Content-Type' => 'application/zip',
            'Content-Disposition' => 'attachment; filename="' . $zipFileName . '"',
        ])->deleteFileAfterSend(true);
    }

    /**
     * Export laporan lengkap (PDF)
     */
    public function exportLaporanPDF(Request $request)
    {
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

        // Get all laporan data
        $laporanGaji = $this->laporanService->getLaporanGajiKapster($bulan, $tahun, $cabangId);
        $laporanKeuangan = $this->laporanService->getLaporanKeuangan($startDate, $endDate, $cabangId);
        $laporanCabang = $this->laporanService->getLaporanPerCabang($startDate, $endDate);
        $laporanLayanan = $this->laporanService->getLaporanLayanan($startDate, $endDate, $cabangId);

        // Get detailed pengeluaran data
        $pengeluaranDetail = Pengeluaran::with(['kategori', 'cabang'])
            ->whereBetween('tanggal_pengeluaran', [$startDate, $endDate])
            ->when($cabangId, function ($q) use ($cabangId) {
                $q->where('cabang_id', $cabangId);
            })
            ->orderBy('tanggal_pengeluaran', 'desc')
            ->get();

        $periode = Carbon::create($tahun, $bulan, 1)->format('F Y');

        $pdf = Pdf::loadView('pages.laporan.pdf.laporan-lengkap', compact(
            'statistics',
            'laporanGaji',
            'laporanKeuangan',
            'laporanCabang',
            'laporanLayanan',
            'pengeluaranDetail',
            'periode'
        ));

        $pdf->setPaper('a4', 'portrait');

        $filename = 'Laporan-Lengkap-' . $bulan . '-' . $tahun . '.pdf';

        return $pdf->download($filename);
    }

    /**
     * Export laporan to Excel
     */
    public function exportLaporanExcel(Request $request)
    {
        $bulan = $request->get('bulan', Carbon::now()->month);
        $tahun = $request->get('tahun', Carbon::now()->year);
        $cabangId = $request->get('cabang_id');
        $type = $request->get('type', 'gaji-kapster');

        $startDate = Carbon::create($tahun, $bulan, 1)->startOfMonth();
        $endDate = Carbon::create($tahun, $bulan, 1)->endOfMonth();
        $periode = Carbon::create($tahun, $bulan, 1)->format('F Y');

        // Get data based on type
        switch ($type) {
            case 'gaji-kapster':
                $laporan = $this->laporanService->getLaporanGajiKapster($bulan, $tahun, $cabangId);
                $data = $laporan['data'];
                break;
            case 'keuangan':
                $laporan = $this->laporanService->getLaporanKeuangan($startDate, $endDate, $cabangId);
                $data = $laporan['data'];
                break;
            case 'cabang':
                $laporan = $this->laporanService->getLaporanPerCabang($startDate, $endDate);
                $data = $laporan['data'];
                break;
            case 'layanan':
                $laporan = $this->laporanService->getLaporanLayanan($startDate, $endDate, $cabangId);
                $data = $laporan['data'];
                break;
            default:
                return back()->with('error', 'Tipe laporan tidak valid');
        }

        $filename = 'Laporan-' . ucfirst($type) . '-' . $bulan . '-' . $tahun . '.xlsx';

        return Excel::download(new LaporanExport($data, $type, $periode), $filename);
    }
}
