<?php

namespace App\Actions;

use App\Enums\BookingStatus;
use App\Models\Booking;
use App\Services\BookingVehicleRelease;
use Illuminate\Support\Facades\DB;

class CancelBooking
{
    public function __construct(
        private readonly BookingVehicleRelease $bookingVehicleRelease,
    ) {}

    public function execute(Booking $booking): Booking
    {
        return DB::transaction(function () use ($booking): Booking {
            $this->bookingVehicleRelease->releaseForBooking($booking);

            $booking->update(['status' => BookingStatus::Cancelled]);

            return $booking->fresh();
        });
    }
}
