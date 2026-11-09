<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Magyar nevek')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&family=Quicksand:wght@500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('style.css')}}">
    <link rel="shortcut icon" href="{{asset('favicon.ico')}}" type="image/x-icon">
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="{{ route('names.index') }}">Nevek</a></li>
                <li><a href="{{ route('search.index') }}">Keresés</a></li>
                <li><a href="{{ route('stats.index') }}">Statisztika</a></li>
            </ul>
        </nav>
    </header>
    <main>
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-warning">{{ session('error') }}</div>
        @endif

        @yield('content')
    </main>
    <footer>
        <p>© 2026 Magyar nevek - Selmeczy György</p>
    </footer>
</body>
</html>