<?php

namespace Database\Factories;

use App\Enums\VehicleStatus;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Vehicle>
 */
class VehicleFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'plate_number' => strtoupper(fake()->unique()->bothify('???-####')),
            'label' => fake()->words(2, true),
            'type' => fake()->randomElement([
                '6-wheeler (Isuzu / Fuso)',
                '4-wheeler truck',
                'L300 van',
                'Reefer / specialized',
            ]),
            'capacity_kg' => fake()->randomElement([1000, 2000, 3000, 8000, 12000]),
            'status' => VehicleStatus::Available,
        ];
    }

    public function available(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => VehicleStatus::Available,
        ]);
    }

    public function inUse(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => VehicleStatus::InUse,
        ]);
    }

    public function maintenance(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => VehicleStatus::Maintenance,
        ]);
    }
}
