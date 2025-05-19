<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TableSeeder extends Seeder
{
    public function run(): void
    {
        // Predefined table data
        $tables = [
            ['code' => 'T01', 'seats' => 8, 'location' => 'Main Floor', 'status' => 'occupied', 'notes' => 'Large group table', 'business_id' => 1],
            ['code' => 'T02', 'seats' => 4, 'location' => 'Patio', 'status' => 'available', 'notes' => null, 'business_id' => 1],
            ['code' => 'T03', 'seats' => 6, 'location' => 'VIP Section', 'status' => 'reserved', 'notes' => null, 'business_id' => 2],
            ['code' => 'T04', 'seats' => 2, 'location' => 'Bar Area', 'status' => 'available', 'notes' => null, 'business_id' => 2],
            ['code' => 'T05', 'seats' => 10, 'location' => 'Terrace', 'status' => 'maintenance', 'notes' => 'Needs repair', 'business_id' => 3],
        ];

        // Insert predefined tables into the database
        foreach ($tables as $table) {
            DB::table('tables')->insert([
                'code' => $table['code'],
                'seats' => $table['seats'],
                'location' => $table['location'],
                'status' => $table['status'],
                'notes' => $table['notes'],
                'business_id' => $table['business_id'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

