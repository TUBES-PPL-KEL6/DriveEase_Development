<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>DriveEase - Sewa Mobil Mudah dan Aman</title>

    <!-- Bootstrap (Optional) + Tailwind -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Optional SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="font-sans antialiased bg-gray-100">
    <div class="min-h-screen">

        <!-- Navbar dinamis -->
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

        <!-- Header -->
        @isset($header)
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <!-- Content -->
        <main class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            {{ $slot }}
        </main>

    </div>

    <!-- Optional Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    @stack('scripts')
</body>
</html>
