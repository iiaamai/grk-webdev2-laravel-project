@extends('layouts.admin')

@section('title', 'Edit '.$booking->booking_number)

@section('content')
    <h1>Edit {{ $booking->booking_number }}</h1>
    <p><a href="{{ route('admin.bookings.show', $booking) }}">Back to details</a></p>

    @include('bookings._fields', [
        'action' => route('admin.bookings.update', $booking),
        'method' => 'PUT',
        'booking' => $booking,
        'customers' => $customers,
        'pricings' => $pricings,
        'showCustomer' => true,
        'submitLabel' => 'Save changes',
    ])
@endsection
