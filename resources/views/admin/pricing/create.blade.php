@extends('layouts.admin')

@section('title', 'Add pricing')

@section('content')
    <h1>Add pricing row</h1>
    <p><a href="{{ route('admin.pricing.index') }}">Back to list</a></p>
    <form method="post" action="{{ route('admin.pricing.store') }}">
        @csrf
        <label for="vehicle_type">Vehicle type</label>
        <input id="vehicle_type" name="vehicle_type" value="{{ old('vehicle_type') }}" required>

        <label for="amount">Amount (PHP)</label>
        <input id="amount" type="number" step="0.01" name="amount" value="{{ old('amount') }}" min="0" required>

        <button type="submit">Create</button>
    </form>
@endsection
