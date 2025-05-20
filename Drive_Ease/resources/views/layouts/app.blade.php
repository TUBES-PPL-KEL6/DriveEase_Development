<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>DriveEase</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<<<<<<< Updated upstream
=======

    @auth
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const countNotification = async () => {
                    const response = await fetch('{{ route('notifications.count') }}');
                    const data = await response.json();
                    document.getElementById('notification-count').innerHTML = data;
                }
                countNotification();
                setInterval(countNotification, 5000);
            });

            function fetchNotifications() {
                fetch('{{ route('notifications.fetch') }}')
                    .then(response => response.json())
                    .then(data => {
                        const container = document.getElementById('notifications-container');
                        container.innerHTML = '';
                        if (data.length === 0) {
                            container.innerHTML = '<div class="text-center text-sm font-bold">Tidak ada notifikasi</div>';
                        } else {
                            data.forEach(notification => {
                                container.innerHTML += `
                                <div class="card">
                                    <div class="card-body d-flex justify-content-between gap-4">
                                        <div>
                                            <h5 class="card-title text-sm font-bold">${notification.title}</h5>
                                            <p class="card-text text-xs">${notification.message}</p>
                                        </div>
                                        <div class="d-flex flex-column gap-2">
                                            <a href="${notification.link}" class="btn btn-outline-primary btn-xs text-xs">Lihat</a>
                                            <button class="btn btn-outline-success btn-xs text-xs"
                                                onclick="markAsRead(${notification.id})">Sudah Baca</button>
                                        </div>
                                    </div>
                                </div>`;
                            });
                        }
                    });
            }

            function markAsRead(id) {
                fetch('{{ route('notifications.markAsRead') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            id
                        })
                    }).then(response => response.json())
                    .then(data => console.log(data));
            }
        </script>
    @endauth

    <style>
            nav {
            background-color: #0d1117 !important;
        }
    </style>
>>>>>>> Stashed changes
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

<<<<<<< Updated upstream
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
=======
<!-- <body class="font-sans antialiased bg-gray-100"> -->
<body class="font-sans antialiased bg-black text-white">

    <div class="min-h-screen">

        <!-- Navbar dinamis -->
        <nav class="navbar navbar-expand-lg navbar-dark sticky-top shadow-sm">
            <div class="container">
            <a class="navbar-brand" href="" style="text-align: left;">🚗 DriveEase</a>
            <div class="space-x-4 flex items-center">
                @auth
                    <div class="dropdown">
                        <button class="text-sm hover:text-blue-600 dropdown-toggle d-flex" type="button"
                            id="notificationDropdown" data-bs-toggle="dropdown" aria-expanded="false"
                            onclick="fetchNotifications()">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-500" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path
                                    d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z" />
                            </svg>
                            <span id="notification-count" class="badge bg-danger rounded-pill">0</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end p-2 space-y-2" style="width: 300px;"
                            aria-labelledby="notificationDropdown" id="notifications-container">
                            <li><a class="dropdown-item" href="">Lihat Semua Notifikasi</a></li>
                        </ul>
                    </div>
                    @if (auth()->user()->role === 'pelanggan')
                        <a href="{{ route('user.dashboard') }}" class="text-sm hover:text-[#00ffae]">Dashboard</a>
                        <a href="{{ route('vehicles.index') }}" class="text-sm hover:text-[#00ffae]">Cari Kendaraan</a>
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
    @yield('content') {{-- ✅ Sesuai dengan penggunaan @section di view --}}
</main>


    </div>

    <!-- Optional Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
>>>>>>> Stashed changes
    @stack('scripts')
</body>
</html>
