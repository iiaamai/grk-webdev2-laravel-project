<form method="post" action="{{ $action }}">
    @csrf
    @if ($user)
        @method('PUT')
    @endif
    <label for="name">Name</label>
    <input id="name" name="name" value="{{ old('name', $user?->name) }}" required>

    <label for="email">Email</label>
    <input id="email" type="email" name="email" value="{{ old('email', $user?->email) }}" required>

    <label for="mobile">Mobile</label>
    <input id="mobile" name="mobile" value="{{ old('mobile', $user?->mobile) }}">

    <label for="role">Role</label>
    <select id="role" name="role" required>
        @foreach (['customer', 'driver', 'staff', 'system_admin'] as $role)
            <option value="{{ $role }}" @selected(old('role', $user?->role?->value) === $role)>{{ $role }}</option>
        @endforeach
    </select>

    <label for="vehicle_type">Vehicle type (driver)</label>
    <input id="vehicle_type" name="vehicle_type" value="{{ old('vehicle_type', $user?->vehicle_type) }}">

    <label for="plate">Plate (driver)</label>
    <input id="plate" name="plate" value="{{ old('plate', $user?->plate) }}">

    <label for="capacity_kg">Capacity kg (driver)</label>
    <input id="capacity_kg" type="number" name="capacity_kg" value="{{ old('capacity_kg', $user?->capacity_kg) }}" min="1">

    <label for="password">Password{{ $user ? ' (leave blank to keep)' : '' }}</label>
    <input id="password" type="password" name="password" {{ $user ? '' : 'required' }}>

    <label for="password_confirmation">Confirm password</label>
    <input id="password_confirmation" type="password" name="password_confirmation" {{ $user ? '' : 'required' }}>

    <button type="submit">{{ $user ? 'Update' : 'Create' }}</button>
</form>
