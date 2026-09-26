<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\DB;

class BookingNumberGenerator
{
    public function next(): string
    {
        return DB::transaction(function (): string {
            $year = now('Asia/Manila')->year;
            $sequence = (int) Setting::getValue('booking_seq', '1');
            $number = sprintf('GK-%d-%04d', $year, $sequence);

            Setting::setValue('booking_seq', (string) ($sequence + 1));

            return $number;
        });
    }
}
