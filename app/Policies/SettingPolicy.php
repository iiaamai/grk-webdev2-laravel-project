<?php

namespace App\Policies;

use App\Models\Setting;
use App\Models\User;

class SettingPolicy
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

    public function update(User $user, ?Setting $setting = null): bool
    {
        return true;
    }
}
