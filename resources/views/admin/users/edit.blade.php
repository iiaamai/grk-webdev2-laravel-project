@extends('layouts.admin')

@section('title', 'Edit user')

@section('content')
    <h1>Edit user</h1>
    <p><a href="{{ route('admin.users.index') }}">Back to users</a></p>
    @include('admin.users._form', ['user' => $user, 'action' => route('admin.users.update', $user)])
@endsection
