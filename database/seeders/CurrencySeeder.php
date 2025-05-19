<?php

namespace Database\Seeders;

use App\Models\Business;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CurrencySeeder extends Seeder
{
    public function run(): void
    {
        $businesses = Business::all();

        foreach ($businesses as $business) {
            $currencies = [
                [
                    'code' => 'USD',
                    'name' => 'US Dollar',
                    'symbol' => '$',
                    'rate' => 1,
                    'business_id' => $business->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'code' => 'LBP',
                    'name' => 'Lebanese Bank Pound',
                    'symbol' => 'LBP',
                    'rate' => 89000,
                    'business_id' => $business->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ];

            foreach ($currencies as $currency) {
                DB::table('currencies')->insert($currency);
            }
        }
    }
}
