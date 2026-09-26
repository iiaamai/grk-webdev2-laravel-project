<?php

namespace App\Policies;

use App\Models\Booking;
use App\Models\User;

class BookingPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isCustomer() || $user->isSystemAdmin();
    }

    public function view(User $user, Booking $booking): bool
    {
        if ($user->isSystemAdmin()) {
            return true;
        }

        return $user->isCustomer() && $booking->customer_id === $user->id;
    }

    public function create(User $user): bool
    {
        return $user->isCustomer() || $user->isSystemAdmin();
    }
}
