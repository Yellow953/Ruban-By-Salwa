<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $categoryIds = DB::table('categories')->pluck('id')->toArray();

        for ($i = 0; $i < 50; $i++) {
            DB::table('products')->insert([
                'name' => Str::random(10),
                'category_id' => $categoryIds[array_rand($categoryIds)],
                'quantity' => rand(1, 100),
                'cost' => rand(1, 50),
                'price' => rand(1, 100),
                'description' => Str::random(25),
                'image' => 'assets/images/no_img.png',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
