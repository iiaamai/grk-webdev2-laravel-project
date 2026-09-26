@extends('layouts.admin')

@section('title', 'Edit pricing')

@section('content')
    <h1>Edit pricing</h1>
    <p><a href="{{ route('admin.pricing.index') }}">Back to list</a></p>
    <form method="post" action="{{ route('admin.pricing.update', $pricing) }}">
        @csrf
        @method('PUT')
        <label for="vehicle_type">Vehicle type</label>
        <input id="vehicle_type" name="vehicle_type" value="{{ old('vehicle_type', $pricing->vehicle_type) }}" required>

        <label for="amount">Amount (PHP)</label>
        <input id="amount" type="number" step="0.01" name="amount" value="{{ old('amount', $pricing->amount) }}" min="0" required>

        <button type="submit">Update</button>
    </form>
@endsection
