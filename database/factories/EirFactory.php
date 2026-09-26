<?php

namespace Database\Factories;

use App\Models\Booking;
use App\Models\Eir;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Eir>
 */
class EirFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'booking_id' => Booking::factory(),
            'eir_path' => 'bookings/demo/eir.jpg',
            'uploaded_at' => now(),
        ];
    }
}
