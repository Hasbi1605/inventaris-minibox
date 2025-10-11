<?php

namespace App\Services;

use App\Models\Setting;
use App\Models\Transaksi;
use App\Models\Kapster;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class KomisiService
{
    /**
     * Hitung komisi untuk satu transaksi
     * 
     * @param Transaksi $transaksi
     * @param Kapster|null $kapster Optional kapster for individual rates
     * @return array ['total' => float, 'breakdown' => array]
     */
    public function hitungKomisiTransaksi(Transaksi $transaksi, ?Kapster $kapster = null)
    {
        // Load kapster if not provided
        if (!$kapster && $transaksi->kapster_id) {
            $kapster = $transaksi->kapster;
        }

        $breakdown = [];
        $totalKomisi = 0;

        // 1. Komisi dari layanan
        if ($transaksi->layanan) {
            $layanan = $transaksi->layanan;
            $kategori = $layanan->kategori;

            if ($kategori) {
                // Ambil persentase komisi - prioritaskan dari kapster, fallback ke settings
                if ($kategori->komisi_type === 'potong_rambut') {
                    $persenKomisi = $kapster && $kapster->komisi_potong_rambut !== null
                        ? (float) $kapster->komisi_potong_rambut
                        : (float) Setting::get('komisi_potong_rambut', 40);
                } else {
                    $persenKomisi = $kapster && $kapster->komisi_layanan_lain !== null
                        ? (float) $kapster->komisi_layanan_lain
                        : (float) Setting::get('komisi_layanan_lain', 25);
                }

                // Hitung harga layanan dari transaksi (total_harga - total produk)
                $hargaLayanan = $transaksi->total_harga;
                if ($transaksi->produk && $transaksi->produk->count() > 0) {
                    $totalProduk = 0;
                    foreach ($transaksi->produk as $prod) {
                        $totalProduk += $prod->pivot->subtotal;
                    }
                    $hargaLayanan = $transaksi->total_harga - $totalProduk;
                }

                $komisiLayanan = ($hargaLayanan * $persenKomisi / 100);

                $breakdown['layanan'] = [
                    'nama' => $layanan->nama_layanan,
                    'kategori' => $kategori->nama_kategori,
                    'komisi_type' => $kategori->komisi_type,
                    'harga' => $hargaLayanan,
                    'persen_komisi' => $persenKomisi,
                    'komisi' => $komisiLayanan,
                ];

                $totalKomisi += $komisiLayanan;
            }
        }

        // 2. Komisi dari produk retail
        if ($transaksi->produk && $transaksi->produk->count() > 0) {
            // Prioritaskan komisi dari kapster, fallback ke settings
            $persenKomisiProduk = $kapster && $kapster->komisi_produk !== null
                ? (float) $kapster->komisi_produk
                : (float) Setting::get('komisi_produk', 25);

            $breakdown['produk'] = [];

            foreach ($transaksi->produk as $produk) {
                $subtotal = (float) $produk->pivot->subtotal;
                $komisiProduk = ($subtotal * $persenKomisiProduk / 100);

                $breakdown['produk'][] = [
                    'nama' => $produk->nama_barang,
                    'quantity' => $produk->pivot->quantity,
                    'harga_satuan' => $produk->pivot->harga_satuan,
                    'subtotal' => $subtotal,
                    'persen_komisi' => $persenKomisiProduk,
                    'komisi' => $komisiProduk,
                ];

                $totalKomisi += $komisiProduk;
            }
        }

        return [
            'total' => round($totalKomisi, 2),
            'breakdown' => $breakdown,
        ];
    }

    /**
     * Hitung total komisi kapster dalam periode tertentu
     * 
     * @param int $kapsterId
     * @param string|Carbon $startDate
     * @param string|Carbon $endDate
     * @return array
     */
    public function hitungKomisiKapster($kapsterId, $startDate, $endDate)
    {
        // Convert string to Carbon if needed
        $startDate = $startDate instanceof \Carbon\Carbon ? $startDate : \Carbon\Carbon::parse($startDate);
        $endDate = $endDate instanceof \Carbon\Carbon ? $endDate : \Carbon\Carbon::parse($endDate);

        // Load kapster for individual commission rates
        $kapster = Kapster::find($kapsterId);

        $transaksis = Transaksi::where('kapster_id', $kapsterId)
            ->whereBetween('tanggal_transaksi', [$startDate, $endDate])
            ->where('status', 'selesai')
            ->with(['layanan.kategori', 'produk', 'cabang'])
            ->orderBy('tanggal_transaksi', 'desc')
            ->get();

        $totalKomisi = 0;
        $totalKomisiLayanan = 0;
        $totalKomisiProduk = 0;
        $jumlahTransaksi = $transaksis->count();
        $detail = [];

        // Agregasi untuk breakdown per kategori
        $totalKomisiPotongRambut = 0;
        $totalKomisiLayananLain = 0;
        $jumlahTransaksiPotongRambut = 0;
        $jumlahTransaksiLayananLain = 0;
        $jumlahProdukTerjual = 0;

        foreach ($transaksis as $transaksi) {
            // Pass kapster to use individual commission rates
            $komisiData = $this->hitungKomisiTransaksi($transaksi, $kapster);
            $totalKomisi += $komisiData['total'];

            // Breakdown per jenis
            $komisiLayanan = isset($komisiData['breakdown']['layanan'])
                ? $komisiData['breakdown']['layanan']['komisi']
                : 0;
            $komisiProduk = isset($komisiData['breakdown']['produk'])
                ? array_sum(array_column($komisiData['breakdown']['produk'], 'komisi'))
                : 0;

            $totalKomisiLayanan += $komisiLayanan;
            $totalKomisiProduk += $komisiProduk;

            // Agregasi per kategori layanan
            if (isset($komisiData['breakdown']['layanan'])) {
                $layananBreakdown = $komisiData['breakdown']['layanan'];
                if ($layananBreakdown['komisi_type'] === 'potong_rambut') {
                    $totalKomisiPotongRambut += $layananBreakdown['komisi'];
                    $jumlahTransaksiPotongRambut++;
                } else {
                    $totalKomisiLayananLain += $layananBreakdown['komisi'];
                    $jumlahTransaksiLayananLain++;
                }
            }

            // Hitung jumlah produk terjual
            if (isset($komisiData['breakdown']['produk'])) {
                $jumlahProdukTerjual += count($komisiData['breakdown']['produk']);
            }

            $detail[] = [
                'transaksi_id' => $transaksi->id,
                'nomor_transaksi' => $transaksi->nomor_transaksi,
                'tanggal' => $transaksi->tanggal_transaksi->format('Y-m-d'),
                'cabang' => $transaksi->cabang->nama_cabang,
                'total_harga' => $transaksi->total_harga,
                'komisi_layanan' => $komisiLayanan,
                'komisi_produk' => $komisiProduk,
                'komisi_total' => $komisiData['total'],
                'breakdown' => $komisiData['breakdown'],
            ];
        }

        return [
            'kapster_id' => $kapsterId,
            'periode' => [
                'start' => $startDate->format('Y-m-d'),
                'end' => $endDate->format('Y-m-d'),
            ],
            'total_komisi' => round($totalKomisi, 2),
            'total_komisi_layanan' => round($totalKomisiLayanan, 2),
            'total_komisi_produk' => round($totalKomisiProduk, 2),
            'jumlah_transaksi' => $jumlahTransaksi,
            'detail' => $detail,
            // Tambahkan breakdown agregat
            'breakdown' => [
                'layanan' => [
                    'potong_rambut' => round($totalKomisiPotongRambut, 2),
                    'lain' => round($totalKomisiLayananLain, 2),
                ],
                'produk' => round($totalKomisiProduk, 2),
            ],
            'detail_jumlah' => [
                'layanan' => [
                    'potong_rambut' => [
                        'jumlah' => $jumlahTransaksiPotongRambut,
                    ],
                    'lain' => [
                        'jumlah' => $jumlahTransaksiLayananLain,
                    ],
                ],
                'produk' => [
                    'jumlah' => $jumlahProdukTerjual,
                ],
            ],
        ];
    }

    /**
     * Hitung komisi semua kapster dalam periode
     * 
     * @param string|Carbon $startDate
     * @param string|Carbon $endDate
     * @param int|null $cabangId Filter by cabang
     * @return array
     */
    public function hitungKomisiSemuaKapster($startDate, $endDate, $cabangId = null)
    {
        // Convert string to Carbon if needed
        $startDate = $startDate instanceof \Carbon\Carbon ? $startDate : \Carbon\Carbon::parse($startDate);
        $endDate = $endDate instanceof \Carbon\Carbon ? $endDate : \Carbon\Carbon::parse($endDate);

        $query = Kapster::with('cabang');

        if ($cabangId) {
            $query->where('cabang_id', $cabangId);
        }

        $kapsters = $query->get();
        $result = [];
        $grandTotal = 0;

        foreach ($kapsters as $kapster) {
            $komisiData = $this->hitungKomisiKapster($kapster->id, $startDate, $endDate);

            $result[] = [
                'kapster_id' => $kapster->id,
                'nama_kapster' => $kapster->nama_kapster,
                'cabang' => $kapster->cabang->nama_cabang,
                'total_komisi' => $komisiData['total_komisi'],
                'total_komisi_layanan' => $komisiData['total_komisi_layanan'],
                'total_komisi_produk' => $komisiData['total_komisi_produk'],
                'jumlah_transaksi' => $komisiData['jumlah_transaksi'],
            ];

            $grandTotal += $komisiData['total_komisi'];
        }

        // Sort by total komisi descending
        usort($result, function ($a, $b) {
            return $b['total_komisi'] <=> $a['total_komisi'];
        });

        return [
            'periode' => [
                'start' => $startDate->format('Y-m-d'),
                'end' => $endDate->format('Y-m-d'),
            ],
            'grand_total' => round($grandTotal, 2),
            'kapsters' => $result,
        ];
    }

    /**
     * Get komisi settings untuk display
     * 
     * @return array
     */
    public function getKomisiSettings()
    {
        return [
            'potong_rambut' => (float) Setting::get('komisi_potong_rambut', 40),
            'layanan_lain' => (float) Setting::get('komisi_layanan_lain', 25),
            'produk' => (float) Setting::get('komisi_produk', 25),
        ];
    }

    /**
     * Update komisi settings
     * 
     * @param string $key
     * @param float $value
     * @return bool
     */
    public function updateKomisiSetting($key, $value)
    {
        $allowedKeys = ['komisi_potong_rambut', 'komisi_layanan_lain', 'komisi_produk'];

        if (!in_array($key, $allowedKeys)) {
            return false;
        }

        Setting::set($key, $value, null, 'komisi', 'number');
        return true;
    }
}
