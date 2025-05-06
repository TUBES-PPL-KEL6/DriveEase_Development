<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>DriveEase</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-gray-100 text-gray-800 font-sans">
    <nav class="bg-white shadow-md p-4 flex justify-between items-center">
        <div class="font-bold text-xl text-blue-600">DriveEase</div>
        <div class="space-x-4">
            @auth
                @if(auth()->user()->role === 'pelanggan')
                    <a href="{{ route('user.dashboard') }}" class="text-sm hover:text-blue-600">Dashboard</a>
                    <a href="{{ route('vehicles.index') }}" class="text-sm hover:text-blue-600">Cari Kendaraan</a>
                @elseif(auth()->user()->role === 'rental')
                    <a href="{{ route('rental.dashboard') }}" class="text-sm hover:text-blue-600">Dashboard Rental</a>
                @elseif(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="text-sm hover:text-blue-600">Dashboard Admin</a>
                @endif

                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="text-sm text-red-500 hover:underline">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="text-sm hover:text-blue-600">Login</a>
                <a href="{{ route('register') }}" class="text-sm hover:text-blue-600">Register</a>
            @endauth
        </div>
    </nav>

    <main class="max-w-6xl mx-auto p-6">
        @yield('content')
    </main>
    @stack('scripts')
</body>
</html>
