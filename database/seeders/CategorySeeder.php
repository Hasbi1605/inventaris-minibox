<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Kategori untuk layanan
        Category::create([
            'name' => 'Potong Rambut',
            'description' => 'Berbagai layanan potong rambut',
            'type' => 'service',
            'is_active' => true
        ]);

        Category::create([
            'name' => 'Perawatan Rambut',
            'description' => 'Layanan perawatan dan styling rambut',
            'type' => 'service',
            'is_active' => true
        ]);

        Category::create([
            'name' => 'Perawatan Wajah',
            'description' => 'Layanan perawatan wajah dan jenggot',
            'type' => 'service',
            'is_active' => true
        ]);

        // Kategori untuk produk
        Category::create([
            'name' => 'Shampo',
            'description' => 'Berbagai jenis shampo',
            'type' => 'product',
            'is_active' => true
        ]);

        Category::create([
            'name' => 'Hair Styling',
            'description' => 'Produk untuk styling rambut',
            'type' => 'product',
            'is_active' => true
        ]);

        Category::create([
            'name' => 'Perawatan Jenggot',
            'description' => 'Produk perawatan jenggot dan kumis',
            'type' => 'product',
            'is_active' => true
        ]);

        Category::create([
            'name' => 'Alat Barbershop',
            'description' => 'Peralatan dan aksesoris barbershop',
            'type' => 'product',
            'is_active' => true
        ]);
    }
}
