<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Customer') — GK Trucking Services</title>
    <style>
        body { font-family: system-ui, sans-serif; margin: 0; }
        header { background: #0f766e; color: #fff; padding: 0.75rem 1rem; }
        header a { color: #ccfbf1; margin-right: 1rem; text-decoration: none; }
        header a:hover { color: #fff; }
        main { max-width: 56rem; margin: 1.5rem auto; padding: 0 1rem; }
        table { width: 100%; border-collapse: collapse; margin-top: 1rem; }
        th, td { border: 1px solid #e2e8f0; padding: 0.5rem; text-align: left; }
        label { display: block; margin-top: 0.75rem; }
        input, select, textarea { width: 100%; max-width: 28rem; padding: 0.4rem; box-sizing: border-box; }
        button, .btn { display: inline-block; margin-top: 1rem; padding: 0.4rem 0.75rem; cursor: pointer; }
        .error { color: #b91c1c; }
        .status { color: #047857; margin-bottom: 1rem; }
        dl { display: grid; grid-template-columns: 10rem 1fr; gap: 0.5rem 1rem; }
    </style>
</head>
<body>
    <header>
        <strong>GK Customer</strong>
        <nav>
            <a href="{{ route('customer.home') }}">Home</a>
            <a href="{{ route('customer.bookings.index') }}">My Bookings</a>
            <a href="{{ route('customer.bookings.create') }}">New Booking</a>
        </nav>
        <form method="post" action="{{ route('logout') }}" style="display:inline;margin-left:1rem;">
            @csrf
            <button type="submit" style="background:transparent;border:1px solid #99f6e4;color:#ecfdf5;">Log out</button>
        </form>
    </header>
    <main>
        @if (session('status'))
            <p class="status">{{ session('status') }}</p>
        @endif
        @if ($errors->any())
            <ul class="error">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif
        @yield('content')
    </main>
</body>
</html>
