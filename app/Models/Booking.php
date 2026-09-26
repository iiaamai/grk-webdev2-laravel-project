<?php

namespace App\Models;

use App\Enums\BookingStatus;
use App\Models\Concerns\Archivable;
use Database\Factories\BookingFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

#[Fillable([
    'booking_number',
    'customer_id',
    'driver_id',
    'vehicle_id',
    'vehicle_type',
    'booking_datetime',
    'posting_date',
    'pickup_address',
    'pickup_lat',
    'pickup_lng',
    'dropoff_address',
    'dropoff_lat',
    'dropoff_lng',
    'cargo_desc',
    'additional_requirements',
    'status',
    'is_locked',
    'accepted_at',
    'payout',
    'gatepass_path',
])]
class Booking extends Model
{
    /** @use HasFactory<BookingFactory> */
    use Archivable, HasFactory;

    /**
     * @var array<string, mixed>
     */
    protected $attributes = [
        'status' => 'pending',
        'is_locked' => false,
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'booking_datetime' => 'datetime',
            'posting_date' => 'date',
            'pickup_lat' => 'float',
            'pickup_lng' => 'float',
            'dropoff_lat' => 'float',
            'dropoff_lng' => 'float',
            'status' => BookingStatus::class,
            'is_locked' => 'boolean',
            'accepted_at' => 'datetime',
            'payout' => 'decimal:2',
            'archived_at' => 'datetime',
        ];
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function driver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'driver_id');
    }

    /**
     * @return BelongsTo<Vehicle, $this>
     */
    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    /**
     * @return HasOne<Eir, $this>
     */
    public function eir(): HasOne
    {
        return $this->hasOne(Eir::class);
    }

    /**
     * @return HasOne<Pod, $this>
     */
    public function pod(): HasOne
    {
        return $this->hasOne(Pod::class);
    }

    /**
     * @return HasOne<Invoice, $this>
     */
    public function invoice(): HasOne
    {
        return $this->hasOne(Invoice::class);
    }

    /**
     * @return HasOne<Rating, $this>
     */
    public function rating(): HasOne
    {
        return $this->hasOne(Rating::class);
    }

    public function hasGatepass(): bool
    {
        return filled($this->gatepass_path);
    }

    /**
     * @param  Builder<Booking>  $query
     * @return Builder<Booking>
     */
    public function scopeAvailableForDriver(Builder $query, User $driver): Builder
    {
        return $query
            ->where('status', BookingStatus::Pending)
            ->whereNotNull('gatepass_path')
            ->where('is_locked', false)
            ->whereNull('driver_id')
            ->where('vehicle_type', $driver->vehicle_type);
    }

    /**
     * @param  Builder<Booking>  $query
     * @return Builder<Booking>
     */
    public function scopeActiveForDriver(Builder $query, User $driver): Builder
    {
        return $query
            ->where('driver_id', $driver->id)
            ->whereIn('status', [BookingStatus::Accepted, BookingStatus::InTransit]);
    }
}
