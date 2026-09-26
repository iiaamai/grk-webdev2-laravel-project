@extends('layouts.admin')

@section('title', 'Edit vehicle')

@section('content')
    <h1>Edit vehicle</h1>
    <p><a href="{{ route('admin.fleet.index') }}">Back to fleet</a></p>
    @include('admin.fleet._form', ['vehicle' => $vehicle, 'action' => route('admin.fleet.update', $vehicle)])
@endsection
