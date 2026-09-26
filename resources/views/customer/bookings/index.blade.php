@extends('layouts.customer')

@section('title', 'My Bookings')

@section('content')
    <h1>My Bookings</h1>
    <p><a href="{{ route('customer.bookings.create') }}">New booking</a></p>
    <table>
        <thead>
            <tr>
                <th>Booking #</th>
                <th>Status</th>
                <th>Vehicle type</th>
                <th>Payout (PHP)</th>
                <th>Pickup</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($bookings as $booking)
                <tr>
                    <td>{{ $booking->booking_number }}</td>
                    <td>{{ $booking->status->value }}</td>
                    <td>{{ $booking->vehicle_type }}</td>
                    <td>{{ number_format((float) $booking->payout, 2) }}</td>
                    <td>{{ $booking->pickup_address }}</td>
                    <td><a href="{{ route('customer.bookings.show', $booking) }}">Details</a></td>
                </tr>
            @empty
                <tr><td colspan="6">No bookings yet.</td></tr>
            @endforelse
        </tbody>
    </table>
@endsection
