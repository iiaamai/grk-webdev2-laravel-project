<form method="post" action="{{ $action }}">
    @csrf
    @if (($method ?? 'POST') !== 'POST')
        @method($method)
    @endif

    @if ($showCustomer ?? false)
        <label for="customer_id">Customer</label>
        <select id="customer_id" name="customer_id" required>
            @foreach ($customers as $customer)
                <option value="{{ $customer->id }}" @selected(old('customer_id', $booking?->customer_id) == $customer->id)>
                    {{ $customer->name }} — {{ $customer->email }}
                </option>
            @endforeach
        </select>
    @endif

    <label for="vehicle_type">Vehicle type</label>
    <select id="vehicle_type" name="vehicle_type" required>
        @foreach ($pricings as $pricing)
            <option value="{{ $pricing->vehicle_type }}" @selected(old('vehicle_type', $booking?->vehicle_type) === $pricing->vehicle_type)>
                {{ $pricing->vehicle_type }} — ₱{{ number_format((float) $pricing->amount, 2) }}
            </option>
        @endforeach
    </select>

    <label for="booking_datetime">Preferred pickup datetime</label>
    <input id="booking_datetime" type="datetime-local" name="booking_datetime"
        value="{{ old('booking_datetime', isset($booking) ? $booking->booking_datetime->timezone('Asia/Manila')->format('Y-m-d\TH:i') : '') }}" required>

    <label for="pickup_address">Pickup address</label>
    <input id="pickup_address" name="pickup_address" value="{{ old('pickup_address', $booking?->pickup_address) }}" required>

    <label for="pickup_lat">Pickup latitude</label>
    <input id="pickup_lat" type="number" step="any" name="pickup_lat" value="{{ old('pickup_lat', $booking?->pickup_lat) }}" required>

    <label for="pickup_lng">Pickup longitude</label>
    <input id="pickup_lng" type="number" step="any" name="pickup_lng" value="{{ old('pickup_lng', $booking?->pickup_lng) }}" required>

    <label for="dropoff_address">Dropoff address</label>
    <input id="dropoff_address" name="dropoff_address" value="{{ old('dropoff_address', $booking?->dropoff_address) }}" required>

    <label for="dropoff_lat">Dropoff latitude</label>
    <input id="dropoff_lat" type="number" step="any" name="dropoff_lat" value="{{ old('dropoff_lat', $booking?->dropoff_lat) }}" required>

    <label for="dropoff_lng">Dropoff longitude</label>
    <input id="dropoff_lng" type="number" step="any" name="dropoff_lng" value="{{ old('dropoff_lng', $booking?->dropoff_lng) }}" required>

    <label for="cargo_desc">Cargo description</label>
    <textarea id="cargo_desc" name="cargo_desc" rows="3">{{ old('cargo_desc', $booking?->cargo_desc) }}</textarea>

    <label for="additional_requirements">Additional requirements</label>
    <textarea id="additional_requirements" name="additional_requirements" rows="2">{{ old('additional_requirements', $booking?->additional_requirements) }}</textarea>

    <button type="submit">{{ $submitLabel ?? 'Save booking' }}</button>
</form>
