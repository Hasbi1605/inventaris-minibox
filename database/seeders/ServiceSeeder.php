<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Service;
use App\Models\Category;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $potongRambut = Category::where('name', 'Potong Rambut')->first();
        $perawatanRambut = Category::where('name', 'Perawatan Rambut')->first();
        $perawatanWajah = Category::where('name', 'Perawatan Wajah')->first();

        // Layanan Potong Rambut
        Service::create([
            'category_id' => $potongRambut->id,
            'name' => 'Potong Rambut Classic',
            'description' => 'Potong rambut gaya klasik',
            'price' => 25000,
            'cost' => 5000,
            'duration' => 30,
            'is_active' => true
        ]);

        Service::create([
            'category_id' => $potongRambut->id,
            'name' => 'Potong Rambut Modern',
            'description' => 'Potong rambut gaya modern dan trendy',
            'price' => 35000,
            'cost' => 7000,
            'duration' => 45,
            'is_active' => true
        ]);

        Service::create([
            'category_id' => $potongRambut->id,
            'name' => 'Potong Rambut Premium',
            'description' => 'Potong rambut premium dengan konsultasi styling',
            'price' => 50000,
            'cost' => 10000,
            'duration' => 60,
            'is_active' => true
        ]);

        // Layanan Perawatan Rambut
        Service::create([
            'category_id' => $perawatanRambut->id,
            'name' => 'Hair Wash & Blow',
            'description' => 'Cuci rambut dan blow dry',
            'price' => 15000,
            'cost' => 3000,
            'duration' => 20,
            'is_active' => true
        ]);

        Service::create([
            'category_id' => $perawatanRambut->id,
            'name' => 'Hair Treatment',
            'description' => 'Perawatan rambut dengan vitamin',
            'price' => 40000,
            'cost' => 12000,
            'duration' => 45,
            'is_active' => true
        ]);

        Service::create([
            'category_id' => $perawatanRambut->id,
            'name' => 'Hair Coloring',
            'description' => 'Pewarnaan rambut profesional',
            'price' => 75000,
            'cost' => 25000,
            'duration' => 90,
            'is_active' => true
        ]);

        // Layanan Perawatan Wajah
        Service::create([
            'category_id' => $perawatanWajah->id,
            'name' => 'Beard Trim',
            'description' => 'Potong dan rapikan jenggot',
            'price' => 20000,
            'cost' => 3000,
            'duration' => 25,
            'is_active' => true
        ]);

        Service::create([
            'category_id' => $perawatanWajah->id,
            'name' => 'Face Treatment',
            'description' => 'Perawatan wajah lengkap',
            'price' => 45000,
            'cost' => 15000,
            'duration' => 50,
            'is_active' => true
        ]);

        Service::create([
            'category_id' => $perawatanWajah->id,
            'name' => 'Hot Towel Shave',
            'description' => 'Cukur dengan handuk panas',
            'price' => 30000,
            'cost' => 5000,
            'duration' => 35,
            'is_active' => true
        ]);
    }
}
