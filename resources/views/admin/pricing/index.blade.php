@extends('layouts.admin')

@section('title', 'Pricing')

@section('content')
    <h1>Pricing list</h1>
    <p><a href="{{ route('admin.pricing.create') }}">Add pricing row</a></p>
    <table>
        <thead>
            <tr>
                <th>Vehicle type</th>
                <th>Amount (PHP)</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($pricings as $pricing)
                <tr>
                    <td>{{ $pricing->vehicle_type }}</td>
                    <td>{{ number_format((float) $pricing->amount, 2) }}</td>
                    <td>
                        <a href="{{ route('admin.pricing.edit', $pricing) }}">Edit</a>
                        <form method="post" action="{{ route('admin.pricing.destroy', $pricing) }}" style="display:inline;" onsubmit="return confirm('Archive this pricing row?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Archive</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="3">No pricing rows yet.</td></tr>
            @endforelse
        </tbody>
    </table>
@endsection
