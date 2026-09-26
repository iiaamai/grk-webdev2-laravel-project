@extends('layouts.admin')

@section('title', 'Fleet')

@section('content')
    <h1>Fleet</h1>
    <p><a href="{{ route('admin.fleet.create') }}">Add vehicle</a></p>
    <table>
        <thead>
            <tr>
                <th>Plate</th>
                <th>Label</th>
                <th>Type</th>
                <th>Capacity (kg)</th>
                <th>Status</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($vehicles as $vehicle)
                <tr>
                    <td>{{ $vehicle->plate_number }}</td>
                    <td>{{ $vehicle->label }}</td>
                    <td>{{ $vehicle->type }}</td>
                    <td>{{ $vehicle->capacity_kg }}</td>
                    <td>{{ $vehicle->status->value }}</td>
                    <td>
                        <a href="{{ route('admin.fleet.edit', $vehicle) }}">Edit</a>
                        <form method="post" action="{{ route('admin.fleet.destroy', $vehicle) }}" style="display:inline;" onsubmit="return confirm('Archive this vehicle?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Archive</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6">No vehicles yet.</td></tr>
            @endforelse
        </tbody>
    </table>
@endsection
