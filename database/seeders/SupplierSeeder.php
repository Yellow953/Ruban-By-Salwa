<?php

namespace Database\Seeders;

use App\Models\Business;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SupplierSeeder extends Seeder
{
    public function run(): void
    {
        $businesses = Business::all();

        foreach ($businesses as $business) {
            $suppliers = [
                [
                    'name' => 'Supplier 1',
                    'phone' => '123456789',
                    'address' => 'test address',
                    'email' => 'supplier1@gmail.com',
                    'business_id' => $business->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'DHL',
                    'phone' => '+4915204820649',
                    'address' => 'testing',
                    'email' => 'support@dhl.de',
                    'business_id' => $business->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            ];

            foreach ($suppliers as $supplier) {
                DB::table('suppliers')->insert($supplier);
            }
        }
    }
}
