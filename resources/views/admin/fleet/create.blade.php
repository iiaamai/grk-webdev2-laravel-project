@extends('layouts.admin')

@section('title', 'Add vehicle')

@section('content')
    <h1>Add vehicle</h1>
    <p><a href="{{ route('admin.fleet.index') }}">Back to fleet</a></p>
    @include('admin.fleet._form', ['vehicle' => null, 'action' => route('admin.fleet.store')])
@endsection
