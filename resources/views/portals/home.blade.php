<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ ucfirst($role) }} portal — GK Trucking Services</title>
    <style>
        body { font-family: system-ui, sans-serif; max-width: 40rem; margin: 3rem auto; padding: 0 1rem; }
        button { margin-top: 1rem; padding: 0.5rem 1rem; }
    </style>
</head>
<body>
    <h1>GK Trucking Services</h1>
    <p>Signed in as <strong>{{ $name }}</strong> ({{ $role }}).</p>
    <p>Portal shell placeholder — full layout arrives in F1.</p>

    @if (session('status'))
        <p>{{ session('status') }}</p>
    @endif

    <form method="post" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Log out</button>
    </form>
</body>
</html>
