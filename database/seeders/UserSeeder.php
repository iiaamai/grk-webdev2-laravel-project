<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'System Admin',
                'email' => 'admin@gk.test',
                'password' => Hash::make('admin123'),
                'mobile' => '09170000001',
                'role' => UserRole::SystemAdmin,
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Staff User',
                'email' => 'staff@gk.test',
                'password' => Hash::make('staff123'),
                'mobile' => '09170000002',
                'role' => UserRole::Staff,
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Demo Customer',
                'email' => 'customer@gk.test',
                'password' => Hash::make('demo123'),
                'mobile' => '09170000003',
                'role' => UserRole::Customer,
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Demo Driver',
                'email' => 'driver@gk.test',
                'password' => Hash::make('demo123'),
                'mobile' => '09170000004',
                'role' => UserRole::Driver,
                'vehicle_type' => '4-wheeler truck',
                'plate' => 'ABC-1234',
                'capacity_kg' => 3000,
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Demo Driver Two',
                'email' => 'driver2@gk.test',
                'password' => Hash::make('demo123'),
                'mobile' => '09170000005',
                'role' => UserRole::Driver,
                'vehicle_type' => '6-wheeler (Isuzu / Fuso)',
                'plate' => 'DEF-5678',
                'capacity_kg' => 12000,
                'email_verified_at' => now(),
            ],
        ];

        foreach ($users as $user) {
            User::query()->updateOrCreate(
                ['email' => $user['email']],
                $user,
            );
        }
    }
}
