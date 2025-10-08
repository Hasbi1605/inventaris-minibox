<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DashboardService;

class DashboardController extends Controller
{
    protected $dashboardService;

    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    /**
     * Display the dashboard.
     */
    public function index()
    {
        // Get all dashboard data - FASE 1
        $statistics = $this->dashboardService->getStatisticsCards();
        $grafikPendapatan = $this->dashboardService->getGrafikPendapatan7Hari();
        $pengeluaran = $this->dashboardService->getPengeluaranBulanIni();
        $layananTerlaris = $this->dashboardService->getLayananTerlaris();
        $performaCabang = $this->dashboardService->getPerformaCabang();
        $transaksiTerakhir = $this->dashboardService->getTransaksiTerakhir();
        $alerts = $this->dashboardService->getAlerts();
        $targetAchievement = $this->dashboardService->getTargetAchievement();
        $topKapster = $this->dashboardService->getTopKapsterHariIni();
        $cashFlow = $this->dashboardService->getCashFlowHariIni();

        // Get FASE 2 data
        $dailyPattern = $this->dashboardService->getDailyPattern();
        $profitMargin = $this->dashboardService->getProfitMargin();
        $weeklyComparison = $this->dashboardService->getWeeklyComparison();
        $kapsterUtilization = $this->dashboardService->getKapsterUtilization();

        return view('dashboard', compact(
            'statistics',
            'grafikPendapatan',
            'pengeluaran',
            'layananTerlaris',
            'performaCabang',
            'transaksiTerakhir',
            'alerts',
            'targetAchievement',
            'topKapster',
            'cashFlow',
            'dailyPattern',
            'profitMargin',
            'weeklyComparison',
            'kapsterUtilization'
        ));
    }

    /**
     * Update target bulanan
     */
    public function updateTarget(Request $request)
    {
        $request->validate([
            'target_bulanan' => 'required|integer|min:0'
        ]);

        try {
            \App\Models\Setting::set(
                'target_bulanan',
                $request->target_bulanan,
                'Target pendapatan bulanan'
            );

            return response()->json([
                'success' => true,
                'message' => 'Target bulanan berhasil diperbarui'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui target: ' . $e->getMessage()
            ], 500);
        }
    }
}
