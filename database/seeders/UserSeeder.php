<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'super admin',
                'phone' => '96170285659',
                'role' => 'super admin',
                'email' => 'super@admin.com',
                'image' => 'assets/images/default_profile.png',
                'password' => Hash::make('qwe123'),
                'terms_agreed' => true,
                'terms_agreed_at' => now(),
                'business_id' => 1,
                'currency_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'email_verified_at' => now(),
            ],
            [
                'name' => 'admin',
                'phone' => '96170285659',
                'role' => 'admin',
                'email' => 'test@admin.com',
                'image' => 'assets/images/default_profile.png',
                'password' => Hash::make('qwe123'),
                'terms_agreed' => true,
                'terms_agreed_at' => now(),
                'business_id' => 1,
                'currency_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'email_verified_at' => now(),
            ],
            [
                'name' => 'user',
                'phone' => '96170285659',
                'role' => 'user',
                'email' => 'test@test.com',
                'image' => 'assets/images/default_profile.png',
                'password' => Hash::make('qwe123'),
                'terms_agreed' => true,
                'terms_agreed_at' => now(),
                'business_id' => 1,
                'currency_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Restaurant',
                'phone' => '96170285659',
                'role' => 'admin',
                'email' => 'restaurant@yellow-pos.com',
                'image' => 'assets/images/default_profile.png',
                'password' => Hash::make('qwe123'),
                'terms_agreed' => true,
                'terms_agreed_at' => now(),
                'business_id' => 2,
                'currency_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Clothing Store',
                'phone' => '96170285659',
                'role' => 'admin',
                'email' => 'clothing@yellow-pos.com',
                'image' => 'assets/images/default_profile.png',
                'password' => Hash::make('qwe123'),
                'terms_agreed' => true,
                'terms_agreed_at' => now(),
                'business_id' => 3,
                'currency_id' => 5,
                'created_at' => now(),
                'updated_at' => now(),
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Shop',
                'phone' => '96170285659',
                'role' => 'admin',
                'email' => 'shop@yellow-pos.com',
                'image' => 'assets/images/default_profile.png',
                'password' => Hash::make('qwe123'),
                'terms_agreed' => true,
                'terms_agreed_at' => now(),
                'business_id' => 3,
                'currency_id' => 5,
                'created_at' => now(),
                'updated_at' => now(),
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Resort',
                'phone' => '96170285659',
                'role' => 'admin',
                'email' => 'resort@yellow-pos.com',
                'image' => 'assets/images/default_profile.png',
                'password' => Hash::make('qwe123'),
                'terms_agreed' => true,
                'terms_agreed_at' => now(),
                'business_id' => 3,
                'currency_id' => 5,
                'created_at' => now(),
                'updated_at' => now(),
                'email_verified_at' => now(),
            ],
        ];

        foreach ($users as $user_row) {
            $user = User::create($user_row);

            $user->subscription()->create([
                'starts_at' => now(),
                'ends_at' => now()->addDays(90),
                'is_active' => true,
            ]);
        }
    }
}
