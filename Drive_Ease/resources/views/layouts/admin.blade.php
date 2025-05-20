<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - DriveEase</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="{{ route('admin.dashboard') }}">DriveEase Admin</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="{{ route('admin.users.index') }}">Users</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('admin.config') }}">Config</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('admin.vehicles.reviews') }}">Kendaraan & Ulasan</a></li>
                <li class="nav-item">
                    <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                        @csrf
                        <button type="submit" class="nav-link bg-transparent border-0" style="color: #fff; cursor: pointer;">Logout</button>
                    </form>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container mt-4">
        @yield('content')
    </div>
</body>
</html> 