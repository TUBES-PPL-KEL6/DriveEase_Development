<!-- SIDEBAR -->
<aside class="fixed top-0 left-0 h-screen w-64 bg-gray-900 text-white shadow-md z-50">
    <div class="p-6 flex flex-col h-full">
        <!-- Logo -->
        <div class="mb-8 text-center">
            <h4 class="text-2xl font-bold text-white tracking-wide">
                <i class="fas fa-car text-blue-400 mr-2"></i> DriveEase
            </h4>
            <div class="w-16 h-1 bg-blue-400 mx-auto mt-2 rounded-full"></div>
        </div>

        <!-- Dashboard -->
        <a href="{{ route('dashboard') }}"
            class="flex items-center px-4 py-3 mb-4 {{ request()->routeIs('dashboard') ? 'bg-gray-800' : 'hover:bg-gray-700' }} rounded-lg transition">
            <i class="fas fa-tachometer-alt text-blue-300 mr-3"></i>
            <span class="font-semibold text-white">Dashboard</span>
        </a>

        <!-- Menu -->
        <h6 class="text-gray-400 text-xs uppercase tracking-wide mb-2 px-4">Menu</h6>
        <div class="space-y-2">
            <!-- Kelola User -->
            <a href="{{ route('admin.users.index') }}"
                class="flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('admin.users.*') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:text-white hover:bg-gray-700' }} transition group">
                <i class="fas fa-users {{ request()->routeIs('admin.users.*') ? 'text-green-300' : 'text-green-400' }} mr-3 group-hover:text-green-300"></i>
                <span>Kelola User</span>
            </a>

            <!-- Kelola Transaksi -->
            <a href="{{ route('admin.transactions.index') }}"
                class="flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('admin.transactions.*') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:text-white hover:bg-gray-700' }} transition group">
                <i class="fas fa-exchange-alt {{ request()->routeIs('admin.transactions.*') ? 'text-purple-300' : 'text-purple-400' }} mr-3 group-hover:text-purple-300"></i>
                <span>Kelola Transaksi</span>
            </a>

            <!-- Verifikasi Dokumen -->
            <a href="{{ route('admin.verify.documents') }}"
                class="flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('admin.verify.documents') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:text-white hover:bg-gray-700' }} transition group">
                <i class="fas fa-file-alt {{ request()->routeIs('admin.verify.documents') ? 'text-yellow-300' : 'text-yellow-400' }} mr-3 group-hover:text-yellow-300"></i>
                <span>Verifikasi Dokumen</span>
            </a>
        </div>

        <!-- Spacer -->
        <div class="flex-grow"></div>
    </div>
</aside>