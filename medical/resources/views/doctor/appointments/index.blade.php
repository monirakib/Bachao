<!DOCTYPE html>
<html>
<head>
    <title>Appointments - Medical Services</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Murecho:wght@100..900&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #1d976c;
            --secondary-color: #93f9b9;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Murecho', sans-serif;
            background: #f5f7fa;
            min-height: 100vh;
        }

        .dashboard-container {
            display: flex;
            min-height: 100vh;
            padding-top: 80px;
        }

        .header {
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
            padding: 20px 50px;
            color: white;
            position: fixed;
            width: 100%;
            top: 0;
            left: 0;
            z-index: 100;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .sidebar {
            width: 260px;
            background: white;
            padding: 20px;
            position: fixed;
            height: calc(100vh - 80px);
            box-shadow: 2px 0 10px rgba(0,0,0,0.05);
        }

        .main-content {
            flex: 1;
            margin-left: 260px;
            padding: 30px;
        }

        .menu-item {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            color: #555;
            text-decoration: none;
            border-radius: 10px;
            margin-bottom: 10px;
            transition: all 0.3s ease;
        }

        .menu-item:hover, .menu-item.active {
            background: #f8f9fa;
            color: var(--primary-color);
        }

        .menu-item i {
            margin-right: 12px;
            width: 20px;
            text-align: center;
        }

        .filter-section {
            background: white;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 30px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }

        .appointments-list {
            background: white;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        th {
            background: #f8f9fa;
            padding: 15px;
            font-weight: 600;
            color: #444;
            text-align: left;
            border-bottom: 2px solid #eee;
        }

        td {
            padding: 15px;
            border-bottom: 1px solid #eee;
            vertical-align: middle;
        }

        .action-button {
            background: var(--primary-color);
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .action-button:hover {
            background: #178a5f;
        }

        .back-button {
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .back-button:hover {
            color: #e0e0e0;
        }

        .dropdown-toggle {
            background: white;
            color: var(--primary-color);
            border: 2px solid var(--primary-color);
            padding: 10px 20px;
            border-radius: 10px;
            cursor: pointer;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .dropdown-toggle:hover {
            background: #f8f9fa;
        }

        .badge {
            padding: 8px 12px;
            border-radius: 8px;
            font-weight: 500;
        }

        .alert {
            border-radius: 10px;
            padding: 15px 20px;
            margin-bottom: 20px;
            border: none;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }

        .pagination {
            margin-top: 20px;
            justify-content: center;
        }
    </style>
</head>
<body>
    <div class="header">
        <div style="display: flex; align-items: center; gap: 1rem;">
            <a href="{{ route('doctor.dashboard') }}" class="back-button">
                <i class="fas fa-arrow-left"></i> Back to Dashboard
            </a>
            <h2>Appointments</h2>
        </div>
    </div>

    <div class="dashboard-container">
        <div class="sidebar">
            <a href="{{ route('doctor.dashboard') }}" class="menu-item">
                <i class="fas fa-home"></i> Dashboard
            </a>
            <a href="{{ route('doctor.appointments') }}" class="menu-item active">
                <i class="fas fa-calendar-alt"></i> Appointments
            </a>
            <a href="{{ route('doctor.patients') }}" class="menu-item">
                <i class="fas fa-user-injured"></i> Patients
            </a>
            <a href="{{ route('doctor.records') }}" class="menu-item">
                <i class="fas fa-notes-medical"></i> Medical Records
            </a>
            <a href="{{ route('doctor.telemedicine') }}" class="menu-item">
                <i class="fas fa-video"></i> Telemedicine
            </a>
            <a href="{{ route('doctor.settings') }}" class="menu-item">
                <i class="fas fa-cog"></i> Settings
            </a>
        </div>

        <div class="main-content">
            @if(session('success'))
                <div class="alert alert-success" style="background: #e8f5e9; color: #2e7d32;">
                    {{ session('success') }}
                </div>
            @endif

            <div class="filter-section">
                <div class="btn-group">
                    <button type="button" class="dropdown-toggle" data-bs-toggle="dropdown">
                        <i class="fas fa-filter"></i> Filter By Status
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('doctor.appointments', ['status' => 'all']) }}">All</a></li>
                        <li><a class="dropdown-item" href="{{ route('doctor.appointments', ['status' => 'scheduled']) }}">Scheduled</a></li>
                        <li><a class="dropdown-item" href="{{ route('doctor.appointments', ['status' => 'completed']) }}">Completed</a></li>
                        <li><a class="dropdown-item" href="{{ route('doctor.appointments', ['status' => 'cancelled']) }}">Cancelled</a></li>
                    </ul>
                </div>
            </div>

            <div class="appointments-list">
                <table>
                    <thead>
                        <tr>
                            <th>Patient</th>
                            <th>Date & Time</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($appointments as $appointment)
                            <tr>
                                <td>
                                    <div style="font-weight: 600;">{{ $appointment->first_name }} {{ $appointment->last_name }}</div>
                                    <div style="font-size: 0.85em; color: #666;">{{ $appointment->email }}</div>
                                </td>
                                <td>
                                    <div>{{ \Carbon\Carbon::parse($appointment->date)->format('M d, Y') }}</div>
                                    <div style="font-size: 0.85em; color: #666;">{{ \Carbon\Carbon::parse($appointment->time)->format('h:i A') }}</div>
                                </td>
                                <td>
                                    <span class="badge badge-info">
                                        {{ ucfirst($appointment->appointment_type) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge badge-{{ $appointment->status === 'completed' ? 'success' : ($appointment->status === 'cancelled' ? 'danger' : 'info') }}">
                                        {{ ucfirst($appointment->status) }}
                                    </span>
                                </td>
                                <td>
                                    <button class="action-button" onclick="window.location.href='{{ route('doctor.appointments.show', $appointment->id) }}'">
                                        <i class="fas fa-eye"></i> View
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="text-align: center; padding: 30px;">
                                    <i class="fas fa-calendar-times fa-2x" style="color: #666; margin-bottom: 10px;"></i>
                                    <p style="color: #666; margin: 0;">No appointments found</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="d-flex justify-content-center mt-4">
                    {{ $appointments->links() }}
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>