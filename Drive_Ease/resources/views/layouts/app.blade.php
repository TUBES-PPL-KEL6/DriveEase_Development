<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>DriveEase</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="font-sans antialiased">
    <nav class="bg-gray-800 text-white p-4 flex justify-between">
        <div>
            <a href="/" class="font-bold">DriveEase</a>
        </div>
        <div class="space-x-4">
            @auth
                @if(auth()->user()->role === 'pelanggan')
                    <a href="{{ route('user.dashboard') }}">Dashboard</a>
                    <a href="{{ route('vehicles.index') }}">Cari Kendaraan</a>
                @elseif(auth()->user()->role === 'rental')
                    <a href="{{ route('rental.dashboard') }}">Dashboard</a>
                @elseif(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                @endif
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}">Login</a>
                <a href="{{ route('register') }}">Register</a>
            @endauth
        </div>
    </nav>

    <main class="p-4">
        @yield('content')
    </main>
</body>
</html>
