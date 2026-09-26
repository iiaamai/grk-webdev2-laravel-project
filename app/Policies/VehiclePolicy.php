<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Vehicle;

class VehiclePolicy
{
    public function before(User $user, string $ability): ?bool
    {
        if (! $user->isSystemAdmin()) {
            return false;
        }

        return null;
    }

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Vehicle $vehicle): bool
    {
        return true;
    }

    public function delete(User $user, Vehicle $vehicle): bool
    {
        return true;
    }
}
