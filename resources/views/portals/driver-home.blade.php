@extends('layouts.driver')

@section('title', 'Overview')

@section('content')
    <h1>Driver overview</h1>
    <p>Welcome, <strong>{{ $name }}</strong>.</p>
    <p><a href="{{ route('driver.deliveries.index') }}">View available and active deliveries</a>.</p>
@endsection
