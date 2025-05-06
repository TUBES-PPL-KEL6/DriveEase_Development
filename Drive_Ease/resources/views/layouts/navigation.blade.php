<script>
    document.addEventListener('DOMContentLoaded', function() {
        const countNotification = async () => {
            const response = await fetch('{{ route('notifications.count') }}');
            const data = await response.json();
            document.getElementById('notification-count').innerHTML = data;
        }
        countNotification();
        setInterval(function() {
            countNotification();
        }, 5000);
    });

    function fetchNotifications() {
        fetch('{{ route('notifications.fetch') }}')
            .then(response => response.json())
            .then(data => {
                document.getElementById('notifications-container').innerHTML = '';
                if (data.length === 0) {
                    document.getElementById('notifications-container').innerHTML += `
                        <div class="text-center text-sm font-bold">
                            Tidak ada notifikasi
                        </div>
                    `;
                } else {
                    data.forEach(notification => {
                        document.getElementById('notifications-container').innerHTML += `
                        <div class="card">
                            <div class="card-body d-flex justify-content-between gap-4">
                                <div class="">
                                    <h5 class="card-title text-sm font-bold">${notification.title}</h5>
                                    <p class="card-text text-xs">${notification.message}</p>
                                </div>
                                <div class="d-flex flex-column gap-2">
                                    <a href="${notification.link}" class="btn btn-outline-primary btn-xs text-xs">Lihat</a>
                                    <button class="btn btn-outline-success btn-xs text-xs"
                                        onclick="markAsRead(${notification.id})">Sudah Baca</button>
                                </div>
                            </div>
                        </div>
                    `;
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
                    id: id
                })
            }).then(response => response.json())
            .then(data => {
                console.log(data);
            });

        // console.log(id, 'okee');
    }
</script>

<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    @if (auth()->user()->role == 'pelanggan')
                        <x-nav-link :href="route('rents.index')" :active="request()->routeIs('rents.index')">
                            {{ __('Riwayat Sewa') }}
                        </x-nav-link>
                    @endif

                    @if (auth()->user()->role == 'rental')
                        <x-nav-link :href="route('rental.rents.index')" :active="request()->routeIs('rental.rents.index')">
                            {{ __('Sewa') }}
                        </x-nav-link>
                    @endif
                </div>
            </div>



            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6 space-x-4">

                {{-- Notification --}}
                <div class="ml-3 relative">
                    <x-dropdown align="right" width="w-96">
                        <x-slot name="trigger">
                            <button
                                class="p-2 rounded-full flex items-center justify-center hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                onclick="fetchNotifications()" dusk="notification-button">
                                <span class="sr-only">View notifications</span>
                                <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24">
                                    <path
                                        d="M17.133 12.632v-1.8a5.406 5.406 0 0 0-4.154-5.262.955.955 0 0 0 .021-.106V3.1a1 1 0 0 0-2 0v2.364a.955.955 0 0 0 .021.106 5.406 5.406 0 0 0-4.154 5.262v1.8C6.867 15.018 5 15.614 5 16.807 5 17.4 5 18 5.538 18h12.924C19 18 19 17.4 19 16.807c0-1.193-1.867-1.789-1.867-4.175ZM8.823 19a3.453 3.453 0 0 0 6.354 0H8.823Z" />
                                </svg>
                                <span class="badge bg-warning text-dark" id="notification-count">0</span>

                            </button>
                        </x-slot>


                        <x-slot name="content">
                            <div class="px-4 py-6 space-y-2" id="notifications-container">

                            </div>
                        </x-slot>
                    </x-dropdown>
                </div>

                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>

            @if (auth()->user()->role == 'pelanggan')
                <x-responsive-nav-link :href="route('rents.index')" :active="request()->routeIs('rents.index')">
                    {{ __('Riwayat Sewa') }}
                </x-responsive-nav-link>
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
