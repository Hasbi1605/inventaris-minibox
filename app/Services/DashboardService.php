<?php

namespace App\Services;

use App\Models\Transaksi;
use App\Models\Pengeluaran;
use App\Models\Cabang;
use App\Models\Kapster;
use App\Models\Layanan;
use App\Models\Inventaris;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardService
{
    /**
     * Get statistics cards data
     */
    public function getStatisticsCards()
    {
        $today = Carbon::today();
        $yesterday = Carbon::yesterday();
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();
        $lastMonth = Carbon::now()->subMonth();

        // Pendapatan Hari Ini
        $pendapatanHariIni = Transaksi::whereDate('tanggal_transaksi', $today)
            ->where('status', 'selesai')
            ->sum('total_harga');

        $pendapatanKemarin = Transaksi::whereDate('tanggal_transaksi', $yesterday)
            ->where('status', 'selesai')
            ->sum('total_harga');

        $pendapatanHariIniPercentage = $pendapatanKemarin > 0
            ? round((($pendapatanHariIni - $pendapatanKemarin) / $pendapatanKemarin) * 100, 1)
            : 0;

        // Transaksi Hari Ini
        $transaksiHariIni = Transaksi::whereDate('tanggal_transaksi', $today)
            ->where('status', 'selesai')
            ->count();

        $transaksiKemarin = Transaksi::whereDate('tanggal_transaksi', $yesterday)
            ->where('status', 'selesai')
            ->count();

        $transaksiHariIniPercentage = $transaksiKemarin > 0
            ? round((($transaksiHariIni - $transaksiKemarin) / $transaksiKemarin) * 100, 1)
            : 0;

        // Pendapatan Bulanan
        $pendapatanBulanan = Transaksi::whereBetween('tanggal_transaksi', [$startOfMonth, $endOfMonth])
            ->where('status', 'selesai')
            ->sum('total_harga');

        $pendapatanBulanLalu = Transaksi::whereYear('tanggal_transaksi', $lastMonth->year)
            ->whereMonth('tanggal_transaksi', $lastMonth->month)
            ->where('status', 'selesai')
            ->sum('total_harga');

        $pendapatanBulananPercentage = $pendapatanBulanLalu > 0
            ? round((($pendapatanBulanan - $pendapatanBulanLalu) / $pendapatanBulanLalu) * 100, 1)
            : 0;

        // Transaksi Bulanan
        $transaksiBulanan = Transaksi::whereBetween('tanggal_transaksi', [$startOfMonth, $endOfMonth])
            ->where('status', 'selesai')
            ->count();

        $transaksiBulanLalu = Transaksi::whereYear('tanggal_transaksi', $lastMonth->year)
            ->whereMonth('tanggal_transaksi', $lastMonth->month)
            ->where('status', 'selesai')
            ->count();

        $transaksiBulananPercentage = $transaksiBulanLalu > 0
            ? round((($transaksiBulanan - $transaksiBulanLalu) / $transaksiBulanLalu) * 100, 1)
            : 0;

        return [
            'pendapatan_hari_ini' => [
                'value' => $pendapatanHariIni,
                'percentage' => $pendapatanHariIniPercentage,
                'is_increase' => $pendapatanHariIniPercentage >= 0,
                'vs_yesterday' => $pendapatanKemarin,
            ],
            'transaksi_hari_ini' => [
                'value' => $transaksiHariIni,
                'percentage' => $transaksiHariIniPercentage,
                'is_increase' => $transaksiHariIniPercentage >= 0,
                'vs_yesterday' => $transaksiKemarin,
            ],
            'pendapatan_bulanan' => [
                'value' => $pendapatanBulanan,
                'percentage' => $pendapatanBulananPercentage,
                'is_increase' => $pendapatanBulananPercentage >= 0,
                'vs_last_month' => $pendapatanBulanLalu,
            ],
            'transaksi_bulanan' => [
                'value' => $transaksiBulanan,
                'percentage' => $transaksiBulananPercentage,
                'is_increase' => $transaksiBulananPercentage >= 0,
                'vs_last_month' => $transaksiBulanLalu,
            ],
        ];
    }

    /**
     * Get grafik pendapatan 7 hari terakhir
     */
    public function getGrafikPendapatan7Hari()
    {
        $labels = [];
        $data = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $labels[] = $date->format('d M');

            $pendapatan = Transaksi::whereDate('tanggal_transaksi', $date)
                ->where('status', 'selesai')
                ->sum('total_harga');

            $data[] = $pendapatan;
        }

        return [
            'labels' => $labels,
            'data' => $data,
        ];
    }

    /**
     * Get pengeluaran bulan ini dengan breakdown
     */
    public function getPengeluaranBulanIni()
    {
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();
        $lastMonth = Carbon::now()->subMonth();

        $totalPengeluaran = Pengeluaran::whereBetween('tanggal_pengeluaran', [$startOfMonth, $endOfMonth])
            ->sum('jumlah');

        $pengeluaranBulanLalu = Pengeluaran::whereYear('tanggal_pengeluaran', $lastMonth->year)
            ->whereMonth('tanggal_pengeluaran', $lastMonth->month)
            ->sum('jumlah');

        $percentage = $pengeluaranBulanLalu > 0
            ? round((($totalPengeluaran - $pengeluaranBulanLalu) / $pengeluaranBulanLalu) * 100, 1)
            : 0;

        // Breakdown per kategori
        $breakdown = Pengeluaran::with('kategori')
            ->whereBetween('tanggal_pengeluaran', [$startOfMonth, $endOfMonth])
            ->select('kategori_id', DB::raw('SUM(jumlah) as total'))
            ->groupBy('kategori_id')
            ->get()
            ->map(function ($item) use ($totalPengeluaran) {
                return [
                    'nama' => $item->kategori->nama_kategori ?? 'Lainnya',
                    'total' => $item->total,
                    'percentage' => $totalPengeluaran > 0 ? round(($item->total / $totalPengeluaran) * 100, 1) : 0,
                ];
            })
            ->sortByDesc('total')
            ->values();

        return [
            'total' => $totalPengeluaran,
            'percentage' => $percentage,
            'is_increase' => $percentage >= 0,
            'breakdown' => $breakdown,
        ];
    }

    /**
     * Get layanan terlaris bulan ini
     */
    public function getLayananTerlaris()
    {
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        $layanan = Transaksi::with('layanan')
            ->whereBetween('tanggal_transaksi', [$startOfMonth, $endOfMonth])
            ->where('status', 'selesai')
            ->select('layanan_id', DB::raw('COUNT(*) as jumlah'))
            ->groupBy('layanan_id')
            ->orderByDesc('jumlah')
            ->get();

        $totalTransaksi = $layanan->sum('jumlah');

        $data = $layanan->map(function ($item) use ($totalTransaksi) {
            return [
                'label' => $item->layanan->nama_layanan ?? 'Unknown',
                'value' => $totalTransaksi > 0 ? round(($item->jumlah / $totalTransaksi) * 100, 1) : 0,
                'count' => $item->jumlah,
            ];
        });

        // Assign colors
        $colors = ['#3B82F6', '#22C55E', '#9333EA', '#F97316', '#EF4444'];
        $result = $data->take(5)->values()->map(function ($item, $index) use ($colors) {
            $item['color'] = $colors[$index] ?? '#6B7280';
            return $item;
        });

        return [
            'data' => $result,
            'has_data' => $result->count() > 0,
            'top_service' => $result->first(),
        ];
    }

    /**
     * Get performa cabang bulan ini
     */
    public function getPerformaCabang()
    {
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        $cabangList = Cabang::all();

        $data = $cabangList->map(function ($cabang) use ($startOfMonth, $endOfMonth) {
            $pendapatan = Transaksi::where('cabang_id', $cabang->id)
                ->whereBetween('tanggal_transaksi', [$startOfMonth, $endOfMonth])
                ->where('status', 'selesai')
                ->sum('total_harga');

            $jumlahTransaksi = Transaksi::where('cabang_id', $cabang->id)
                ->whereBetween('tanggal_transaksi', [$startOfMonth, $endOfMonth])
                ->where('status', 'selesai')
                ->count();

            $rataRata = $jumlahTransaksi > 0 ? $pendapatan / $jumlahTransaksi : 0;

            return [
                'id' => $cabang->id,
                'nama_cabang' => $cabang->nama_cabang,
                'alamat' => $cabang->alamat,
                'pendapatan' => $pendapatan,
                'jumlah_transaksi' => $jumlahTransaksi,
                'rata_rata' => $rataRata,
            ];
        })->sortByDesc('pendapatan')->values();

        return $data;
    }

    /**
     * Get 5 transaksi terakhir
     */
    public function getTransaksiTerakhir()
    {
        $transaksi = Transaksi::with(['layanan', 'cabang'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $data = $transaksi->map(function ($item) {
            return [
                'id' => $item->id,
                'type' => 'income',
                'amount' => $item->total_harga,
                'description' => $item->layanan->nama_layanan ?? 'Transaksi',
                'date' => Carbon::parse($item->created_at)->format('d M Y, H:i'),
                'date_relative' => Carbon::parse($item->created_at)->diffForHumans(),
                'cabang' => $item->cabang->nama_cabang ?? '-',
            ];
        });

        // Add recent pengeluaran
        $pengeluaran = Pengeluaran::orderBy('created_at', 'desc')
            ->take(2)
            ->get();

        $pengeluaranData = $pengeluaran->map(function ($item) {
            return [
                'id' => $item->id,
                'type' => 'expense',
                'amount' => $item->jumlah,
                'description' => $item->nama_pengeluaran,
                'date' => Carbon::parse($item->created_at)->format('d M Y, H:i'),
                'date_relative' => Carbon::parse($item->created_at)->diffForHumans(),
                'cabang' => '-',
            ];
        });

        $combined = $data->concat($pengeluaranData)
            ->sortByDesc('date')
            ->take(5)
            ->values();

        return [
            'data' => $combined,
            'has_data' => $combined->count() > 0,
        ];
    }

    /**
     * Get alerts & notifications
     */
    public function getAlerts()
    {
        $alerts = [];

        // 1. Stok Menipis - hanya untuk produk retail (bukan operasional)
        $stokMenipis = Inventaris::where('stok_saat_ini', '<=', 3)
            ->whereHas('kategoriRelasi', function ($query) {
                $query->where('tipe_penggunaan', '!=', 'operasional');
            })
            ->count();

        if ($stokMenipis > 0) {
            $alerts[] = [
                'type' => 'danger',
                'icon' => 'fa-exclamation-circle',
                'message' => "{$stokMenipis} Produk stok menipis (perlu restock segera)",
                'action_url' => route('kelola-inventaris.index'),
                'action_text' => 'Lihat Inventaris',
            ];
        }

        // 2. Target Bulanan
        $targetBulanan = 50000000; // Could be from settings
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        $pendapatanBulanan = Transaksi::whereBetween('tanggal_transaksi', [$startOfMonth, $endOfMonth])
            ->where('status', 'selesai')
            ->sum('total_harga');

        $targetPercentage = round(($pendapatanBulanan / $targetBulanan) * 100, 1);
        $sisaHari = Carbon::now()->diffInDays($endOfMonth);

        if ($targetPercentage < 70 && $sisaHari <= 15) {
            $alerts[] = [
                'type' => 'warning',
                'icon' => 'fa-bullseye',
                'message' => "Target bulan ini baru {$targetPercentage}% ({$sisaHari} hari lagi)",
                'action_url' => route('laporan'),
                'action_text' => 'Lihat Laporan',
            ];
        }

        // 3. Kapster Tidak Produktif Hari Ini
        $today = Carbon::today();
        $kapsterTidakProduktif = Kapster::whereDoesntHave('transaksi', function ($q) use ($today) {
            $q->whereDate('tanggal_transaksi', $today)
                ->where('status', 'selesai');
        })->where('status', 'aktif')->count();

        if ($kapsterTidakProduktif > 0 && Carbon::now()->hour >= 12) {
            $alerts[] = [
                'type' => 'info',
                'icon' => 'fa-user-clock',
                'message' => "{$kapsterTidakProduktif} Kapster belum ada transaksi hari ini",
                'action_url' => route('kelola-kapster.index'),
                'action_text' => 'Lihat Kapster',
            ];
        }

        // 4. Transaksi Pending
        $transaksiPending = Transaksi::where('status', 'pending')
            ->whereDate('tanggal_transaksi', '>=', Carbon::now()->subDays(3))
            ->count();

        if ($transaksiPending > 0) {
            $alerts[] = [
                'type' => 'warning',
                'icon' => 'fa-clock',
                'message' => "{$transaksiPending} Transaksi pending perlu ditindaklanjuti",
                'action_url' => route('kelola-transaksi.index'),
                'action_text' => 'Lihat Transaksi',
            ];
        }

        // 5. Performa Cabang Menurun
        $lastWeek = Carbon::now()->subWeek();
        $twoWeeksAgo = Carbon::now()->subWeeks(2);

        foreach (Cabang::all() as $cabang) {
            $pendapatanMingguIni = Transaksi::where('cabang_id', $cabang->id)
                ->whereBetween('tanggal_transaksi', [$lastWeek, Carbon::now()])
                ->where('status', 'selesai')
                ->sum('total_harga');

            $pendapatanMingguLalu = Transaksi::where('cabang_id', $cabang->id)
                ->whereBetween('tanggal_transaksi', [$twoWeeksAgo, $lastWeek])
                ->where('status', 'selesai')
                ->sum('total_harga');

            if ($pendapatanMingguLalu > 0) {
                $penurunan = (($pendapatanMingguLalu - $pendapatanMingguIni) / $pendapatanMingguLalu) * 100;

                if ($penurunan > 15) {
                    $alerts[] = [
                        'type' => 'danger',
                        'icon' => 'fa-chart-line',
                        'message' => "{$cabang->nama_cabang}: Penurunan pendapatan " . round($penurunan, 1) . "% minggu ini",
                        'action_url' => route('kelola-cabang.show', $cabang->id),
                        'action_text' => 'Lihat Detail',
                    ];
                }
            }
        }

        return $alerts;
    }

    /**
     * Get target achievement
     */
    public function getTargetAchievement()
    {
        $targetBulanan = \App\Models\Setting::get('target_bulanan', 50000000);
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();
        $today = Carbon::now();

        $pendapatanBulanan = Transaksi::whereBetween('tanggal_transaksi', [$startOfMonth, $endOfMonth])
            ->where('status', 'selesai')
            ->sum('total_harga');

        $percentage = $targetBulanan > 0 ? round(($pendapatanBulanan / $targetBulanan) * 100, 1) : 0;
        $sisa = $targetBulanan - $pendapatanBulanan;

        // Hitung sisa hari dari hari ini sampai akhir bulan (inclusive)
        $sisaHari = $today->day == $endOfMonth->day ? 1 : ($endOfMonth->day - $today->day + 1);

        $perluPerHari = $sisaHari > 0 ? $sisa / $sisaHari : 0;

        return [
            'target' => $targetBulanan,
            'tercapai' => $pendapatanBulanan,
            'percentage' => $percentage,
            'sisa' => $sisa,
            'sisa_hari' => $sisaHari,
            'perlu_per_hari' => max(0, $perluPerHari), // Pastikan tidak negatif
            'status' => $percentage >= 100 ? 'achieved' : ($percentage >= 70 ? 'on_track' : 'behind'),
        ];
    }

    /**
     * Get top kapster hari ini
     */
    public function getTopKapsterHariIni()
    {
        $today = Carbon::today();

        $kapsterPerforma = Kapster::with(['transaksi' => function ($q) use ($today) {
            $q->whereDate('tanggal_transaksi', $today)
                ->where('status', 'selesai');
        }])->get()->map(function ($kapster) {
            $totalTransaksi = $kapster->transaksi->count();
            $totalPendapatan = $kapster->transaksi->sum('total_harga');

            return [
                'id' => $kapster->id,
                'nama' => $kapster->nama_kapster,
                'total_transaksi' => $totalTransaksi,
                'total_pendapatan' => $totalPendapatan,
                'cabang' => $kapster->cabang->nama_cabang ?? '-',
            ];
        })->sortByDesc('total_transaksi');

        $top3 = $kapsterPerforma->take(3)->values();
        $tidakAktif = $kapsterPerforma->where('total_transaksi', 0)->values();

        return [
            'top_3' => $top3,
            'tidak_aktif' => $tidakAktif,
            'has_data' => $top3->count() > 0,
        ];
    }

    /**
     * Get cash flow summary hari ini
     */
    public function getCashFlowHariIni()
    {
        $today = Carbon::today();

        $kasMasuk = Transaksi::whereDate('tanggal_transaksi', $today)
            ->where('status', 'selesai')
            ->sum('total_harga');

        $kasKeluar = Pengeluaran::whereDate('tanggal_pengeluaran', $today)
            ->sum('jumlah');

        $netFlow = $kasMasuk - $kasKeluar;

        // Metode pembayaran
        $metodePembayaran = Transaksi::whereDate('tanggal_transaksi', $today)
            ->where('status', 'selesai')
            ->select('metode_pembayaran', DB::raw('COUNT(*) as jumlah'), DB::raw('SUM(total_harga) as total'))
            ->groupBy('metode_pembayaran')
            ->get()
            ->map(function ($item) use ($kasMasuk) {
                return [
                    'metode' => $item->metode_pembayaran,
                    'jumlah' => $item->jumlah,
                    'total' => $item->total,
                    'percentage' => $kasMasuk > 0 ? round(($item->total / $kasMasuk) * 100, 1) : 0,
                ];
            });

        return [
            'kas_masuk' => $kasMasuk,
            'kas_keluar' => $kasKeluar,
            'net_flow' => $netFlow,
            'is_positive' => $netFlow >= 0,
            'metode_pembayaran' => $metodePembayaran,
        ];
    }

    /**
     * Get daily pattern (transaksi per hari dalam seminggu)
     * FASE 2 Feature
     */
    public function getDailyPattern()
    {
        // Ambil data 4 minggu terakhir untuk analisis
        $startDate = Carbon::now()->subWeeks(4);
        $endDate = Carbon::now();

        // Nama hari dalam Bahasa Indonesia
        $hariIndonesia = [
            'Sunday' => 'Minggu',
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu'
        ];

        // Query transaksi per hari
        $transaksiPerHari = Transaksi::whereBetween('tanggal_transaksi', [$startDate, $endDate])
            ->where('status', 'selesai')
            ->select(
                DB::raw('DAYOFWEEK(tanggal_transaksi) as day_number'),
                DB::raw('COUNT(*) as total_transaksi'),
                DB::raw('SUM(total_harga) as total_pendapatan'),
                DB::raw('AVG(total_harga) as rata_rata')
            )
            ->groupBy('day_number')
            ->orderBy('day_number')
            ->get();

        // Map ke format chart
        $daysOrder = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        $chartData = [];
        $transaksiData = [];
        $pendapatanData = [];

        // Initialize dengan 0
        foreach ($daysOrder as $day) {
            $chartData[$day] = [
                'transaksi' => 0,
                'pendapatan' => 0,
                'rata_rata' => 0
            ];
        }

        // Fill dengan data aktual
        foreach ($transaksiPerHari as $item) {
            // MySQL DAYOFWEEK: 1=Sunday, 2=Monday, ..., 7=Saturday
            $dayIndex = $item->day_number - 1; // Convert to 0-based index
            $dayName = $daysOrder[$dayIndex];

            $chartData[$dayName] = [
                'transaksi' => $item->total_transaksi,
                'pendapatan' => $item->total_pendapatan,
                'rata_rata' => round($item->rata_rata, 0)
            ];
        }

        // Prepare data untuk chart
        $labels = $daysOrder;
        $transaksiValues = array_column($chartData, 'transaksi');
        $pendapatanValues = array_column($chartData, 'pendapatan');

        // Cari hari tersibuk dan tersepi
        $hariTersibuk = null;
        $hariTersepi = null;
        $maxTransaksi = 0;
        $minTransaksi = PHP_INT_MAX;

        foreach ($chartData as $day => $data) {
            if ($data['transaksi'] > $maxTransaksi) {
                $maxTransaksi = $data['transaksi'];
                $hariTersibuk = [
                    'hari' => $day,
                    'transaksi' => $data['transaksi'],
                    'pendapatan' => $data['pendapatan']
                ];
            }

            if ($data['transaksi'] < $minTransaksi && $data['transaksi'] > 0) {
                $minTransaksi = $data['transaksi'];
                $hariTersepi = [
                    'hari' => $day,
                    'transaksi' => $data['transaksi'],
                    'pendapatan' => $data['pendapatan']
                ];
            }
        }

        // Rekomendasi jadwal shift
        $rekomendasi = $this->generateShiftRecommendation($chartData);

        return [
            'labels' => $labels,
            'transaksi' => $transaksiValues,
            'pendapatan' => $pendapatanValues,
            'detail' => $chartData,
            'hari_tersibuk' => $hariTersibuk,
            'hari_tersepi' => $hariTersepi,
            'rekomendasi' => $rekomendasi,
            'has_data' => array_sum($transaksiValues) > 0
        ];
    }

    /**
     * Generate shift recommendation based on daily pattern
     */
    private function generateShiftRecommendation($chartData)
    {
        $recommendations = [];

        foreach ($chartData as $day => $data) {
            if ($data['transaksi'] == 0) {
                $recommendations[] = [
                    'hari' => $day,
                    'level' => 'off',
                    'kapster' => 0,
                    'saran' => 'Hari libur atau tutup'
                ];
            } elseif ($data['transaksi'] <= 5) {
                $recommendations[] = [
                    'hari' => $day,
                    'level' => 'low',
                    'kapster' => 1,
                    'saran' => 'Shift minimal - 1 kapster'
                ];
            } elseif ($data['transaksi'] <= 15) {
                $recommendations[] = [
                    'hari' => $day,
                    'level' => 'medium',
                    'kapster' => 2,
                    'saran' => 'Shift normal - 2 kapster'
                ];
            } elseif ($data['transaksi'] <= 25) {
                $recommendations[] = [
                    'hari' => $day,
                    'level' => 'high',
                    'kapster' => 3,
                    'saran' => 'Shift sibuk - 3 kapster'
                ];
            } else {
                $recommendations[] = [
                    'hari' => $day,
                    'level' => 'very_high',
                    'kapster' => 4,
                    'saran' => 'Shift penuh - 4+ kapster'
                ];
            }
        }

        return $recommendations;
    }

    /**
     * Get profit margin indicator
     * FASE 2 Feature
     */
    public function getProfitMargin()
    {
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();
        $lastMonthStart = Carbon::now()->subMonth()->startOfMonth();
        $lastMonthEnd = Carbon::now()->subMonth()->endOfMonth();

        // Pendapatan bulan ini (Gross Revenue)
        $pendapatanBulanIni = Transaksi::whereBetween('tanggal_transaksi', [$startOfMonth, $endOfMonth])
            ->where('status', 'selesai')
            ->sum('total_harga');

        // Pengeluaran bulan ini
        $pengeluaranBulanIni = Pengeluaran::whereBetween('tanggal_pengeluaran', [$startOfMonth, $endOfMonth])
            ->sum('jumlah');

        // Net Profit
        $netProfit = $pendapatanBulanIni - $pengeluaranBulanIni;

        // Profit Margin Percentage
        $profitMarginPercentage = $pendapatanBulanIni > 0
            ? round(($netProfit / $pendapatanBulanIni) * 100, 1)
            : 0;

        // Comparison dengan bulan lalu
        $pendapatanBulanLalu = Transaksi::whereBetween('tanggal_transaksi', [$lastMonthStart, $lastMonthEnd])
            ->where('status', 'selesai')
            ->sum('total_harga');

        $pengeluaranBulanLalu = Pengeluaran::whereBetween('tanggal_pengeluaran', [$lastMonthStart, $lastMonthEnd])
            ->sum('jumlah');

        $netProfitBulanLalu = $pendapatanBulanLalu - $pengeluaranBulanLalu;

        $profitChange = $netProfitBulanLalu > 0
            ? round((($netProfit - $netProfitBulanLalu) / $netProfitBulanLalu) * 100, 1)
            : 0;

        // Health Status
        $healthStatus = 'poor';
        $healthColor = 'red';
        $healthIcon = 'fa-exclamation-triangle';

        if ($profitMarginPercentage >= 40) {
            $healthStatus = 'excellent';
            $healthColor = 'green';
            $healthIcon = 'fa-check-circle';
        } elseif ($profitMarginPercentage >= 25) {
            $healthStatus = 'good';
            $healthColor = 'blue';
            $healthIcon = 'fa-thumbs-up';
        } elseif ($profitMarginPercentage >= 15) {
            $healthStatus = 'fair';
            $healthColor = 'yellow';
            $healthIcon = 'fa-info-circle';
        }

        return [
            'gross_revenue' => $pendapatanBulanIni,
            'total_expenses' => $pengeluaranBulanIni,
            'net_profit' => $netProfit,
            'profit_margin_percentage' => $profitMarginPercentage,
            'is_profitable' => $netProfit > 0,
            'profit_change' => $profitChange,
            'is_increase' => $profitChange > 0,
            'vs_last_month' => $netProfitBulanLalu,
            'health_status' => $healthStatus,
            'health_color' => $healthColor,
            'health_icon' => $healthIcon,
        ];
    }

    /**
     * Get weekly comparison data
     * FASE 2 Feature
     */
    public function getWeeklyComparison()
    {
        $thisWeekStart = Carbon::now()->startOfWeek();
        $thisWeekEnd = Carbon::now()->endOfWeek();
        $lastWeekStart = Carbon::now()->subWeek()->startOfWeek();
        $lastWeekEnd = Carbon::now()->subWeek()->endOfWeek();

        // Data minggu ini
        $thisWeekTransaksi = Transaksi::whereBetween('tanggal_transaksi', [$thisWeekStart, $thisWeekEnd])
            ->where('status', 'selesai')
            ->count();

        $thisWeekPendapatan = Transaksi::whereBetween('tanggal_transaksi', [$thisWeekStart, $thisWeekEnd])
            ->where('status', 'selesai')
            ->sum('total_harga');

        // Data minggu lalu
        $lastWeekTransaksi = Transaksi::whereBetween('tanggal_transaksi', [$lastWeekStart, $lastWeekEnd])
            ->where('status', 'selesai')
            ->count();

        $lastWeekPendapatan = Transaksi::whereBetween('tanggal_transaksi', [$lastWeekStart, $lastWeekEnd])
            ->where('status', 'selesai')
            ->sum('total_harga');

        // Calculate changes
        $transaksiChange = $lastWeekTransaksi > 0
            ? round((($thisWeekTransaksi - $lastWeekTransaksi) / $lastWeekTransaksi) * 100, 1)
            : 0;

        $pendapatanChange = $lastWeekPendapatan > 0
            ? round((($thisWeekPendapatan - $lastWeekPendapatan) / $lastWeekPendapatan) * 100, 1)
            : 0;

        return [
            'this_week' => [
                'transaksi' => $thisWeekTransaksi,
                'pendapatan' => $thisWeekPendapatan,
                'rata_rata_per_hari' => round($thisWeekPendapatan / 7, 0)
            ],
            'last_week' => [
                'transaksi' => $lastWeekTransaksi,
                'pendapatan' => $lastWeekPendapatan,
                'rata_rata_per_hari' => round($lastWeekPendapatan / 7, 0)
            ],
            'transaksi_change' => $transaksiChange,
            'pendapatan_change' => $pendapatanChange,
            'transaksi_is_increase' => $transaksiChange > 0,
            'pendapatan_is_increase' => $pendapatanChange > 0,
        ];
    }

    /**
     * Get kapster utilization rate
     * FASE 2 Feature
     */
    public function getKapsterUtilization()
    {
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();
        $totalHariBulanIni = Carbon::now()->daysInMonth;
        $hariYangSudahLewat = Carbon::now()->day;

        $kapsterData = Kapster::with('cabang')
            ->get()
            ->map(function ($kapster) use ($startOfMonth, $endOfMonth, $hariYangSudahLewat) {
                // Hitung berapa hari kapster ini ada transaksi
                $hariAktif = Transaksi::where('kapster_id', $kapster->id)
                    ->whereBetween('tanggal_transaksi', [$startOfMonth, $endOfMonth])
                    ->where('status', 'selesai')
                    ->select(DB::raw('COUNT(DISTINCT DATE(tanggal_transaksi)) as hari_aktif'))
                    ->first()
                    ->hari_aktif ?? 0;

                // Total transaksi
                $totalTransaksi = Transaksi::where('kapster_id', $kapster->id)
                    ->whereBetween('tanggal_transaksi', [$startOfMonth, $endOfMonth])
                    ->where('status', 'selesai')
                    ->count();

                // Utilization rate
                $utilizationRate = $hariYangSudahLewat > 0
                    ? round(($hariAktif / $hariYangSudahLewat) * 100, 1)
                    : 0;

                // Status
                $status = 'low';
                $statusColor = 'red';
                if ($utilizationRate >= 80) {
                    $status = 'high';
                    $statusColor = 'green';
                } elseif ($utilizationRate >= 50) {
                    $status = 'medium';
                    $statusColor = 'blue';
                } elseif ($utilizationRate >= 25) {
                    $status = 'low';
                    $statusColor = 'yellow';
                }

                return [
                    'id' => $kapster->id,
                    'nama' => $kapster->nama,
                    'cabang' => $kapster->cabang->nama_cabang ?? '-',
                    'hari_aktif' => $hariAktif,
                    'hari_tersedia' => $hariYangSudahLewat,
                    'total_transaksi' => $totalTransaksi,
                    'utilization_rate' => $utilizationRate,
                    'status' => $status,
                    'status_color' => $statusColor,
                ];
            })
            ->sortByDesc('utilization_rate')
            ->values();

        return [
            'data' => $kapsterData,
            'avg_utilization' => $kapsterData->avg('utilization_rate'),
        ];
    }
}
