<?php

namespace App\Policies;

use App\Enums\BookingStatus;
use App\Models\Booking;
use App\Models\User;

class BookingPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isCustomer()
            || $user->isStaff()
            || $user->isSystemAdmin();
    }

    public function view(User $user, Booking $booking): bool
    {
        if ($user->isSystemAdmin() || $user->isStaff()) {
            return true;
        }

        return $user->isCustomer() && $booking->customer_id === $user->id;
    }

    public function create(User $user): bool
    {
        return $user->isCustomer() || $user->isSystemAdmin();
    }

    public function update(User $user, Booking $booking): bool
    {
        if ($user->isSystemAdmin()) {
            return true;
        }

        return $user->isStaff() && ! $booking->hasGatepass();
    }

    public function uploadGatepass(User $user, Booking $booking): bool
    {
        if ($user->isSystemAdmin()) {
            return true;
        }

        return $user->isStaff() && ! $booking->hasGatepass();
    }

    public function viewGatepass(User $user, Booking $booking): bool
    {
        if ($user->isCustomer()) {
            return false;
        }

        if ($user->isSystemAdmin() || $user->isStaff()) {
            return true;
        }

        if ($user->isDriver()) {
            return $booking->driver_id === $user->id
                || (
                    $booking->status === BookingStatus::Pending
                    && $booking->hasGatepass()
                    && ! $booking->is_locked
                    && $booking->driver_id === null
                );
        }

        return false;
    }

    public function cancel(User $user, Booking $booking): bool
    {
        if ($user->isSystemAdmin()) {
            return $booking->status !== BookingStatus::Completed;
        }

        return $user->isStaff()
            && ! $booking->hasGatepass()
            && $booking->status === BookingStatus::Pending;
    }

    public function updateStatus(User $user, Booking $booking): bool
    {
        return $user->isSystemAdmin();
    }

    public function delete(User $user, Booking $booking): bool
    {
        return $user->isSystemAdmin();
    }
}
