@extends('layouts.admin')

@section('title', 'Overview')

@section('content')
    <h1>Admin overview</h1>
    <p>Signed in as <strong>{{ $name }}</strong>.</p>
    <p>Use the navigation to manage settings, pricing, fleet, and users. Full overview stats arrive in later phases.</p>
@endsection
