<?php

namespace App\Support;

use App\Enums\UserRole;
use App\Models\User;

class RoleHome
{
    public static function routeName(UserRole|User $roleOrUser): string
    {
        $role = $roleOrUser instanceof User ? $roleOrUser->role : $roleOrUser;

        return match ($role) {
            UserRole::Customer => 'customer.home',
            UserRole::Driver => 'driver.home',
            UserRole::Staff => 'staff.home',
            UserRole::SystemAdmin => 'admin.home',
        };
    }

    public static function path(UserRole|User $roleOrUser): string
    {
        return route(self::routeName($roleOrUser));
    }
}
