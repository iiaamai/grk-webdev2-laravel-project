@extends('layouts.admin')

@section('title', 'Create user')

@section('content')
    <h1>Create user</h1>
    <p><a href="{{ route('admin.users.index') }}">Back to users</a></p>
    @include('admin.users._form', ['user' => null, 'action' => route('admin.users.store')])
@endsection
