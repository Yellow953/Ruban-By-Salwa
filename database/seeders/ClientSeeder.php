<?php

namespace Database\Seeders;

use App\Models\Business;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClientSeeder extends Seeder
{
    public function run(): void
    {
        $businesses = Business::all();

        foreach ($businesses as $business) {
            DB::table('clients')->insert([
                'name' => 'Client 1',
                'phone' => '123456789',
                'address' => 'test address',
                'email' => 'client1@gmail.com',
                'business_id' => $business->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
