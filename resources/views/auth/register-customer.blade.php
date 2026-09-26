<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register customer — GK Trucking Services</title>
    <style>
        body { font-family: system-ui, sans-serif; max-width: 28rem; margin: 3rem auto; padding: 0 1rem; }
        label { display: block; margin-top: 1rem; }
        input { width: 100%; padding: 0.5rem; box-sizing: border-box; }
        button { margin-top: 1.25rem; padding: 0.5rem 1rem; }
        .error { color: #b91c1c; font-size: 0.875rem; }
    </style>
</head>
<body>
    <h1>Register as customer</h1>
    <p><a href="{{ route('login') }}">Back to login</a></p>

    @if ($errors->any())
        <ul class="error">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form method="post" action="{{ route('register.customer') }}">
        @csrf
        <label for="name">Name</label>
        <input id="name" type="text" name="name" value="{{ old('name') }}" required>

        <label for="email">Email</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" required>

        <label for="mobile">Mobile</label>
        <input id="mobile" type="text" name="mobile" value="{{ old('mobile') }}">

        <label for="password">Password</label>
        <input id="password" type="password" name="password" required>

        <label for="password_confirmation">Confirm password</label>
        <input id="password_confirmation" type="password" name="password_confirmation" required>

        <button type="submit">Create account</button>
    </form>
</body>
</html>
