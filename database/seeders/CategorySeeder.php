<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['Fruits', 'Apples, bananas,  grapes, oranges, strawberries, avocados, peaches, etc...', 'assets/images/fruits.png'],
            ['Vegetables', 'Potatoes, onions, carrots, salad greens, broccoli, peppers, tomatoes, cucumbers, etc...', 'assets/images/vegetables.png'],
            ['Canned Goods', 'Soup, tuna, fruit, beans, vegetables, pasta sauce, etc...', 'assets/images/canned_goods.png'],
            ['Dairy', 'Butter, cheese, eggs, milk, yogurt, etc...', 'assets/images/dairy.png'],
            ['Meat', 'Chicken, beef, pork, sausage, bacon etc...', 'assets/images/meat.png'],
            ['Fish', 'Shrimp, crab, cod, tuna, salmon, etc...', 'assets/images/fish.png'],
            ['Spices', 'Black pepper, oregano, cinnamon, sugar, olive oil, ketchup, mayonnaise, etc...', 'assets/images/spices.png'],
            ['Snacks', 'Chips, chocolate, pretzels, popcorn, crackers, nuts, etc...', 'assets/images/snacks.png'],
            ['Bakery', 'Bread, tortillas, pies, muffins, bagels, cookies, etc...', 'assets/images/backery.png'],
            ['Grains', 'Oats, granola, brown rice, white rice, macaroni, noodles, etc...', 'assets/images/grains.png'],
            ['Beverages', 'Coffee, teabags, milk, juice, soda etc...', 'assets/images/beverages.png'],
            ['Frozen Foods', 'Pizza, potatoes, ready meals, ice cream, etc...', 'assets/images/frozen_goods.png'],
            ['Personal Care', 'Shampoo, conditioner, deodorant, toothpaste, dental floss, etc...', 'assets/images/personal_care.png'],
            ['Cleaning', 'Laundry detergent, dish soap, dishwashing liquid, paper towels, tissues, trash bags, aluminum foil, zip bags, etc...', 'assets/images/cleaning.png'],
            ['Alcohol', 'Whiskey, Vodka, Gin, Beer, Wine, Rum, Tequila etc...', 'assets/images/alcohol.png'],
            ['Others', 'Everything else...', 'assets/images/other.png'],
            ['Favorite', 'Favorite Items...', 'assets/images/favorite.png'],
        ];

        foreach ($categories as $category) {
            DB::table('categories')->insert([
                'name' => $category[0],
                'description' => $category[1],
                'image' => $category[2],
                'business_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
