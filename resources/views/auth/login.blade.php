<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login — GK Trucking Services</title>
    <style>
        body { font-family: system-ui, sans-serif; max-width: 28rem; margin: 3rem auto; padding: 0 1rem; }
        label { display: block; margin-top: 1rem; }
        input { width: 100%; padding: 0.5rem; box-sizing: border-box; }
        button { margin-top: 1.25rem; padding: 0.5rem 1rem; }
        .error { color: #b91c1c; font-size: 0.875rem; }
        nav a { margin-right: 0.75rem; }
    </style>
</head>
<body>
    <h1>GK Trucking Services</h1>
    <h2>Login</h2>
    <nav>
        <a href="{{ route('register.customer') }}">Register customer</a>
        <a href="{{ route('register.driver') }}">Register driver</a>
    </nav>

    @if ($errors->any())
        <ul class="error">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form method="post" action="{{ route('login') }}">
        @csrf
        <label for="email">Email</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>

        <label for="password">Password</label>
        <input id="password" type="password" name="password" required>

        <label>
            <input type="checkbox" name="remember"> Remember me
        </label>

        <button type="submit">Log in</button>
    </form>
</body>
</html>
