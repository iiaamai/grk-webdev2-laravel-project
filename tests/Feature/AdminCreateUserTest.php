<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminCreateUserTest extends TestCase
{
    use RefreshDatabase;

    public function test_system_admin_can_create_staff_user(): void
    {
        $admin = User::factory()->systemAdmin()->create();

        $response = $this->actingAs($admin)->post(route('admin.users.store'), [
            'name' => 'New Staff',
            'email' => 'new.staff@example.com',
            'mobile' => '09170001111',
            'role' => UserRole::Staff->value,
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertRedirect(route('admin.home'));

        $staff = User::query()->where('email', 'new.staff@example.com')->first();
        $this->assertNotNull($staff);
        $this->assertSame(UserRole::Staff, $staff->role);
        $this->assertNotNull($staff->email_verified_at);
    }

    public function test_system_admin_can_create_driver_with_vehicle_fields(): void
    {
        $admin = User::factory()->systemAdmin()->create();

        $this->actingAs($admin)->post(route('admin.users.store'), [
            'name' => 'Fleet Driver',
            'email' => 'fleet.driver@example.com',
            'role' => UserRole::Driver->value,
            'vehicle_type' => 'L300 van',
            'plate' => 'VAN-1001',
            'capacity_kg' => 1000,
            'password' => 'password',
            'password_confirmation' => 'password',
        ])->assertRedirect(route('admin.home'));

        $driver = User::query()->where('email', 'fleet.driver@example.com')->first();
        $this->assertNotNull($driver);
        $this->assertSame('VAN-1001', $driver->plate);
    }

    public function test_non_admin_cannot_create_users(): void
    {
        $staff = User::factory()->staff()->create();

        $this->actingAs($staff)
            ->post(route('admin.users.store'), [
                'name' => 'Nope',
                'email' => 'nope@example.com',
                'role' => UserRole::Staff->value,
                'password' => 'password',
                'password_confirmation' => 'password',
            ])
            ->assertRedirect(route('staff.home'));

        $this->assertDatabaseMissing('users', ['email' => 'nope@example.com']);
    }

    public function test_guest_cannot_create_users(): void
    {
        $this->post(route('admin.users.store'), [
            'name' => 'Nope',
            'email' => 'nope@example.com',
            'role' => UserRole::Staff->value,
            'password' => 'password',
            'password_confirmation' => 'password',
        ])->assertRedirect(route('login'));
    }
}
