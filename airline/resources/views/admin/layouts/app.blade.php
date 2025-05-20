<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel - @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .sidebar {
            min-height: 100vh;
            background: #2c3e50;
            color: white;
        }
        .sidebar a {
            color: white;
            text-decoration: none;
            padding: 10px 15px;
            display: block;
        }
        .sidebar a:hover {
            background: #34495e;
        }
        .content {
            padding: 20px;
        }
        .stats-card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-2 sidebar">
                <h3 class="p-3">Admin Panel</h3>
                <nav>
                    <a href="{{ route('admin.dashboard') }}">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                    <a href="{{ route('admin.flights') }}">
                        <i class="fas fa-plane"></i> Flights
                    </a>
                    <a href="{{ route('admin.users') }}">
                        <i class="fas fa-users"></i> Users
                    </a>
                    <a href="{{ route('admin.bookings') }}">
                        <i class="fas fa-ticket-alt"></i> Bookings
                    </a>
                    <a href="{{ route('dashboard') }}">
                        <i class="fas fa-home"></i> Back to Site
                    </a>
                </nav>
            </div>

            <!-- Main Content -->
            <div class="col-md-10 content">
                @yield('content')
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>