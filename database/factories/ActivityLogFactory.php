<?php

namespace Database\Factories;

use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ActivityLog>
 */
class ActivityLogFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'action' => 'user.login',
            'subject_type' => User::class,
            'subject_id' => null,
            'description' => 'User logged in',
            'ip_address' => fake()->ipv4(),
            'ip_location' => 'Metro Manila, PH',
            'geo_lat' => 14.5995,
            'geo_lng' => 120.9842,
            'properties' => null,
            'created_at' => now(),
        ];
    }
}
