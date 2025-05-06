<!DOCTYPE html>
<<<<<<< HEAD
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- <title>{{ config('app.name', 'Laravel') }}</title> --}}
    <title>DriveEase - Sewa Mobil Mudah dan Aman</title>

    <!-- Add Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">


    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        @include('layouts.navigation')

        <!-- Add Bootstrap JS and Popper.js -->
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>


        <!-- Page Heading -->
        @isset($header)
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <!-- Page Content -->
        <main class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            {{ $slot }}
        </main>
    </div>
</body>

=======
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
>>>>>>> main
</html>
