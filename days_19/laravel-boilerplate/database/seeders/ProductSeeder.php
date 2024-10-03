<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DataMaster\M_product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = [
            [
                'name' => 'Product A',
                'sku' => 'SKU001',
                'price' => 10000.00,
                'stock' => 50,
            ],
            [
                'name' => 'Product B',
                'sku' => 'SKU002',
                'price' => 20000.00,
                'stock' => 30,
            ],
            [
                'name' => 'Product C',
                'sku' => 'SKU003',
                'price' => 15000.00,
                'stock' => 20,
            ],
            [
                'name' => 'Product D',
                'sku' => 'SKU004',
                'price' => 30000.00,
                'stock' => 10,
            ],
            [
                'name' => 'Product E',
                'sku' => 'SKU005',
                'price' => 25000.00,
                'stock' => 0,
            ],
        ];

        foreach ($products as $product) {
            M_product::create($product);
        }
    }
}
