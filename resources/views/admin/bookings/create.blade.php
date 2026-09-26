@extends('layouts.admin')

@section('title', 'New booking')

@section('content')
    <h1>Create booking</h1>
    <p><a href="{{ route('admin.bookings.index') }}">Back to list</a></p>

    @include('bookings._fields', [
        'action' => route('admin.bookings.store'),
        'method' => 'POST',
        'booking' => null,
        'customers' => $customers,
        'pricings' => $pricings,
        'showCustomer' => true,
        'submitLabel' => 'Create booking',
    ])
@endsection
