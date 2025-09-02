<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $shampo = Category::where('name', 'Shampo')->first();
        $hairStyling = Category::where('name', 'Hair Styling')->first();
        $perawatanJenggot = Category::where('name', 'Perawatan Jenggot')->first();
        $alatBarbershop = Category::where('name', 'Alat Barbershop')->first();

        // Produk Shampo
        Product::create([
            'category_id' => $shampo->id,
            'name' => 'Shampo Anti Ketombe',
            'description' => 'Shampo khusus untuk mengatasi ketombe',
            'sku' => 'SHP001',
            'barcode' => '1234567890123',
            'purchase_price' => 35000,
            'selling_price' => 50000,
            'stock_quantity' => 50,
            'min_stock' => 10,
            'unit' => 'botol',
            'is_active' => true
        ]);

        Product::create([
            'category_id' => $shampo->id,
            'name' => 'Shampo Herbal',
            'description' => 'Shampo dengan bahan herbal alami',
            'sku' => 'SHP002',
            'barcode' => '1234567890124',
            'purchase_price' => 40000,
            'selling_price' => 60000,
            'stock_quantity' => 30,
            'min_stock' => 8,
            'unit' => 'botol',
            'is_active' => true
        ]);

        // Produk Hair Styling
        Product::create([
            'category_id' => $hairStyling->id,
            'name' => 'Pomade Classic',
            'description' => 'Pomade untuk gaya rambut klasik',
            'sku' => 'POM001',
            'barcode' => '1234567890125',
            'purchase_price' => 25000,
            'selling_price' => 40000,
            'stock_quantity' => 40,
            'min_stock' => 10,
            'unit' => 'jar',
            'is_active' => true
        ]);

        Product::create([
            'category_id' => $hairStyling->id,
            'name' => 'Hair Wax Strong Hold',
            'description' => 'Hair wax dengan daya tahan kuat',
            'sku' => 'WAX001',
            'barcode' => '1234567890126',
            'purchase_price' => 30000,
            'selling_price' => 45000,
            'stock_quantity' => 25,
            'min_stock' => 8,
            'unit' => 'jar',
            'is_active' => true
        ]);

        Product::create([
            'category_id' => $hairStyling->id,
            'name' => 'Hair Gel',
            'description' => 'Gel rambut untuk styling',
            'sku' => 'GEL001',
            'barcode' => '1234567890127',
            'purchase_price' => 15000,
            'selling_price' => 25000,
            'stock_quantity' => 35,
            'min_stock' => 12,
            'unit' => 'tube',
            'is_active' => true
        ]);

        // Produk Perawatan Jenggot
        Product::create([
            'category_id' => $perawatanJenggot->id,
            'name' => 'Beard Oil',
            'description' => 'Minyak perawatan jenggot',
            'sku' => 'BOL001',
            'barcode' => '1234567890128',
            'purchase_price' => 45000,
            'selling_price' => 70000,
            'stock_quantity' => 20,
            'min_stock' => 5,
            'unit' => 'botol',
            'is_active' => true
        ]);

        Product::create([
            'category_id' => $perawatanJenggot->id,
            'name' => 'Beard Balm',
            'description' => 'Balm untuk melembabkan jenggot',
            'sku' => 'BBL001',
            'barcode' => '1234567890129',
            'purchase_price' => 40000,
            'selling_price' => 65000,
            'stock_quantity' => 15,
            'min_stock' => 5,
            'unit' => 'jar',
            'is_active' => true
        ]);

        // Alat Barbershop
        Product::create([
            'category_id' => $alatBarbershop->id,
            'name' => 'Sisir Rambut Professional',
            'description' => 'Sisir rambut kualitas profesional',
            'sku' => 'CMB001',
            'barcode' => '1234567890130',
            'purchase_price' => 25000,
            'selling_price' => 40000,
            'stock_quantity' => 10,
            'min_stock' => 3,
            'unit' => 'pcs',
            'is_active' => true
        ]);

        Product::create([
            'category_id' => $alatBarbershop->id,
            'name' => 'Handuk Kecil',
            'description' => 'Handuk kecil untuk barbershop',
            'sku' => 'TWL001',
            'barcode' => '1234567890131',
            'purchase_price' => 15000,
            'selling_price' => 25000,
            'stock_quantity' => 20,
            'min_stock' => 8,
            'unit' => 'pcs',
            'is_active' => true
        ]);

        Product::create([
            'category_id' => $alatBarbershop->id,
            'name' => 'Spray Bottle',
            'description' => 'Botol spray untuk air',
            'sku' => 'SPR001',
            'barcode' => '1234567890132',
            'purchase_price' => 12000,
            'selling_price' => 20000,
            'stock_quantity' => 15,
            'min_stock' => 5,
            'unit' => 'pcs',
            'is_active' => true
        ]);
    }
}
