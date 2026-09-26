@extends('layouts.customer')

@section('title', 'Overview')

@section('content')
    <h1>GK Trucking Services</h1>
    <p>Welcome, <strong>{{ $name }}</strong>.</p>
    <p><a href="{{ route('customer.bookings.index') }}">View my bookings</a> or <a href="{{ route('customer.bookings.create') }}">create a new booking</a>.</p>
@endsection
