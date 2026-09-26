<?php

namespace Database\Seeders;

use App\Models\Pricing;
use Illuminate\Database\Seeder;

class PricingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rows = [
            ['vehicle_type' => '6-wheeler (Isuzu / Fuso)', 'amount' => 14500.00],
            ['vehicle_type' => '4-wheeler truck', 'amount' => 9200.00],
            ['vehicle_type' => 'L300 van', 'amount' => 4500.00],
            ['vehicle_type' => 'Reefer / specialized', 'amount' => 18500.00],
        ];

        foreach ($rows as $row) {
            Pricing::query()->updateOrCreate(
                ['vehicle_type' => $row['vehicle_type']],
                ['amount' => $row['amount']],
            );
        }
    }
}
