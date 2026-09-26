@extends('layouts.staff')

@section('title', 'Overview')

@section('content')
    <h1>Staff overview</h1>
    <p>Welcome, <strong>{{ $name }}</strong>.</p>
    <p><a href="{{ route('staff.bookings.index') }}">Manage bookings</a> — update details, upload gatepass, and cancel before gatepass is issued.</p>
@endsection
