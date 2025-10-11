<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class ClearDashboardCache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dashboard:clear-cache';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear dashboard cache untuk reset data harian di jam 00:00 WIB';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            // Clear all dashboard related cache
            $cacheKeys = [
                'dashboard_statistics',
                'dashboard_grafik_pendapatan',
                'dashboard_pengeluaran',
                'dashboard_layanan_terlaris',
                'dashboard_performa_cabang',
                'dashboard_transaksi_terakhir',
                'dashboard_alerts',
                'dashboard_target_achievement',
                'dashboard_top_kapster',
                'dashboard_cash_flow',
                'dashboard_daily_pattern',
                'dashboard_profit_margin',
                'dashboard_weekly_comparison',
                'dashboard_kapster_utilization',
            ];

            foreach ($cacheKeys as $key) {
                Cache::forget($key);
            }

            // Clear all cache that starts with 'dashboard_'
            Cache::flush();

            $timestamp = now()->timezone('Asia/Jakarta')->format('Y-m-d H:i:s');

            Log::info("Dashboard cache cleared successfully at {$timestamp} WIB");
            $this->info("✅ Dashboard cache cleared successfully at {$timestamp} WIB");

            return Command::SUCCESS;
        } catch (\Exception $e) {
            Log::error("Error clearing dashboard cache: " . $e->getMessage());
            $this->error("❌ Error clearing dashboard cache: " . $e->getMessage());

            return Command::FAILURE;
        }
    }
}
