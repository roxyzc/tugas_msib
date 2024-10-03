<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DataMaster\M_customer;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $customers = [
            [
                'name' => 'Customer A',
                'email' => 'customerA@example.com',
                'phone' => '1112223333',
            ],
            [
                'name' => 'Customer B',
                'email' => 'customerB@example.com',
                'phone' => '4445556666',
            ],
            [
                'name' => 'Customer C',
                'email' => 'customerC@example.com',
                'phone' => '7778889999',
            ],
            [
                'name' => 'Customer D',
                'email' => 'customerD@example.com',
                'phone' => '0001112222',
            ],
            [
                'name' => 'Customer E',
                'email' => 'customerE@example.com',
                'phone' => '3334445555',
            ],
        ];

        foreach ($customers as $customer) {
            M_customer::create($customer);
        }
    }
}
