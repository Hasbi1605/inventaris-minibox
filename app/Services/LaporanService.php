<?php

namespace App\Services;

use App\Models\Transaksi;
use App\Models\Pengeluaran;
use App\Models\Kapster;
use App\Models\Cabang;
use App\Models\Layanan;
use App\Models\Inventaris;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class LaporanService
{
    /**
     * Get laporan gaji dan komisi kapster
     */
    public function getLaporanGajiKapster($bulan = null, $tahun = null, $cabangId = null, $kapsterId = null)
    {
        $bulan = $bulan ?? Carbon::now()->month;
        $tahun = $tahun ?? Carbon::now()->year;

        $startDate = Carbon::create($tahun, $bulan, 1)->startOfMonth();
        $endDate = Carbon::create($tahun, $bulan, 1)->endOfMonth();

        $query = Kapster::with(['cabang', 'transaksi' => function ($q) use ($startDate, $endDate) {
            $q->whereBetween('tanggal_transaksi', [$startDate, $endDate])
                ->where('status', 'selesai');
        }]);

        if ($cabangId) {
            $query->where('cabang_id', $cabangId);
        }

        if ($kapsterId) {
            $query->where('id', $kapsterId);
        }

        $kapsters = $query->get();

        $gajiData = $kapsters->map(function ($kapster) {
            $totalTransaksi = $kapster->transaksi->count();
            $totalNilaiTransaksi = $kapster->transaksi->sum('total_harga');
            $komisiPersen = $kapster->komisi_persen ?? 0;
            $gajiKomisi = ($totalNilaiTransaksi * $komisiPersen) / 100;

            // Gaji pokok (bisa di-customize atau ambil dari database jika ada field)
            $gajiPokok = 0; // Atur sesuai kebijakan, misal dari field di tabel kapster

            return [
                'id' => $kapster->id,
                'nama_kapster' => $kapster->nama_kapster,
                'cabang' => $kapster->cabang->nama_cabang ?? '-',
                'cabang_id' => $kapster->cabang_id,
                'total_transaksi' => $totalTransaksi,
                'total_nilai_transaksi' => $totalNilaiTransaksi,
                'komisi_persen' => $komisiPersen,
                'gaji_komisi' => $gajiKomisi,
                'gaji_pokok' => $gajiPokok,
                'total_gaji' => $gajiPokok + $gajiKomisi,
                'status' => $kapster->status,
                'spesialisasi' => $kapster->spesialisasi,
            ];
        });

        return [
            'periode' => [
                'bulan' => $bulan,
                'tahun' => $tahun,
                'bulan_nama' => Carbon::create($tahun, $bulan, 1)->format('F Y'),
                'start_date' => $startDate->format('Y-m-d'),
                'end_date' => $endDate->format('Y-m-d'),
            ],
            'data' => $gajiData,
            'summary' => [
                'total_kapster' => $gajiData->count(),
                'total_transaksi' => $gajiData->sum('total_transaksi'),
                'total_nilai_transaksi' => $gajiData->sum('total_nilai_transaksi'),
                'total_gaji_komisi' => $gajiData->sum('gaji_komisi'),
                'total_gaji_pokok' => $gajiData->sum('gaji_pokok'),
                'total_gaji_keseluruhan' => $gajiData->sum('total_gaji'),
            ]
        ];
    }

    /**
     * Get laporan keuangan (Laba Rugi)
     */
    public function getLaporanKeuangan($startDate, $endDate, $cabangId = null)
    {
        // Pendapatan
        $pendapatanQuery = Transaksi::whereBetween('tanggal_transaksi', [$startDate, $endDate])
            ->where('status', 'selesai');

        if ($cabangId) {
            $pendapatanQuery->where('cabang_id', $cabangId);
        }

        $totalPendapatan = $pendapatanQuery->sum('total_harga');
        $jumlahTransaksi = $pendapatanQuery->count();

        // Pengeluaran Operasional
        $pengeluaranQuery = Pengeluaran::whereBetween('tanggal_pengeluaran', [$startDate, $endDate]);

        if ($cabangId) {
            $pengeluaranQuery->where('cabang_id', $cabangId);
        }

        $totalPengeluaran = $pengeluaranQuery->sum('jumlah');

        // Breakdown pengeluaran per kategori
        $pengeluaranPerKategori = Pengeluaran::with('kategori')
            ->whereBetween('tanggal_pengeluaran', [$startDate, $endDate])
            ->when($cabangId, function ($q) use ($cabangId) {
                $q->where('cabang_id', $cabangId);
            })
            ->select('kategori_id', DB::raw('SUM(jumlah) as total'))
            ->groupBy('kategori_id')
            ->get();

        // Gaji & Komisi Karyawan (dari laporan gaji)
        $bulan = Carbon::parse($startDate)->month;
        $tahun = Carbon::parse($startDate)->year;
        $laporanGaji = $this->getLaporanGajiKapster($bulan, $tahun, $cabangId);
        $totalGaji = $laporanGaji['summary']['total_gaji_keseluruhan'];

        // Pembelian Inventaris (bisa ditambahkan jika ada data pembelian)
        $totalPembelianInventaris = 0; // Placeholder

        // Perhitungan Laba
        $totalBeban = $totalPengeluaran + $totalGaji + $totalPembelianInventaris;
        $labaBersih = $totalPendapatan - $totalBeban;
        $marginLaba = $totalPendapatan > 0 ? ($labaBersih / $totalPendapatan) * 100 : 0;

        return [
            'periode' => [
                'start_date' => $startDate,
                'end_date' => $endDate,
            ],
            'pendapatan' => [
                'total' => $totalPendapatan,
                'jumlah_transaksi' => $jumlahTransaksi,
                'rata_rata_per_transaksi' => $jumlahTransaksi > 0 ? $totalPendapatan / $jumlahTransaksi : 0,
            ],
            'beban' => [
                'pengeluaran_operasional' => $totalPengeluaran,
                'gaji_karyawan' => $totalGaji,
                'pembelian_inventaris' => $totalPembelianInventaris,
                'total_beban' => $totalBeban,
            ],
            'pengeluaran_per_kategori' => $pengeluaranPerKategori,
            'laba_rugi' => [
                'laba_bersih' => $labaBersih,
                'margin_laba_persen' => round($marginLaba, 2),
            ]
        ];
    }

    /**
     * Get laporan per cabang
     */
    public function getLaporanPerCabang($startDate, $endDate)
    {
        $cabangList = Cabang::all();

        $laporanCabang = $cabangList->map(function ($cabang) use ($startDate, $endDate) {
            // Pendapatan
            $pendapatan = Transaksi::where('cabang_id', $cabang->id)
                ->whereBetween('tanggal_transaksi', [$startDate, $endDate])
                ->where('status', 'selesai')
                ->sum('total_harga');

            $jumlahTransaksi = Transaksi::where('cabang_id', $cabang->id)
                ->whereBetween('tanggal_transaksi', [$startDate, $endDate])
                ->where('status', 'selesai')
                ->count();

            // Pengeluaran
            $pengeluaran = Pengeluaran::where('cabang_id', $cabang->id)
                ->whereBetween('tanggal_pengeluaran', [$startDate, $endDate])
                ->sum('jumlah');

            // Laba
            $laba = $pendapatan - $pengeluaran;
            $rataRataPerTransaksi = $jumlahTransaksi > 0 ? $pendapatan / $jumlahTransaksi : 0;
            $marginLaba = $pendapatan > 0 ? ($laba / $pendapatan) * 100 : 0;

            return [
                'id' => $cabang->id,
                'nama_cabang' => $cabang->nama_cabang,
                'alamat' => $cabang->alamat,
                'pendapatan' => $pendapatan,
                'jumlah_transaksi' => $jumlahTransaksi,
                'rata_rata_per_transaksi' => $rataRataPerTransaksi,
                'pengeluaran' => $pengeluaran,
                'laba' => $laba,
                'margin_laba_persen' => round($marginLaba, 2),
            ];
        })->sortByDesc('pendapatan')->values();

        return [
            'periode' => [
                'start_date' => $startDate,
                'end_date' => $endDate,
            ],
            'data' => $laporanCabang,
            'summary' => [
                'total_pendapatan' => $laporanCabang->sum('pendapatan'),
                'total_transaksi' => $laporanCabang->sum('jumlah_transaksi'),
                'total_pengeluaran' => $laporanCabang->sum('pengeluaran'),
                'total_laba' => $laporanCabang->sum('laba'),
            ]
        ];
    }

    /**
     * Get laporan layanan & produk
     */
    public function getLaporanLayanan($startDate, $endDate, $cabangId = null)
    {
        $query = Transaksi::with('layanan')
            ->whereBetween('tanggal_transaksi', [$startDate, $endDate])
            ->where('status', 'selesai');

        if ($cabangId) {
            $query->where('cabang_id', $cabangId);
        }

        $transaksiLayanan = $query->select('layanan_id', DB::raw('COUNT(*) as jumlah_transaksi'), DB::raw('SUM(total_harga) as total_pendapatan'))
            ->groupBy('layanan_id')
            ->get();

        $layananData = $transaksiLayanan->map(function ($item) {
            $layanan = Layanan::find($item->layanan_id);
            return [
                'layanan_id' => $item->layanan_id,
                'nama_layanan' => $layanan->nama_layanan ?? '-',
                'harga_layanan' => $layanan->harga ?? 0,
                'jumlah_transaksi' => $item->jumlah_transaksi,
                'total_pendapatan' => $item->total_pendapatan,
                'rata_rata_per_transaksi' => $item->jumlah_transaksi > 0 ? $item->total_pendapatan / $item->jumlah_transaksi : 0,
            ];
        })->sortByDesc('total_pendapatan')->values();

        $totalTransaksi = $layananData->sum('jumlah_transaksi');

        // Tambahkan persentase
        $layananData = $layananData->map(function ($item) use ($totalTransaksi) {
            $item['persentase'] = $totalTransaksi > 0 ? round(($item['jumlah_transaksi'] / $totalTransaksi) * 100, 2) : 0;
            return $item;
        });

        return [
            'periode' => [
                'start_date' => $startDate,
                'end_date' => $endDate,
            ],
            'data' => $layananData,
            'summary' => [
                'total_transaksi' => $totalTransaksi,
                'total_pendapatan' => $layananData->sum('total_pendapatan'),
                'jumlah_layanan' => $layananData->count(),
            ]
        ];
    }

    /**
     * Get laporan inventaris & stok
     */
    public function getLaporanInventaris($cabangId = null)
    {
        $query = Inventaris::with(['kategori', 'cabang']);

        if ($cabangId) {
            $query->where('cabang_id', $cabangId);
        }

        $inventarisList = $query->get();

        $inventarisData = $inventarisList->map(function ($item) {
            $stok = $item->stok_saat_ini ?? 0;
            $nilaiTotal = $item->harga_satuan * $stok;
            $statusStok = $stok <= 10 ? 'Menipis' : ($stok <= 30 ? 'Normal' : 'Aman');

            return [
                'id' => $item->id,
                'nama_produk' => $item->nama_barang,
                'kategori' => $item->kategori->nama_kategori ?? ($item->kategori ?? '-'),
                'cabang' => $item->cabang->nama_cabang ?? '-',
                'stok' => $stok,
                'satuan' => $item->satuan,
                'harga_satuan' => $item->harga_satuan,
                'nilai_total' => $nilaiTotal,
                'status_stok' => $statusStok,
            ];
        });

        $inventarisPerKategori = $inventarisList->groupBy('kategori_id')->map(function ($items, $kategoriId) {
            $kategori = $items->first()->kategori;
            return [
                'kategori_id' => $kategoriId,
                'nama_kategori' => $kategori->nama_kategori ?? '-',
                'jumlah_item' => $items->count(),
                'total_stok' => $items->sum('stok_saat_ini'),
                'nilai_total' => $items->sum(function ($item) {
                    return $item->harga_satuan * ($item->stok_saat_ini ?? 0);
                }),
            ];
        })->values();

        return [
            'data' => $inventarisData,
            'per_kategori' => $inventarisPerKategori,
            'summary' => [
                'total_item' => $inventarisData->count(),
                'total_nilai_inventaris' => $inventarisData->sum('nilai_total'),
                'item_menipis' => $inventarisData->where('status_stok', 'Menipis')->count(),
            ]
        ];
    }

    /**
     * Get laporan cash flow
     */
    public function getLaporanCashFlow($startDate, $endDate, $cabangId = null)
    {
        // Kas Masuk (Pendapatan)
        $kasMasukQuery = Transaksi::whereBetween('tanggal_transaksi', [$startDate, $endDate])
            ->where('status', 'selesai');

        if ($cabangId) {
            $kasMasukQuery->where('cabang_id', $cabangId);
        }

        $kasMasuk = $kasMasukQuery->sum('total_harga');

        // Kas Keluar (Pengeluaran + Gaji)
        $pengeluaranQuery = Pengeluaran::whereBetween('tanggal_pengeluaran', [$startDate, $endDate]);

        if ($cabangId) {
            $pengeluaranQuery->where('cabang_id', $cabangId);
        }

        $kasKeluarPengeluaran = $pengeluaranQuery->sum('jumlah');

        // Gaji
        $bulan = Carbon::parse($startDate)->month;
        $tahun = Carbon::parse($startDate)->year;
        $laporanGaji = $this->getLaporanGajiKapster($bulan, $tahun, $cabangId);
        $kasKeluarGaji = $laporanGaji['summary']['total_gaji_keseluruhan'];

        $totalKasKeluar = $kasKeluarPengeluaran + $kasKeluarGaji;
        $netCashFlow = $kasMasuk - $totalKasKeluar;

        // Kas Masuk Per Metode Pembayaran
        $kasMasukPerMetode = Transaksi::whereBetween('tanggal_transaksi', [$startDate, $endDate])
            ->where('status', 'selesai')
            ->when($cabangId, function ($q) use ($cabangId) {
                $q->where('cabang_id', $cabangId);
            })
            ->select('metode_pembayaran', DB::raw('SUM(total_harga) as total'))
            ->groupBy('metode_pembayaran')
            ->get();

        return [
            'periode' => [
                'start_date' => $startDate,
                'end_date' => $endDate,
            ],
            'kas_masuk' => [
                'total' => $kasMasuk,
                'per_metode' => $kasMasukPerMetode,
            ],
            'kas_keluar' => [
                'pengeluaran_operasional' => $kasKeluarPengeluaran,
                'gaji_karyawan' => $kasKeluarGaji,
                'total' => $totalKasKeluar,
            ],
            'net_cash_flow' => $netCashFlow,
        ];
    }

    /**
     * Get laporan customer behavior
     */
    public function getLaporanCustomerBehavior($startDate, $endDate, $cabangId = null)
    {
        $query = Transaksi::whereBetween('tanggal_transaksi', [$startDate, $endDate])
            ->where('status', 'selesai');

        if ($cabangId) {
            $query->where('cabang_id', $cabangId);
        }

        $transaksiList = $query->get();

        // Peak Hours Analysis
        $transaksiPerJam = $transaksiList->groupBy(function ($item) {
            return Carbon::parse($item->created_at)->format('H');
        })->map(function ($items, $jam) {
            return [
                'jam' => $jam . ':00',
                'jumlah_transaksi' => $items->count(),
                'total_pendapatan' => $items->sum('total_harga'),
            ];
        })->sortByDesc('jumlah_transaksi')->values();

        // Peak Days Analysis
        $transaksiPerHari = $transaksiList->groupBy(function ($item) {
            return Carbon::parse($item->tanggal_transaksi)->format('l');
        })->map(function ($items, $hari) {
            return [
                'hari' => $hari,
                'jumlah_transaksi' => $items->count(),
                'total_pendapatan' => $items->sum('total_harga'),
            ];
        })->sortByDesc('jumlah_transaksi')->values();

        // Metode Pembayaran
        $metodePembayaran = $transaksiList->groupBy('metode_pembayaran')->map(function ($items, $metode) {
            return [
                'metode' => $metode,
                'jumlah_transaksi' => $items->count(),
                'total_pendapatan' => $items->sum('total_harga'),
                'persentase' => 0, // akan dihitung di bawah
            ];
        });

        $totalTransaksi = $transaksiList->count();
        $metodePembayaran = $metodePembayaran->map(function ($item) use ($totalTransaksi) {
            $item['persentase'] = $totalTransaksi > 0 ? round(($item['jumlah_transaksi'] / $totalTransaksi) * 100, 2) : 0;
            return $item;
        })->values();

        return [
            'periode' => [
                'start_date' => $startDate,
                'end_date' => $endDate,
            ],
            'peak_hours' => $transaksiPerJam,
            'peak_days' => $transaksiPerHari,
            'metode_pembayaran' => $metodePembayaran,
            'summary' => [
                'total_transaksi' => $totalTransaksi,
                'total_pendapatan' => $transaksiList->sum('total_harga'),
                'rata_rata_per_transaksi' => $totalTransaksi > 0 ? $transaksiList->sum('total_harga') / $totalTransaksi : 0,
            ]
        ];
    }
}
