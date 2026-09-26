@extends('layouts.admin')

@section('title', 'Settings')

@section('content')
    <h1>Settings</h1>
    <form method="post" action="{{ route('admin.settings.update') }}">
        @csrf
        @method('PUT')
        <label for="company_name">Company name</label>
        <input id="company_name" name="company_name" value="{{ old('company_name', $settings['company_name']) }}" required>

        <label for="support_email">Support email</label>
        <input id="support_email" type="email" name="support_email" value="{{ old('support_email', $settings['support_email']) }}" required>

        <label for="booking_seq">Booking sequence (next number)</label>
        <input id="booking_seq" type="number" name="booking_seq" value="{{ old('booking_seq', $settings['booking_seq']) }}" min="1" required>

        <label for="map_center_lat">Map center latitude</label>
        <input id="map_center_lat" type="number" step="any" name="map_center_lat" value="{{ old('map_center_lat', $settings['map_center_lat']) }}" required>

        <label for="map_center_lng">Map center longitude</label>
        <input id="map_center_lng" type="number" step="any" name="map_center_lng" value="{{ old('map_center_lng', $settings['map_center_lng']) }}" required>

        <label for="map_zoom">Map zoom (optional)</label>
        <input id="map_zoom" type="number" name="map_zoom" value="{{ old('map_zoom', $settings['map_zoom']) }}" min="1" max="22">

        <button type="submit">Save settings</button>
    </form>
@endsection
