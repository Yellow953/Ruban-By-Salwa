<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $grocery_store_categories = [
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

        $restaurant_categories = [
            ['Main Dish', 'A selection of hearty and satisfying meals, including steaks, grilled chicken, pasta, and more.', 'assets/images/dish.png'],
            ['Fries', 'Crispy, golden fries served plain or with delicious toppings and seasonings.', 'assets/images/fries.png'],
            ['Burgers', 'Juicy and flavorful burgers with a variety of toppings, served on a soft bun.', 'assets/images/hamburger.png'],
            ['Deserts', 'Indulge in a variety of sweet treats, including cakes, ice cream, pastries, and more.', 'assets/images/icecream.png'],
            ['Pizza', 'Delicious, freshly baked pizzas with a variety of toppings and crust options.', 'assets/images/pizza.png'],
            ['Salads', 'Fresh and healthy salads made with crisp greens, vegetables, proteins, and flavorful dressings.', 'assets/images/salads.png'],
            ['Sandwich', 'Tasty sandwiches filled with fresh ingredients, served hot or cold.', 'assets/images/sandwish.png'],
            ['Starters', 'Appetizing small plates to start your meal, including soups, dips, and finger foods.', 'assets/images/starters.png'],
            ['Platters', 'Generous portions of meat, seafood, or mixed items served with sides for a fulfilling meal.', 'assets/images/steak.png'],
            ['Tacos', 'Authentic and flavorful tacos filled with meats, veggies, and tasty toppings.', 'assets/images/tacos.png'],
            ['Others', 'Everything else...', 'assets/images/other.png'],
            ['Favorite', 'Favorite Items...', 'assets/images/favorite.png'],
        ];

        $clothing_store_categories = [
            ['Dress', 'Elegant and stylish dresses for every occasion, from casual to formal wear.', 'assets/images/dress.png'],
            ['High Heel', 'Chic and fashionable high heels to complete your outfit.', 'assets/images/highheel.png'],
            ['Hoodies', 'Comfortable and trendy hoodies for casual and sporty looks.', 'assets/images/hoodies.png'],
            ['Pants', 'A variety of pants, including jeans, chinos, leggings, and dress pants.', 'assets/images/pants.png'],
            ['Shirt', 'Classic and modern shirts for men and women, perfect for any style.', 'assets/images/shirt.png'],
            ['Shorts', 'Casual and stylish shorts for warm-weather outfits.', 'assets/images/shorts.png'],
            ['Skirt', 'Trendy and elegant skirts in various styles, from mini to maxi.', 'assets/images/skirt.png'],
            ['Shoes', 'A wide selection of shoes, including sneakers, loafers, and boots.', 'assets/images/sneakers.png'],
            ['Sports Wear', 'Activewear and athletic clothing designed for comfort and performance.', 'assets/images/sportswear.png'],
            ['Suits', 'Tailored suits for professional, formal, and special occasions.', 'assets/images/suits.png'],
            ['Sweater', 'Cozy and stylish sweaters to keep you warm and fashionable.', 'assets/images/sweater.png'],
            ['Others', 'Everything else...', 'assets/images/other.png'],
            ['Favorite', 'Favorite Items...', 'assets/images/favorite.png'],
        ];

        foreach ($grocery_store_categories as $category) {
            DB::table('categories')->insert([
                'name' => $category[0],
                'description' => $category[1],
                'image' => $category[2],
                'business_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        foreach ($restaurant_categories as $category) {
            DB::table('categories')->insert([
                'name' => $category[0],
                'description' => $category[1],
                'image' => $category[2],
                'business_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        foreach ($clothing_store_categories as $category) {
            DB::table('categories')->insert([
                'name' => $category[0],
                'description' => $category[1],
                'image' => $category[2],
                'business_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
