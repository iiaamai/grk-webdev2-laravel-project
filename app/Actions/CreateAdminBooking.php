<?php

namespace App\Actions;

use App\Enums\UserRole;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Validation\ValidationException;

class CreateAdminBooking
{
    public function __construct(
        private readonly CreateCustomerBooking $createCustomerBooking,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public function execute(array $data): Booking
    {
        $customer = User::query()
            ->whereKey($data['customer_id'])
            ->where('role', UserRole::Customer)
            ->first();

        if ($customer === null) {
            throw ValidationException::withMessages([
                'customer_id' => 'The selected customer is invalid.',
            ]);
        }

        unset($data['customer_id']);

        return $this->createCustomerBooking->execute($customer, $data);
    }
}
