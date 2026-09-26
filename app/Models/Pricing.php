<?php

namespace App\Models;

use App\Models\Concerns\Archivable;
use Database\Factories\PricingFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'vehicle_type',
    'amount',
])]
class Pricing extends Model
{
    /** @use HasFactory<PricingFactory> */
    use Archivable, HasFactory;

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'archived_at' => 'datetime',
        ];
    }
}
