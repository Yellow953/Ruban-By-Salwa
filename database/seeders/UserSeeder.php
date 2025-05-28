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
                'name' => 'admin',
                'phone' => '9613394873',
                'role' => 'admin',
                'email' => 'admin@rubanbysalwa.shop',
                'image' => 'assets/images/default_profile.png',
                'password' => Hash::make('qwe123'),
                'currency_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'stock',
                'phone' => '9613394873',
                'role' => 'stock',
                'email' => 'stock@rubanbysalwa.shop',
                'image' => 'assets/images/default_profile.png',
                'password' => Hash::make('qwe123'),
                'currency_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'user',
                'phone' => '9613394873',
                'role' => 'user',
                'email' => 'user@rubanbysalwa.shop',
                'image' => 'assets/images/default_profile.png',
                'password' => Hash::make('qwe123'),
                'currency_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
