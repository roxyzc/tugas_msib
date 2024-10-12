<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Product::create([
            'name' => 'Kipas',
            'category' => 'Elektronik',
            'price' => 50000
        ]);

        \App\Models\Product::create([
            'name' => 'AC',
            'category' => 'Elektronik',
            'price' => 150000
        ]);

        \App\Models\Product::create([
            'name' => 'Televisi',
            'category' => 'Elektronik',
            'price' => 250000,
        ]);

        \App\Models\Product::create([
            'name' => 'Laptop',
            'category' => 'Elektronik',
            'price' => 700000,
        ]);

        \App\Models\Product::create([
            'name' => 'Buku Fiksi',
            'category' => 'Buku',
            'price' => 80000,
        ]);

        \App\Models\Product::create([
            'name' => 'Pensil',
            'category' => 'Alat Tulis',
            'price' => 5000,
        ]);

        \App\Models\Product::create([
            'name' => 'Sepatu Olahraga',
            'category' => 'Pakaian',
            'price' => 300000,
        ]);

        \App\Models\Product::create([
            'name' => 'Sofa',
            'category' => 'Furniture',
            'price' => 1500000,
        ]);

        \App\Models\Product::create([
            'name' => 'Panci',
            'category' => 'Peralatan Dapur',
            'price' => 70000,
        ]);
    }
}
