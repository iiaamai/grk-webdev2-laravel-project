<?php

namespace App\Actions;

use App\Enums\BookingStatus;
use App\Models\Booking;
use App\Services\BookingVehicleRelease;
use Illuminate\Support\Facades\DB;

class UpdateBookingStatus
{
    public function __construct(
        private readonly BookingVehicleRelease $bookingVehicleRelease,
    ) {}

    public function execute(Booking $booking, BookingStatus $status): Booking
    {
        return DB::transaction(function () use ($booking, $status): Booking {
            if ($status === BookingStatus::Cancelled) {
                $this->bookingVehicleRelease->releaseForBooking($booking);
            }

            $booking->update(['status' => $status]);

            return $booking->fresh();
        });
    }
}
