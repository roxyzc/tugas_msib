<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DataMaster\M_supplier;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $suppliers = [
            [
                'name' => 'Supplier A',
                'contact_person' => 'John Doe',
                'email' => 'john@example.com',
                'phone' => '1234567890',
                'address' => 'Address of Supplier A',
            ],
            [
                'name' => 'Supplier B',
                'contact_person' => 'Jane Smith',
                'email' => 'jane@example.com',
                'phone' => '0987654321',
                'address' => 'Address of Supplier B',
            ],
            [
                'name' => 'Supplier C',
                'contact_person' => 'Alice Johnson',
                'email' => 'alice@example.com',
                'phone' => '4567890123',
                'address' => 'Address of Supplier C',
            ],
            [
                'name' => 'Supplier D',
                'contact_person' => 'Bob Brown',
                'email' => 'bob@example.com',
                'phone' => '3216549870',
                'address' => 'Address of Supplier D',
            ],
            [
                'name' => 'Supplier E',
                'contact_person' => 'Charlie White',
                'email' => 'charlie@example.com',
                'phone' => '7890123456',
                'address' => 'Address of Supplier E',
            ],
        ];

        foreach ($suppliers as $supplier) {
            M_supplier::create($supplier);
        }
    }
}
