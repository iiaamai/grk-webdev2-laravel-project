<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class BookingDocumentController extends Controller
{
    public function gatepass(Booking $booking): StreamedResponse
    {
        $this->authorize('viewGatepass', $booking);

        if (! $booking->hasGatepass()) {
            abort(404);
        }

        return Storage::disk('local')->download(
            $booking->gatepass_path,
            $booking->booking_number.'-gatepass',
        );
    }
}
