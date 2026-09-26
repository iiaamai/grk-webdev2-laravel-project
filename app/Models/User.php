<?php

namespace App\Models;

use App\Enums\UserRole;
use App\Models\Concerns\Archivable;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable([
    'name',
    'email',
    'password',
    'mobile',
    'role',
    'vehicle_type',
    'plate',
    'capacity_kg',
    'email_verified_at',
])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use Archivable, HasFactory, Notifiable;

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => UserRole::class,
            'capacity_kg' => 'integer',
            'archived_at' => 'datetime',
        ];
    }

    /**
     * @return HasMany<Booking, $this>
     */
    public function customerBookings(): HasMany
    {
        return $this->hasMany(Booking::class, 'customer_id');
    }

    /**
     * @return HasMany<Booking, $this>
     */
    public function driverBookings(): HasMany
    {
        return $this->hasMany(Booking::class, 'driver_id');
    }

    /**
     * @return HasMany<ActivityLog, $this>
     */
    public function activityLogs(): HasMany
    {
        return $this->hasMany(ActivityLog::class);
    }

    public function isCustomer(): bool
    {
        return $this->role === UserRole::Customer;
    }

    public function isDriver(): bool
    {
        return $this->role === UserRole::Driver;
    }

    public function isStaff(): bool
    {
        return $this->role === UserRole::Staff;
    }

    public function isSystemAdmin(): bool
    {
        return $this->role === UserRole::SystemAdmin;
    }
}
