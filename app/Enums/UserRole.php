<?php

namespace App\Enums;

enum UserRole: string
{
    case Customer = 'customer';
    case Driver = 'driver';
    case Staff = 'staff';
    case SystemAdmin = 'system_admin';
}
