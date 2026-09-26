<?php

namespace App\Http\Requests\Staff;

use App\Http\Requests\Concerns\ValidatesBookingFields;
use App\Models\Booking;
use Illuminate\Foundation\Http\FormRequest;

class UpdateBookingRequest extends FormRequest
{
    use ValidatesBookingFields;

    public function authorize(): bool
    {
        $booking = $this->route('booking');

        return $booking instanceof Booking
            && $this->user()?->can('update', $booking);
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return $this->bookingFieldRules(requireFutureDatetime: false);
    }
}
