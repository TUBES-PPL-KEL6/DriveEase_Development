@extends('layouts.app')

@section('content')
    <div class="d-flex">
        {{-- Include Sidebar --}}
        @include('layouts.sidebar')

        {{-- Main Content --}}
        <div class="flex-grow-1 p-4">
            <div class="bg-white rounded-lg shadow-md p-6">
                <h1 class="text-3xl font-bold mb-4 text-gray-800">Dashboard Admin</h1>
                <p class="text-lg text-gray-600 mb-6">
                    Selamat datang, <span class="font-semibold text-blue-600">{{ auth()->user()->name }}</span>!
                </p>

                {{-- Statistics Cards --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    {{-- Total Users Card --}}
                    <div class="bg-white rounded-xl shadow-md p-6 border border-gray-200">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                                    </path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h2 class="text-gray-600 text-sm">Total Users</h2>
                                <p class="text-2xl font-semibold text-gray-800">{{ $totalUsers }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- Total Rentals Card --}}
                    <div class="bg-white rounded-xl shadow-md p-6 border border-gray-200">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-green-100 text-green-600">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                    </path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h2 class="text-gray-600 text-sm">Total Rentals</h2>
                                <p class="text-2xl font-semibold text-gray-800">{{ $totalRentals }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- Total Profit Card --}}
                    <div class="bg-white rounded-xl shadow-md p-6 border border-gray-200">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                    </path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h2 class="text-gray-600 text-sm">Total Profit</h2>
                                <p class="text-2xl font-semibold text-gray-800">Rp
                                    {{ number_format($totalProfit, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- User Registration Chart --}}
                <div class="bg-white rounded-xl shadow-md p-6 border border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">User Registration Trend</h2>
                    <div class="h-80">
                        <canvas id="userRegistrationChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const ctx = document.getElementById('userRegistrationChart').getContext('2d');
                const userData = {!! json_encode($userRegistrations) !!};

                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: userData.map(item => item.month),
                        datasets: [{
                            label: 'User Registrations',
                            data: userData.map(item => item.count),
                            borderColor: 'rgb(59, 130, 246)',
                            backgroundColor: 'rgba(59, 130, 246, 0.1)',
                            tension: 0.4,
                            fill: true,
                            pointBackgroundColor: 'rgb(59, 130, 246)',
                            pointBorderColor: '#fff',
                            pointBorderWidth: 2,
                            pointRadius: 4,
                            pointHoverRadius: 6
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                                padding: 12,
                                titleFont: {
                                    size: 14,
                                    weight: 'bold'
                                },
                                bodyFont: {
                                    size: 13
                                },
                                displayColors: false
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 1,
                                    font: {
                                        size: 12
                                    }
                                },
                                grid: {
                                    color: 'rgba(0, 0, 0, 0.05)'
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    font: {
                                        size: 12
                                    }
                                }
                            }
                        }
                    }
                });
            });
        </script>
    @endpush
@endsection
