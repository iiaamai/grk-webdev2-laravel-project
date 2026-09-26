@extends('layouts.staff')

@section('title', 'Bookings')

@section('content')
    <h1>Bookings</h1>
    <table>
        <thead>
            <tr>
                <th>Number</th>
                <th>Customer</th>
                <th>Status</th>
                <th>Vehicle type</th>
                <th>Gatepass</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($bookings as $booking)
                <tr>
                    <td>{{ $booking->booking_number }}</td>
                    <td>{{ $booking->customer->name }}</td>
                    <td>{{ $booking->status->value }}</td>
                    <td>{{ $booking->vehicle_type }}</td>
                    <td>{{ $booking->hasGatepass() ? 'Yes' : 'No' }}</td>
                    <td><a href="{{ route('staff.bookings.show', $booking) }}">Open</a></td>
                </tr>
            @empty
                <tr><td colspan="6">No bookings yet.</td></tr>
            @endforelse
        </tbody>
    </table>
@endsection
