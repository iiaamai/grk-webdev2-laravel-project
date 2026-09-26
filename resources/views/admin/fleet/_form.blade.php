<form method="post" action="{{ $action }}">
    @csrf
    @if ($vehicle)
        @method('PUT')
    @endif
    <label for="plate_number">Plate number</label>
    <input id="plate_number" name="plate_number" value="{{ old('plate_number', $vehicle?->plate_number) }}" required>

    <label for="label">Label</label>
    <input id="label" name="label" value="{{ old('label', $vehicle?->label) }}" required>

    <label for="type">Type</label>
    <input id="type" name="type" value="{{ old('type', $vehicle?->type) }}" required>

    <label for="capacity_kg">Capacity (kg)</label>
    <input id="capacity_kg" type="number" name="capacity_kg" value="{{ old('capacity_kg', $vehicle?->capacity_kg) }}" min="1" required>

    <label for="status">Status</label>
    <select id="status" name="status" required>
        @foreach (['available', 'in_use', 'maintenance'] as $status)
            <option value="{{ $status }}" @selected(old('status', $vehicle?->status?->value ?? 'available') === $status)>{{ $status }}</option>
        @endforeach
    </select>

    <button type="submit">{{ $vehicle ? 'Update' : 'Create' }}</button>
</form>
