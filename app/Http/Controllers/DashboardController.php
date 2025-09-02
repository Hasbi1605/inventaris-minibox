<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Product;
use App\Models\Customer;
use App\Models\TransactionItem;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik hari ini
        $todayStats = $this->getTodayStats();

        // Statistik minggu ini
        $weekStats = $this->getWeekStats();

        // Statistik bulan ini
        $monthStats = $this->getMonthStats();

        // Grafik penjualan 7 hari terakhir
        $salesChart = $this->getSalesChart();

        // Top produk dan layanan
        $topItems = $this->getTopItems();

        // Produk dengan stok rendah
        $lowStockProducts = Product::lowStock()->active()->limit(5)->get();

        // Transaksi terbaru
        $recentTransactions = Transaction::with(['customer', 'user'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('dashboard', compact(
            'todayStats',
            'weekStats',
            'monthStats',
            'salesChart',
            'topItems',
            'lowStockProducts',
            'recentTransactions'
        ));
    }

    private function getTodayStats()
    {
        return [
            'total_sales' => Transaction::completed()->today()->sum('total'),
            'total_profit' => Transaction::completed()->today()->get()->sum('total_profit'),
            'transaction_count' => Transaction::completed()->today()->count(),
            'customer_count' => Transaction::completed()->today()->distinct('customer_id')->count('customer_id')
        ];
    }

    private function getWeekStats()
    {
        return [
            'total_sales' => Transaction::completed()->thisWeek()->sum('total'),
            'total_profit' => Transaction::completed()->thisWeek()->get()->sum('total_profit'),
            'transaction_count' => Transaction::completed()->thisWeek()->count(),
            'customer_count' => Transaction::completed()->thisWeek()->distinct('customer_id')->count('customer_id'),
            'avg_daily_sales' => Transaction::completed()->thisWeek()->sum('total') / 7,
            'growth_percentage' => $this->calculateGrowthPercentage('week')
        ];
    }

    private function getMonthStats()
    {
        return [
            'total_sales' => Transaction::completed()->thisMonth()->sum('total'),
            'total_profit' => Transaction::completed()->thisMonth()->get()->sum('total_profit'),
            'transaction_count' => Transaction::completed()->thisMonth()->count(),
            'customer_count' => Transaction::completed()->thisMonth()->distinct('customer_id')->count('customer_id'),
            'avg_daily_sales' => Transaction::completed()->thisMonth()->sum('total') / Carbon::now()->day,
            'growth_percentage' => $this->calculateGrowthPercentage('month')
        ];
    }

    private function calculateGrowthPercentage($period)
    {
        if ($period === 'week') {
            $currentWeek = Transaction::completed()->thisWeek()->sum('total');
            $lastWeek = Transaction::completed()
                ->whereBetween('transaction_date', [
                    now()->subWeek()->startOfWeek(),
                    now()->subWeek()->endOfWeek()
                ])
                ->sum('total');

            return $lastWeek > 0 ? (($currentWeek - $lastWeek) / $lastWeek) * 100 : 0;
        } else {
            $currentMonth = Transaction::completed()->thisMonth()->sum('total');
            $lastMonth = Transaction::completed()
                ->whereMonth('transaction_date', now()->subMonth()->month)
                ->whereYear('transaction_date', now()->subMonth()->year)
                ->sum('total');

            return $lastMonth > 0 ? (($currentMonth - $lastMonth) / $lastMonth) * 100 : 0;
        }
    }

    private function getSalesChart()
    {
        $data = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $sales = Transaction::completed()
                ->whereDate('transaction_date', $date)
                ->sum('total');

            $data[] = [
                'date' => $date->format('M d'),
                'sales' => $sales
            ];
        }
        return $data;
    }

    private function getTopItems()
    {
        // Top 5 layanan
        $topServices = TransactionItem::select('item_name', DB::raw('SUM(quantity) as total_sold'), DB::raw('SUM(subtotal) as total_revenue'))
            ->where('item_type', 'service')
            ->whereHas('transaction', function ($query) {
                $query->where('status', 'completed')->thisMonth();
            })
            ->groupBy('item_name')
            ->orderBy('total_sold', 'desc')
            ->limit(5)
            ->get();

        // Top 5 produk
        $topProducts = TransactionItem::select('item_name', DB::raw('SUM(quantity) as total_sold'), DB::raw('SUM(subtotal) as total_revenue'))
            ->where('item_type', 'product')
            ->whereHas('transaction', function ($query) {
                $query->where('status', 'completed')->thisMonth();
            })
            ->groupBy('item_name')
            ->orderBy('total_sold', 'desc')
            ->limit(5)
            ->get();

        return [
            'services' => $topServices,
            'products' => $topProducts
        ];
    }

    public function weeklyReport()
    {
        $weeks = [];
        for ($i = 3; $i >= 0; $i--) {
            $startDate = Carbon::now()->subWeeks($i)->startOfWeek();
            $endDate = Carbon::now()->subWeeks($i)->endOfWeek();

            $weekData = [
                'week' => $startDate->format('M d') . ' - ' . $endDate->format('M d'),
                'sales' => Transaction::completed()
                    ->whereBetween('transaction_date', [$startDate, $endDate])
                    ->sum('total'),
                'profit' => Transaction::completed()
                    ->whereBetween('transaction_date', [$startDate, $endDate])
                    ->get()
                    ->sum('total_profit'),
                'transactions' => Transaction::completed()
                    ->whereBetween('transaction_date', [$startDate, $endDate])
                    ->count(),
                'customers' => Transaction::completed()
                    ->whereBetween('transaction_date', [$startDate, $endDate])
                    ->distinct('customer_id')
                    ->count('customer_id')
            ];

            $weeks[] = $weekData;
        }

        return view('reports.weekly', compact('weeks'));
    }

    public function monthlyReport()
    {
        $months = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);

            $monthData = [
                'month' => $date->format('F Y'),
                'sales' => Transaction::completed()
                    ->whereMonth('transaction_date', $date->month)
                    ->whereYear('transaction_date', $date->year)
                    ->sum('total'),
                'profit' => Transaction::completed()
                    ->whereMonth('transaction_date', $date->month)
                    ->whereYear('transaction_date', $date->year)
                    ->get()
                    ->sum('total_profit'),
                'transactions' => Transaction::completed()
                    ->whereMonth('transaction_date', $date->month)
                    ->whereYear('transaction_date', $date->year)
                    ->count(),
                'customers' => Transaction::completed()
                    ->whereMonth('transaction_date', $date->month)
                    ->whereYear('transaction_date', $date->year)
                    ->distinct('customer_id')
                    ->count('customer_id')
            ];

            $months[] = $monthData;
        }

        return view('reports.monthly', compact('months'));
    }
}
