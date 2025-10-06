<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Kategori;
use Illuminate\Support\Facades\DB;

class UpdateKategoriTipePenggunaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Kategori yang termasuk RETAIL (produk yang dijual)
        $retailKeywords = [
            'pomade',
            'wax',
            'clay',
            'gel',
            'spray',
            'sampo',
            'shampoo',
            'kondisioner',
            'conditioner',
            'serum',
            'vitamin',
            'tonic',
            'minyak',
            'oil',
            'produk',
            'retail',
            'jual'
        ];

        // Kategori yang termasuk OPERASIONAL (aset/peralatan)
        $operasionalKeywords = [
            'alat',
            'gunting',
            'sisir',
            'comb',
            'clipper',
            'mesin',
            'kursi',
            'chair',
            'meja',
            'table',
            'cermin',
            'mirror',
            'kain',
            'handuk',
            'towel',
            'sterilizer',
            'peralatan',
            'equipment',
            'aset'
        ];

        // Get semua kategori inventaris
        $kategoris = Kategori::where('jenis_kategori', Kategori::JENIS_INVENTARIS)->get();

        foreach ($kategoris as $kategori) {
            $namaLower = strtolower($kategori->nama_kategori);
            $deskripsiLower = strtolower($kategori->deskripsi ?? '');
            $combinedText = $namaLower . ' ' . $deskripsiLower;

            // Check apakah termasuk retail
            $isRetail = false;
            foreach ($retailKeywords as $keyword) {
                if (str_contains($combinedText, strtolower($keyword))) {
                    $isRetail = true;
                    break;
                }
            }

            // Check apakah termasuk operasional
            $isOperasional = false;
            foreach ($operasionalKeywords as $keyword) {
                if (str_contains($combinedText, strtolower($keyword))) {
                    $isOperasional = true;
                    break;
                }
            }

            // Tentukan tipe_penggunaan
            if ($isRetail && $isOperasional) {
                $tipePenggunaan = Kategori::TIPE_BOTH;
            } elseif ($isRetail) {
                $tipePenggunaan = Kategori::TIPE_RETAIL;
            } elseif ($isOperasional) {
                $tipePenggunaan = Kategori::TIPE_OPERASIONAL;
            } else {
                // Default ke 'both' jika tidak terdeteksi
                $tipePenggunaan = Kategori::TIPE_BOTH;
            }

            // Update kategori
            $kategori->update([
                'tipe_penggunaan' => $tipePenggunaan
            ]);

            $this->command->info("Updated: {$kategori->nama_kategori} => {$tipePenggunaan}");
        }

        // Update kategori non-inventaris ke 'both' (karena tidak relevan)
        Kategori::whereIn('jenis_kategori', [
            Kategori::JENIS_LAYANAN,
            Kategori::JENIS_PENGELUARAN,
            Kategori::JENIS_CABANG
        ])->update([
            'tipe_penggunaan' => Kategori::TIPE_BOTH
        ]);

        $this->command->info('Selesai update tipe_penggunaan untuk semua kategori!');
    }
}
