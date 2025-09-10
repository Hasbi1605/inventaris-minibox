<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pengeluaran;
use Carbon\Carbon;

class PengeluaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pengeluaranData = [
            [
                'nama_pengeluaran' => 'Pembelian Shampoo',
                'kategori' => 'inventaris',
                'jumlah' => 150000,
                'tanggal_pengeluaran' => Carbon::now()->subDays(5),
                'deskripsi' => 'Pembelian shampoo untuk stok barbershop',
                'status' => 'approved',
            ],
            [
                'nama_pengeluaran' => 'Listrik Bulan September',
                'kategori' => 'operasional',
                'jumlah' => 500000,
                'tanggal_pengeluaran' => Carbon::now()->subDays(3),
                'deskripsi' => 'Pembayaran tagihan listrik bulan September',
                'status' => 'approved',
            ],
            [
                'nama_pengeluaran' => 'Gaji Barber Ahmad',
                'kategori' => 'gaji',
                'jumlah' => 3000000,
                'tanggal_pengeluaran' => Carbon::now()->subDays(1),
                'deskripsi' => 'Gaji bulanan untuk barber Ahmad',
                'status' => 'approved',
            ],
            [
                'nama_pengeluaran' => 'Promosi Media Sosial',
                'kategori' => 'promosi',
                'jumlah' => 200000,
                'tanggal_pengeluaran' => Carbon::now()->subDays(7),
                'deskripsi' => 'Budget untuk promosi di Instagram dan Facebook',
                'status' => 'approved',
            ],
            [
                'nama_pengeluaran' => 'Service Mesin Cukur',
                'kategori' => 'maintenance',
                'jumlah' => 75000,
                'tanggal_pengeluaran' => Carbon::now()->subDays(10),
                'deskripsi' => 'Service dan perbaikan mesin cukur yang rusak',
                'status' => 'approved',
            ],
            [
                'nama_pengeluaran' => 'Pembelian Pomade',
                'kategori' => 'inventaris',
                'jumlah' => 300000,
                'tanggal_pengeluaran' => Carbon::now()->subDays(2),
                'deskripsi' => 'Pembelian pomade berbagai merk untuk dijual',
                'status' => 'pending',
            ],
            [
                'nama_pengeluaran' => 'Internet Bulan September',
                'kategori' => 'operasional',
                'jumlah' => 400000,
                'tanggal_pengeluaran' => Carbon::now(),
                'deskripsi' => 'Pembayaran tagihan internet bulan September',
                'status' => 'pending',
            ],
        ];

        foreach ($pengeluaranData as $data) {
            Pengeluaran::create($data);
        }
    }
}
