<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Verify email — GK Trucking Services</title>
    <style>
        body { font-family: system-ui, sans-serif; max-width: 28rem; margin: 3rem auto; padding: 0 1rem; }
        button { margin-top: 1rem; padding: 0.5rem 1rem; }
    </style>
</head>
<body>
    <h1>Verify your email</h1>
    <p>Thanks for signing up. Please verify your email address.</p>

    @if (session('status'))
        <p>{{ session('status') }}</p>
    @endif

    <form method="post" action="{{ route('verification.send') }}">
        @csrf
        <button type="submit">Resend verification email</button>
    </form>

    <form method="post" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Log out</button>
    </form>
</body>
</html>
