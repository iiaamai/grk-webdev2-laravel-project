<?php

namespace App\Models;

use App\Enums\VehicleStatus;
use App\Models\Concerns\Archivable;
use Database\Factories\VehicleFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'plate_number',
    'label',
    'type',
    'capacity_kg',
    'status',
])]
class Vehicle extends Model
{
    /** @use HasFactory<VehicleFactory> */
    use Archivable, HasFactory;

    /**
     * @var array<string, mixed>
     */
    protected $attributes = [
        'status' => 'available',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'capacity_kg' => 'integer',
            'status' => VehicleStatus::class,
            'archived_at' => 'datetime',
        ];
    }

    /**
     * @return HasMany<Booking, $this>
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }
}
