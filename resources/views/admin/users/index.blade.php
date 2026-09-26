@extends('layouts.admin')

@section('title', 'Users')

@section('content')
    <h1>User management</h1>
    <p><a href="{{ route('admin.users.create') }}">Create user</a></p>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->role->value }}</td>
                    <td>
                        <a href="{{ route('admin.users.edit', $user) }}">Edit</a>
                        @can('delete', $user)
                            <form method="post" action="{{ route('admin.users.destroy', $user) }}" style="display:inline;" onsubmit="return confirm('Archive this user?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit">Archive</button>
                            </form>
                        @endcan
                    </td>
                </tr>
            @empty
                <tr><td colspan="4">No users.</td></tr>
            @endforelse
        </tbody>
    </table>
@endsection
