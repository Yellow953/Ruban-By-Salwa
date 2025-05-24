<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['Hard goods', 'Hard goods ...', 'assets/images/no_img.png'],
            ['Home decoration', 'Home decoration ...', 'assets/images/no_img.png'],
            ['Hand made', 'Hand made ...', 'assets/images/no_img.png'],
            ['Plants and flowers', 'Plants and flowers ...', 'assets/images/no_img.png'],
            ['home fragrances', 'home fragrances ...', 'assets/images/no_img.png'],
            ['Home collection', 'Home collection ...', 'assets/images/no_img.png'],
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
