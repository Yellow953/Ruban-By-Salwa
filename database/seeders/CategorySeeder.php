<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['Category 1', 'Category 1 ...', 'assets/images/no_img.png'],
            ['Others', 'Everything else...', 'assets/images/no_img.png'],
            ['Favorite', 'Favorite Items...', 'assets/images/no_img.png'],
        ];

        foreach ($categories as $category) {
            DB::table('categories')->insert([
                'name' => $category[0],
                'description' => $category[1],
                'image' => $category[2],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
