<?php

namespace Tests\Feature;

use App\Enums\BookingStatus;
use App\Enums\VehicleStatus;
use App\Models\Booking;
use App\Models\Pricing;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class StaffAdminBookingTest extends TestCase
{
    use RefreshDatabase;

    public function test_staff_can_update_booking_before_gatepass(): void
    {
        $staff = User::factory()->staff()->create();
        Pricing::factory()->create(['vehicle_type' => '4-wheeler truck', 'amount' => 9200]);
        $booking = Booking::factory()->create([
            'pickup_address' => 'Old pickup',
        ]);

        $this->actingAs($staff)
            ->put(route('staff.bookings.update', $booking), $this->bookingPayload($booking, [
                'pickup_address' => 'New pickup',
            ]))
            ->assertRedirect(route('staff.bookings.show', $booking));

        $this->assertSame('New pickup', $booking->fresh()->pickup_address);
    }

    public function test_staff_cannot_update_booking_after_gatepass(): void
    {
        $staff = User::factory()->staff()->create();
        $booking = Booking::factory()->withGatepass()->create();

        $this->actingAs($staff)
            ->put(route('staff.bookings.update', $booking), $this->bookingPayload($booking, [
                'pickup_address' => 'Blocked',
            ]))
            ->assertForbidden();
    }

    public function test_staff_can_upload_gatepass_once(): void
    {
        Storage::fake('local');
        $staff = User::factory()->staff()->create();
        $booking = Booking::factory()->create();

        $this->actingAs($staff)
            ->post(route('staff.bookings.gatepass.store', $booking), [
                'gatepass' => UploadedFile::fake()->image('gatepass.jpg'),
            ])
            ->assertRedirect(route('staff.bookings.show', $booking));

        $booking->refresh();
        $this->assertTrue($booking->hasGatepass());
        Storage::disk('local')->assertExists($booking->gatepass_path);
    }

    public function test_staff_cannot_replace_gatepass(): void
    {
        Storage::fake('local');
        $staff = User::factory()->staff()->create();
        $booking = Booking::factory()->withGatepass()->create([
            'gatepass_path' => 'bookings/GK-TEST-0001/gatepass.jpg',
        ]);
        Storage::disk('local')->put($booking->gatepass_path, 'original');

        $this->actingAs($staff)
            ->post(route('staff.bookings.gatepass.store', $booking), [
                'gatepass' => UploadedFile::fake()->image('new.jpg'),
            ])
            ->assertForbidden();
    }

    public function test_staff_can_cancel_before_gatepass(): void
    {
        $staff = User::factory()->staff()->create();
        $booking = Booking::factory()->create(['status' => BookingStatus::Pending]);

        $this->actingAs($staff)
            ->post(route('staff.bookings.cancel', $booking))
            ->assertRedirect(route('staff.bookings.show', $booking));

        $this->assertSame(BookingStatus::Cancelled, $booking->fresh()->status);
    }

    public function test_staff_cannot_cancel_after_gatepass(): void
    {
        $staff = User::factory()->staff()->create();
        $booking = Booking::factory()->withGatepass()->create(['status' => BookingStatus::Pending]);

        $this->actingAs($staff)
            ->post(route('staff.bookings.cancel', $booking))
            ->assertForbidden();
    }

    public function test_admin_can_create_booking_for_customer(): void
    {
        $admin = User::factory()->systemAdmin()->create();
        $customer = User::factory()->customer()->create();
        Pricing::factory()->create(['vehicle_type' => '4-wheeler truck', 'amount' => 5000]);
        Vehicle::factory()->create(['type' => '4-wheeler truck', 'status' => VehicleStatus::Available]);

        $this->actingAs($admin)
            ->post(route('admin.bookings.store'), array_merge($this->bookingPayload(null, []), [
                'customer_id' => $customer->id,
            ]))
            ->assertRedirect();

        $this->assertSame(1, Booking::query()->where('customer_id', $customer->id)->count());
    }

    public function test_admin_can_replace_gatepass(): void
    {
        Storage::fake('local');
        $admin = User::factory()->systemAdmin()->create();
        $booking = Booking::factory()->withGatepass()->create([
            'gatepass_path' => 'bookings/GK-TEST-0001/gatepass.jpg',
        ]);
        Storage::disk('local')->put($booking->gatepass_path, 'original');

        $this->actingAs($admin)
            ->post(route('admin.bookings.gatepass.store', $booking), [
                'gatepass' => UploadedFile::fake()->image('replaced.png'),
            ])
            ->assertRedirect(route('admin.bookings.show', $booking));

        $this->assertStringEndsWith('gatepass.png', $booking->fresh()->gatepass_path);
    }

    public function test_admin_can_archive_booking(): void
    {
        $admin = User::factory()->systemAdmin()->create();
        $booking = Booking::factory()->create();

        $this->actingAs($admin)
            ->delete(route('admin.bookings.destroy', $booking))
            ->assertRedirect(route('admin.bookings.index'));

        $archived = Booking::withArchived()->find($booking->id);
        $this->assertNotNull($archived);
        $this->assertTrue($archived->isArchived());
    }

    public function test_staff_can_download_gatepass_customer_cannot(): void
    {
        Storage::fake('local');
        $booking = Booking::factory()->withGatepass()->create([
            'gatepass_path' => 'bookings/GK-TEST-0001/gatepass.jpg',
        ]);
        Storage::disk('local')->put($booking->gatepass_path, 'image-bytes');

        $staff = User::factory()->staff()->create();
        $customer = $booking->customer;

        $this->actingAs($staff)
            ->get(route('documents.bookings.gatepass', $booking))
            ->assertOk();

        $this->actingAs($customer)
            ->get(route('documents.bookings.gatepass', $booking))
            ->assertForbidden();
    }

    public function test_cancel_releases_assigned_vehicle(): void
    {
        $admin = User::factory()->systemAdmin()->create();
        $vehicle = Vehicle::factory()->create(['status' => VehicleStatus::InUse]);
        $booking = Booking::factory()->withGatepass()->create([
            'status' => BookingStatus::Accepted,
            'vehicle_id' => $vehicle->id,
            'driver_id' => User::factory()->driver()->create()->id,
            'is_locked' => true,
        ]);

        $this->actingAs($admin)
            ->post(route('admin.bookings.cancel', $booking))
            ->assertRedirect();

        $booking->refresh();
        $vehicle->refresh();
        $this->assertSame(BookingStatus::Cancelled, $booking->status);
        $this->assertNull($booking->vehicle_id);
        $this->assertNull($booking->driver_id);
        $this->assertSame(VehicleStatus::Available, $vehicle->status);
    }

    /**
     * @param  array<string, mixed>  $overrides
     * @return array<string, mixed>
     */
    private function bookingPayload(?Booking $booking, array $overrides): array
    {
        return array_merge([
            'vehicle_type' => $booking?->vehicle_type ?? '4-wheeler truck',
            'booking_datetime' => ($booking?->booking_datetime ?? now()->addDay())->format('Y-m-d H:i:s'),
            'pickup_address' => $booking?->pickup_address ?? 'Makati',
            'pickup_lat' => $booking?->pickup_lat ?? 14.5,
            'pickup_lng' => $booking?->pickup_lng ?? 121.0,
            'dropoff_address' => $booking?->dropoff_address ?? 'QC',
            'dropoff_lat' => $booking?->dropoff_lat ?? 14.6,
            'dropoff_lng' => $booking?->dropoff_lng ?? 121.1,
            'cargo_desc' => $booking?->cargo_desc,
        ], $overrides);
    }
}
