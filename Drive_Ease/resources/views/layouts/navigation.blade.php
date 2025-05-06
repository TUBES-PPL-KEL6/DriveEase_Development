<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>DriveEase - Sewa Mobil Mudah dan Aman</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 text-gray-800 font-sans">
    <div class="min-h-screen bg-gray-100">
        @include('layouts.navigation') <!-- Layouts navigation untuk menu global -->

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

    <script>
        @if (auth()->check())
        document.addEventListener('DOMContentLoaded', function () {
            const countNotification = async () => {
                const response = await fetch('{{ route('notifications.count') }}');
                const data = await response.json();
                document.getElementById('notification-count').innerHTML = data;
            }
            countNotification();
            setInterval(countNotification, 5000);
        });
        @endif

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
                body: JSON.stringify({ id })
            }).then(response => response.json())
            .then(data => console.log(data));
        }
    </script>
</body>

</html>
