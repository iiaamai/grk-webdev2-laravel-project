<?php

namespace Database\Seeders;

use App\Enums\BookingStatus;
use App\Enums\InvoiceStatus;
use App\Enums\VehicleStatus;
use App\Models\Booking;
use App\Models\Eir;
use App\Models\Invoice;
use App\Models\Pod;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Database\Seeder;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customer = User::query()->where('email', 'customer@gk.test')->firstOrFail();
        $driver = User::query()->where('email', 'driver@gk.test')->firstOrFail();
        $driverTwo = User::query()->where('email', 'driver2@gk.test')->firstOrFail();

        $truck = Vehicle::query()->where('plate_number', 'ABC-1234')->firstOrFail();
        $sixWheeler = Vehicle::query()->where('plate_number', 'DEF-5678')->firstOrFail();
        $van = Vehicle::query()->where('plate_number', 'GHI-9012')->firstOrFail();

        $year = now('Asia/Manila')->year;

        $samples = [
            [
                'booking_number' => "GK-{$year}-0001",
                'vehicle_type' => 'L300 van',
                'vehicle_id' => null,
                'driver_id' => null,
                'status' => BookingStatus::Pending,
                'is_locked' => false,
                'accepted_at' => null,
                'payout' => 4500.00,
                'gatepass_path' => null,
                'cargo_desc' => 'Office supplies (pending, no gatepass)',
            ],
            [
                'booking_number' => "GK-{$year}-0002",
                'vehicle_type' => '4-wheeler truck',
                'vehicle_id' => null,
                'driver_id' => null,
                'status' => BookingStatus::Pending,
                'is_locked' => false,
                'accepted_at' => null,
                'payout' => 9200.00,
                'gatepass_path' => 'bookings/demo/gk-0002-gatepass.jpg',
                'cargo_desc' => 'Retail pallets (pending with gatepass)',
            ],
            [
                'booking_number' => "GK-{$year}-0003",
                'vehicle_type' => '4-wheeler truck',
                'vehicle_id' => $truck->id,
                'driver_id' => $driver->id,
                'status' => BookingStatus::Accepted,
                'is_locked' => true,
                'accepted_at' => now('Asia/Manila')->subHours(2),
                'payout' => 9200.00,
                'gatepass_path' => 'bookings/demo/gk-0003-gatepass.jpg',
                'cargo_desc' => 'Accepted demo delivery',
                'lock_vehicle' => $truck,
            ],
            [
                'booking_number' => "GK-{$year}-0004",
                'vehicle_type' => '6-wheeler (Isuzu / Fuso)',
                'vehicle_id' => $sixWheeler->id,
                'driver_id' => $driverTwo->id,
                'status' => BookingStatus::InTransit,
                'is_locked' => true,
                'accepted_at' => now('Asia/Manila')->subDay(),
                'payout' => 14500.00,
                'gatepass_path' => 'bookings/demo/gk-0004-gatepass.jpg',
                'cargo_desc' => 'In-transit demo load',
                'lock_vehicle' => $sixWheeler,
            ],
            [
                'booking_number' => "GK-{$year}-0005",
                'vehicle_type' => 'L300 van',
                'vehicle_id' => $van->id,
                'driver_id' => $driver->id,
                'status' => BookingStatus::Completed,
                'is_locked' => true,
                'accepted_at' => now('Asia/Manila')->subDays(3),
                'payout' => 4500.00,
                'gatepass_path' => 'bookings/demo/gk-0005-gatepass.jpg',
                'cargo_desc' => 'Completed demo with EIR/POD',
                'with_eir_pod' => true,
                'with_invoice' => InvoiceStatus::Paid,
            ],
            [
                'booking_number' => "GK-{$year}-0006",
                'vehicle_type' => 'Reefer / specialized',
                'vehicle_id' => null,
                'driver_id' => null,
                'status' => BookingStatus::Cancelled,
                'is_locked' => false,
                'accepted_at' => null,
                'payout' => 18500.00,
                'gatepass_path' => null,
                'cargo_desc' => 'Cancelled demo booking',
            ],
        ];

        foreach ($samples as $sample) {
            $lockVehicle = $sample['lock_vehicle'] ?? null;
            $withEirPod = $sample['with_eir_pod'] ?? false;
            $withInvoice = $sample['with_invoice'] ?? null;
            unset($sample['lock_vehicle'], $sample['with_eir_pod'], $sample['with_invoice']);

            $booking = Booking::query()->updateOrCreate(
                ['booking_number' => $sample['booking_number']],
                array_merge($sample, [
                    'customer_id' => $customer->id,
                    'booking_datetime' => now('Asia/Manila')->addDays(1),
                    'posting_date' => now('Asia/Manila')->toDateString(),
                    'pickup_address' => 'Makati City, Metro Manila',
                    'pickup_lat' => 14.5547,
                    'pickup_lng' => 121.0244,
                    'dropoff_address' => 'Quezon City, Metro Manila',
                    'dropoff_lat' => 14.6760,
                    'dropoff_lng' => 121.0437,
                ]),
            );

            if ($lockVehicle instanceof Vehicle) {
                $lockVehicle->update(['status' => VehicleStatus::InUse]);
            }

            if ($withEirPod) {
                Eir::query()->updateOrCreate(
                    ['booking_id' => $booking->id],
                    [
                        'eir_path' => 'bookings/demo/gk-0005-eir.jpg',
                        'uploaded_at' => now('Asia/Manila')->subDays(2),
                    ],
                );

                Pod::query()->updateOrCreate(
                    ['booking_id' => $booking->id],
                    [
                        'photo_paths' => [
                            'bookings/demo/gk-0005-pod-1.jpg',
                            'bookings/demo/gk-0005-pod-2.jpg',
                        ],
                        'signature_path' => 'bookings/demo/gk-0005-signature.png',
                        'captured_at' => now('Asia/Manila')->subDays(2),
                    ],
                );
            }

            if ($withInvoice instanceof InvoiceStatus) {
                Invoice::query()->updateOrCreate(
                    ['booking_id' => $booking->id],
                    [
                        'amount' => $booking->payout,
                        'status' => $withInvoice,
                        'issued_at' => now('Asia/Manila')->subDays(2),
                        'paid_at' => $withInvoice === InvoiceStatus::Paid
                            ? now('Asia/Manila')->subDay()
                            : null,
                    ],
                );
            }
        }
    }
}
