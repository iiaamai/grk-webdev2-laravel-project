<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PricingSeeder::class,
            VehicleSeeder::class,
            UserSeeder::class,
            SettingSeeder::class,
            BookingSeeder::class,
        ]);
    }
}
