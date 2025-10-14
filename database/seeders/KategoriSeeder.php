<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Kategori;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Kategori untuk Inventaris
        $inventarisParents = [
            [
                'nama_kategori' => 'Alat Potong',
                'kode_kategori' => 'INV001',
                'deskripsi' => 'Peralatan untuk memotong rambut',
                'jenis_kategori' => 'inventaris',
                'parent_id' => null,
                'urutan' => 1,
                'status' => true,
                'warna' => '#FF6B35',
                'ikon' => 'fa-cut'
            ],
            [
                'nama_kategori' => 'Produk Perawatan',
                'kode_kategori' => 'INV002',
                'deskripsi' => 'Produk untuk perawatan rambut',
                'jenis_kategori' => 'inventaris',
                'parent_id' => null,
                'urutan' => 2,
                'status' => true,
                'warna' => '#4ECDC4',
                'ikon' => 'fa-spray-can'
            ],
            [
                'nama_kategori' => 'Aksesoris',
                'kode_kategori' => 'INV003',
                'deskripsi' => 'Aksesoris barbershop',
                'jenis_kategori' => 'inventaris',
                'parent_id' => null,
                'urutan' => 3,
                'status' => true,
                'warna' => '#45B7D1',
                'ikon' => 'fa-tools'
            ]
        ];

        foreach ($inventarisParents as $parent) {
            Kategori::updateOrCreate(
                ['kode_kategori' => $parent['kode_kategori']],
                $parent
            );
        }

        // Sub-kategori untuk Alat Potong
        $alatPotongParent = Kategori::where('kode_kategori', 'INV001')->first();
        $alatPotongSubs = [
            [
                'nama_kategori' => 'Gunting',
                'kode_kategori' => 'INV001A',
                'deskripsi' => 'Berbagai jenis gunting',
                'jenis_kategori' => 'inventaris',
                'parent_id' => $alatPotongParent->id,
                'urutan' => 1,
                'status' => true,
                'warna' => '#FF6B35',
                'ikon' => 'fa-cut'
            ],
            [
                'nama_kategori' => 'Mesin Cukur',
                'kode_kategori' => 'INV001B',
                'deskripsi' => 'Mesin cukur listrik dan manual',
                'jenis_kategori' => 'inventaris',
                'parent_id' => $alatPotongParent->id,
                'urutan' => 2,
                'status' => true,
                'warna' => '#FF6B35',
                'ikon' => 'fa-plug'
            ]
        ];

        foreach ($alatPotongSubs as $sub) {
            Kategori::updateOrCreate(
                ['kode_kategori' => $sub['kode_kategori']],
                $sub
            );
        }

        // Sub-kategori untuk Produk Perawatan
        $produkPerawatanParent = Kategori::where('kode_kategori', 'INV002')->first();
        $produkPerawatanSubs = [
            [
                'nama_kategori' => 'Shampo',
                'kode_kategori' => 'INV002A',
                'deskripsi' => 'Shampo berbagai jenis',
                'jenis_kategori' => 'inventaris',
                'parent_id' => $produkPerawatanParent->id,
                'urutan' => 1,
                'status' => true,
                'warna' => '#4ECDC4',
                'ikon' => 'fa-pump-soap'
            ],
            [
                'nama_kategori' => 'Hair Tonic',
                'kode_kategori' => 'INV002B',
                'deskripsi' => 'Hair tonic dan vitamin rambut',
                'jenis_kategori' => 'inventaris',
                'parent_id' => $produkPerawatanParent->id,
                'urutan' => 2,
                'status' => true,
                'warna' => '#4ECDC4',
                'ikon' => 'fa-prescription-bottle'
            ],
            [
                'nama_kategori' => 'Styling Product',
                'kode_kategori' => 'INV002C',
                'deskripsi' => 'Pomade, gel, wax, dsb',
                'jenis_kategori' => 'inventaris',
                'parent_id' => $produkPerawatanParent->id,
                'urutan' => 3,
                'status' => true,
                'warna' => '#4ECDC4',
                'ikon' => 'fa-palette'
            ]
        ];

        foreach ($produkPerawatanSubs as $sub) {
            Kategori::updateOrCreate(
                ['kode_kategori' => $sub['kode_kategori']],
                $sub
            );
        }

        // Kategori untuk Layanan
        $layananCategories = [
            [
                'nama_kategori' => 'Potong Rambut',
                'kode_kategori' => 'LAY001',
                'deskripsi' => 'Layanan pemotongan rambut',
                'jenis_kategori' => 'layanan',
                'parent_id' => null,
                'urutan' => 1,
                'status' => true,
                'warna' => '#E74C3C',
                'ikon' => 'fa-cut'
            ],
            [
                'nama_kategori' => 'Styling',
                'kode_kategori' => 'LAY002',
                'deskripsi' => 'Layanan styling rambut',
                'jenis_kategori' => 'layanan',
                'parent_id' => null,
                'urutan' => 2,
                'status' => true,
                'warna' => '#9B59B6',
                'ikon' => 'fa-magic'
            ],
            [
                'nama_kategori' => 'Perawatan',
                'kode_kategori' => 'LAY003',
                'deskripsi' => 'Layanan perawatan rambut dan kulit',
                'jenis_kategori' => 'layanan',
                'parent_id' => null,
                'urutan' => 3,
                'status' => true,
                'warna' => '#2ECC71',
                'ikon' => 'fa-leaf'
            ],
            [
                'nama_kategori' => 'Cukur',
                'kode_kategori' => 'LAY004',
                'deskripsi' => 'Layanan pencukuran jenggot dan kumis',
                'jenis_kategori' => 'layanan',
                'parent_id' => null,
                'urutan' => 4,
                'status' => true,
                'warna' => '#F39C12',
                'ikon' => 'fa-razor'
            ]
        ];

        foreach ($layananCategories as $category) {
            Kategori::updateOrCreate(
                ['kode_kategori' => $category['kode_kategori']],
                $category
            );
        }

        // Kategori untuk Pengeluaran
        $pengeluaranCategories = [
            [
                'nama_kategori' => 'Operasional',
                'kode_kategori' => 'PEN001',
                'deskripsi' => 'Pengeluaran operasional harian',
                'jenis_kategori' => 'pengeluaran',
                'parent_id' => null,
                'urutan' => 1,
                'status' => true,
                'warna' => '#34495E',
                'ikon' => 'fa-cogs'
            ],
            [
                'nama_kategori' => 'Pembelian Inventaris',
                'kode_kategori' => 'PEN002',
                'deskripsi' => 'Pengeluaran untuk pembelian inventaris',
                'jenis_kategori' => 'pengeluaran',
                'parent_id' => null,
                'urutan' => 2,
                'status' => true,
                'warna' => '#16A085',
                'ikon' => 'fa-shopping-cart'
            ],
            [
                'nama_kategori' => 'Marketing',
                'kode_kategori' => 'PEN003',
                'deskripsi' => 'Pengeluaran untuk kegiatan marketing',
                'jenis_kategori' => 'pengeluaran',
                'parent_id' => null,
                'urutan' => 3,
                'status' => true,
                'warna' => '#8E44AD',
                'ikon' => 'fa-bullhorn'
            ],
            [
                'nama_kategori' => 'Maintenance',
                'kode_kategori' => 'PEN004',
                'deskripsi' => 'Pengeluaran untuk pemeliharaan',
                'jenis_kategori' => 'pengeluaran',
                'parent_id' => null,
                'urutan' => 4,
                'status' => true,
                'warna' => '#D35400',
                'ikon' => 'fa-wrench'
            ]
        ];

        foreach ($pengeluaranCategories as $category) {
            Kategori::updateOrCreate(
                ['kode_kategori' => $category['kode_kategori']],
                $category
            );
        }

        // Kategori untuk Cabang
        $cabangCategories = [
            [
                'nama_kategori' => 'Cabang Utama',
                'kode_kategori' => 'CAB001',
                'deskripsi' => 'Cabang utama/pusat',
                'jenis_kategori' => 'cabang',
                'parent_id' => null,
                'urutan' => 1,
                'status' => true,
                'warna' => '#C0392B',
                'ikon' => 'fa-building'
            ],
            [
                'nama_kategori' => 'Cabang Franchise',
                'kode_kategori' => 'CAB002',
                'deskripsi' => 'Cabang franchise',
                'jenis_kategori' => 'cabang',
                'parent_id' => null,
                'urutan' => 2,
                'status' => true,
                'warna' => '#2980B9',
                'ikon' => 'fa-store'
            ]
        ];

        foreach ($cabangCategories as $category) {
            Kategori::updateOrCreate(
                ['kode_kategori' => $category['kode_kategori']],
                $category
            );
        }

        // Kategori untuk Transaksi
        $transaksiCategories = [
            [
                'nama_kategori' => 'Penjualan Layanan',
                'kode_kategori' => 'TRX001',
                'deskripsi' => 'Transaksi penjualan layanan',
                'jenis_kategori' => 'transaksi',
                'parent_id' => null,
                'urutan' => 1,
                'status' => true,
                'warna' => '#27AE60',
                'ikon' => 'fa-hand-holding-usd'
            ],
            [
                'nama_kategori' => 'Penjualan Produk',
                'kode_kategori' => 'TRX002',
                'deskripsi' => 'Transaksi penjualan produk',
                'jenis_kategori' => 'transaksi',
                'parent_id' => null,
                'urutan' => 2,
                'status' => true,
                'warna' => '#F1C40F',
                'ikon' => 'fa-shopping-bag'
            ],
            [
                'nama_kategori' => 'Paket Layanan',
                'kode_kategori' => 'TRX003',
                'deskripsi' => 'Transaksi paket layanan',
                'jenis_kategori' => 'transaksi',
                'parent_id' => null,
                'urutan' => 3,
                'status' => true,
                'warna' => '#E67E22',
                'ikon' => 'fa-box'
            ]
        ];

        foreach ($transaksiCategories as $category) {
            Kategori::updateOrCreate(
                ['kode_kategori' => $category['kode_kategori']],
                $category
            );
        }
    }
}
