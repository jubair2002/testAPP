<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Users') · {{ config('app.name', 'Cluster Users') }}</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <header class="topbar">
        <div class="topbar-inner">
            <a class="brand" href="{{ route('users.index') }}">
                <span class="brand-mark" aria-hidden="true">U</span>
                <span>Cluster Users</span>
            </a>
            <div class="connection"><span class="connection-dot"></span> MySQL InnoDB Cluster</div>
        </div>
    </header>
    <main>
        @if (session('status'))
            <div class="alert" role="status">{{ session('status') }}</div>
        @endif
        @yield('content')
    </main>
    <footer class="app-footer">Version 2.0</footer>
</body>
</html>
