<?php

namespace Database\Seeders;

use App\Models\Business;
use Illuminate\Database\Seeder;

class BusinessSeeder extends Seeder
{
    public function run(): void
    {
        $businesses = [
            [
                'name' => 'Ruban By Salwa',
                'phone' => '+9613394873',
                'address' => 'Msharafiye, jnah, haret hreik',
                'email' => 'contact@ruban.com',
                'logo' => 'assets/images/logo.png',
                'tax_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        foreach ($businesses as $business) {
            Business::create($business);
        }
    }
}
