<?php

namespace App\Http\Requests\Concerns;

use Illuminate\Validation\Rule;

trait ValidatesBookingFields
{
    /**
     * @return array<string, mixed>
     */
    protected function bookingFieldRules(bool $requireFutureDatetime = false): array
    {
        $datetimeRules = ['required', 'date'];
        if ($requireFutureDatetime) {
            $datetimeRules[] = 'after:now';
        }

        return [
            'vehicle_type' => ['required', 'string', 'max:255', Rule::exists('pricings', 'vehicle_type')],
            'booking_datetime' => $datetimeRules,
            'pickup_address' => ['required', 'string', 'max:500'],
            'pickup_lat' => ['required', 'numeric', 'between:-90,90'],
            'pickup_lng' => ['required', 'numeric', 'between:-180,180'],
            'dropoff_address' => ['required', 'string', 'max:500'],
            'dropoff_lat' => ['required', 'numeric', 'between:-90,90'],
            'dropoff_lng' => ['required', 'numeric', 'between:-180,180'],
            'cargo_desc' => ['nullable', 'string', 'max:2000'],
            'additional_requirements' => ['nullable', 'string', 'max:2000'],
        ];
    }
}
