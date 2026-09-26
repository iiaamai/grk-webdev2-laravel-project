<?php

namespace Database\Seeders;

use App\Enums\VehicleStatus;
use App\Models\Vehicle;
use Illuminate\Database\Seeder;

class VehicleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vehicles = [
            [
                'plate_number' => 'ABC-1234',
                'label' => 'Unit Alpha',
                'type' => '4-wheeler truck',
                'capacity_kg' => 3000,
                'status' => VehicleStatus::Available,
            ],
            [
                'plate_number' => 'DEF-5678',
                'label' => 'Unit Bravo',
                'type' => '6-wheeler (Isuzu / Fuso)',
                'capacity_kg' => 12000,
                'status' => VehicleStatus::Available,
            ],
            [
                'plate_number' => 'GHI-9012',
                'label' => 'Unit Charlie',
                'type' => 'L300 van',
                'capacity_kg' => 1000,
                'status' => VehicleStatus::Available,
            ],
            [
                'plate_number' => 'JKL-3456',
                'label' => 'Unit Delta',
                'type' => 'Reefer / specialized',
                'capacity_kg' => 5000,
                'status' => VehicleStatus::Available,
            ],
            [
                'plate_number' => 'MNO-7890',
                'label' => 'Unit Echo (shop)',
                'type' => '4-wheeler truck',
                'capacity_kg' => 3000,
                'status' => VehicleStatus::Maintenance,
            ],
        ];

        foreach ($vehicles as $vehicle) {
            Vehicle::query()->updateOrCreate(
                ['plate_number' => $vehicle['plate_number']],
                $vehicle,
            );
        }
    }
}
