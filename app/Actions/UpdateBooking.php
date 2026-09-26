<?php

namespace App\Actions;

use App\Enums\VehicleStatus;
use App\Models\Booking;
use App\Models\Pricing;
use App\Models\Vehicle;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class UpdateBooking
{
    /**
     * @param  array<string, mixed>  $data
     */
    public function execute(Booking $booking, array $data): Booking
    {
        return DB::transaction(function () use ($booking, $data): Booking {
            $vehicleType = $data['vehicle_type'];

            if ($vehicleType !== $booking->vehicle_type) {
                $pricing = Pricing::query()
                    ->where('vehicle_type', $vehicleType)
                    ->first();

                if ($pricing === null) {
                    throw ValidationException::withMessages([
                        'vehicle_type' => 'The selected vehicle type is not in the pricing list.',
                    ]);
                }

                $hasAvailableVehicle = Vehicle::query()
                    ->where('type', $vehicleType)
                    ->where('status', VehicleStatus::Available)
                    ->exists();

                if (! $hasAvailableVehicle) {
                    throw ValidationException::withMessages([
                        'vehicle_type' => 'No available fleet unit for this vehicle type right now.',
                    ]);
                }

                $data['payout'] = $pricing->amount;
            }

            $booking->update([
                'vehicle_type' => $vehicleType,
                'booking_datetime' => $data['booking_datetime'],
                'pickup_address' => $data['pickup_address'],
                'pickup_lat' => $data['pickup_lat'],
                'pickup_lng' => $data['pickup_lng'],
                'dropoff_address' => $data['dropoff_address'],
                'dropoff_lat' => $data['dropoff_lat'],
                'dropoff_lng' => $data['dropoff_lng'],
                'cargo_desc' => $data['cargo_desc'] ?? null,
                'additional_requirements' => $data['additional_requirements'] ?? null,
                'payout' => $data['payout'] ?? $booking->payout,
            ]);

            if (isset($data['customer_id'])) {
                $booking->update(['customer_id' => $data['customer_id']]);
            }

            return $booking->fresh();
        });
    }
}
