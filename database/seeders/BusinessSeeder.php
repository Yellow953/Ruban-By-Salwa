<?php

namespace Database\Seeders;

use App\Models\Business;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BusinessSeeder extends Seeder
{
    public function run(): void
    {
        $businesses = [
            [
                'name' => 'YellowTech',
                'phone' => '+96170285659',
                'address' => 'Lebanon, Beirut, Dora',
                'email' => 'yellow.tech.953@gmail.com',
                'website' => 'https://yellowtech.dev',
                'logo' => 'assets/images/logo.png',
                'tax_id' => 1,
                'type' => 'Grocery Store',
                'menu_activated' => false,
                'ordering_activated' => false,
                'delivery_activated' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'YellowDine',
                'phone' => '+96170285659',
                'address' => 'Lebanon, Beirut, Dora',
                'email' => 'yellowdine@gmail.com',
                'website' => null,
                'logo' => 'assets/images/no_img.png',
                'tax_id' => 1,
                'type' => 'Restaurant',
                'menu_activated' => false,
                'ordering_activated' => false,
                'delivery_activated' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'YellowFashion',
                'phone' => '+96170285659',
                'address' => 'Lebanon, Beirut, Dora',
                'email' => 'yellowfashion@gmail.com',
                'website' => null,
                'logo' => 'assets/images/no_img.png',
                'tax_id' => 1,
                'type' => 'Clothing Store',
                'menu_activated' => false,
                'ordering_activated' => false,
                'delivery_activated' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // [
            //     'name' => 'YellowShop',
            //     'phone' => '+96170285659',
            //     'address' => 'Lebanon, Beirut, Dora',
            //     'email' => 'yellowshop@gmail.com',
            //     'website' => null,
            //     'logo' => 'assets/images/no_img.png',
            //     'tax_id' => 1,
            //     'type' => 'Shop',
            //     'menu_activated' => false,
            //     'ordering_activated' => false,
            //     'delivery_activated' => false,
            //     'created_at' => now(),
            //     'updated_at' => now(),
            // ],
            // [
            //     'name' => 'YellowResort',
            //     'phone' => '+96170285659',
            //     'address' => 'Lebanon, Beirut, Dora',
            //     'email' => 'yellowresort@gmail.com',
            //     'website' => null,
            //     'logo' => 'assets/images/no_img.png',
            //     'tax_id' => 1,
            //     'type' => 'Clothing Store',
            //     'menu_activated' => false,
            //     'ordering_activated' => false,
            //     'delivery_activated' => false,
            //     'created_at' => now(),
            //     'updated_at' => now(),
            // ],
        ];

        foreach ($businesses as $business) {
            $model = Business::create($business);

            $operating_hours = [
                ['business_id' => $model->id, 'day' => 'Monday', 'open' => true, 'opening_hour' => '08:00 AM', 'closing_hour' => '06:00 PM', 'created_at' => now(), 'updated_at' => now()],
                ['business_id' => $model->id, 'day' => 'Tuesday', 'open' => true, 'opening_hour' => '08:00 AM', 'closing_hour' => '06:00 PM', 'created_at' => now(), 'updated_at' => now()],
                ['business_id' => $model->id, 'day' => 'Wednesday', 'open' => true, 'opening_hour' => '08:00 AM', 'closing_hour' => '06:00 PM', 'created_at' => now(), 'updated_at' => now()],
                ['business_id' => $model->id, 'day' => 'Thursday', 'open' => true, 'opening_hour' => '08:00 AM', 'closing_hour' => '06:00 PM', 'created_at' => now(), 'updated_at' => now()],
                ['business_id' => $model->id, 'day' => 'Friday', 'open' => true, 'opening_hour' => '08:00 AM', 'closing_hour' => '06:00 PM', 'created_at' => now(), 'updated_at' => now()],
                ['business_id' => $model->id, 'day' => 'Saturday', 'open' => false, 'opening_hour' => null, 'closing_hour' => null, 'created_at' => now(), 'updated_at' => now()],
                ['business_id' => $model->id, 'day' => 'Sunday', 'open' => false, 'opening_hour' => null, 'closing_hour' => null, 'created_at' => now(), 'updated_at' => now()],
            ];

            DB::table('operating_hours')->insert($operating_hours);
        }
    }
}
