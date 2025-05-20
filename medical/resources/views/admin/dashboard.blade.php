<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard - Medical Services</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Murecho:wght@100..900&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Murecho', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
        }

        .header {
            background: linear-gradient(to right, #2c3e50, #3498db);
            padding: 20px 50px;
            color: white;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 100;
            box-sizing: border-box;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header-actions {
            display: flex;
            gap: 20px;
            align-items: center;
        }

        .profile-button {
            background: rgba(255, 255, 255, 0.1);
            border: none;
            padding: 8px 15px;
            border-radius: 20px;
            color: white;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
        }

        .profile-button:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        .dashboard-container {
            display: grid;
            grid-template-columns: 250px 1fr;
            gap: 30px;
            margin-top: 80px;
            padding: 20px;
            max-width: 1400px;
            margin-left: auto;
            margin-right: auto;
        }

        .sidebar {
            background: white;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            height: fit-content;
            position: sticky;
            top: 100px;
        }

        .main-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        .stat-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-icon {
            font-size: 2.5em;
            margin-bottom: 15px;
            background: linear-gradient(45deg, #3498db, #2ecc71);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .stat-value {
            font-size: 2.5em;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 5px;
        }

        .stat-label {
            color: #666;
            font-size: 1em;
        }

        .menu-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 15px;
            color: #2c3e50;
            text-decoration: none;
            border-radius: 10px;
            margin-bottom: 8px;
            transition: all 0.3s ease;
        }

        .menu-item:hover {
            background: #f8f9fa;
            color: #3498db;
            transform: translateX(5px);
        }

        .menu-item.active {
            background: #3498db;
            color: white;
        }

        .menu-item i {
            font-size: 1.2em;
        }

        .data-table {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            grid-column: 1 / -1;
        }

        .data-table h3 {
            color: #2c3e50;
            margin-top: 0;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        th {
            font-weight: 600;
            color: #2c3e50;
            background: #f8f9fa;
        }

        tr:hover {
            background: #f8f9fa;
        }

        .status-pill {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.85em;
            font-weight: 500;
        }

        .status-scheduled {
            background: #e3f2fd;
            color: #1565c0;
        }

        .status-completed {
            background: #e8f5e9;
            color: #2e7d32;
        }

        .status-cancelled {
            background: #ffebee;
            color: #c62828;
        }

        .action-button {
            padding: 8px 15px;
            border-radius: 20px;
            border: none;
            background: #3498db;
            color: white;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 0.9em;
        }

        .action-button:hover {
            background: #2980b9;
            transform: translateY(-2px);
        }

        @media (max-width: 768px) {
            .dashboard-container {
                grid-template-columns: 1fr;
            }

            .header {
                padding: 15px;
            }

            .stat-card {
                min-width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>Welcome, Admin {{ Auth::user()->first_name }}</h2>
        <div class="header-actions">
            <button class="profile-button">
                <i class="fas fa-user"></i> Profile
            </button>
            <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                @csrf
                <button type="submit" class="profile-button">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </button>
            </form>
        </div>
    </div>

    <div class="dashboard-container">
        <div class="sidebar">
            <a href="#" class="menu-item active">
                <i class="fas fa-home"></i> Dashboard
            </a>
            <a href="{{ route('admin.users') }}" class="menu-item">
                <i class="fas fa-users"></i> Users
            </a>
            <a href="{{ route('admin.doctors') }}" class="menu-item">
                <i class="fas fa-user-md"></i> Doctors
            </a>
            <a href="{{ route('admin.appointments') }}" class="menu-item">
                <i class="fas fa-calendar-alt"></i> Appointments
            </a>
            <a href="{{ route('admin.hospitals') }}" class="menu-item">
                <i class="fas fa-hospital"></i> Hospitals
            </a>
            <a href="{{ route('admin.settings') }}" class="menu-item">
                <i class="fas fa-cog"></i> Settings
            </a>
        </div>

        <div class="main-content">
            <!-- Stats Cards -->
            <div class="stat-card">
                <i class="fas fa-users stat-icon"></i>
                <div class="stat-value">{{ $totalUsers }}</div>
                <div class="stat-label">Total Users</div>
            </div>

            <div class="stat-card">
                <i class="fas fa-user-md stat-icon"></i>
                <div class="stat-value">{{ $totalDoctors }}</div>
                <div class="stat-label">Total Doctors</div>
            </div>

            <div class="stat-card">
                <i class="fas fa-hospital-user stat-icon"></i>
                <div class="stat-value">{{ $totalPatients }}</div>
                <div class="stat-label">Total Patients</div>
            </div>

            <div class="stat-card">
                <i class="fas fa-calendar-check stat-icon"></i>
                <div class="stat-value">{{ $totalAppointments }}</div>
                <div class="stat-label">Total Appointments</div>
            </div>

            <!-- Recent Users Table -->
            <div class="data-table">
                <h3><i class="fas fa-users"></i> Recent Users</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Role</th>
                            <th>Joined Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentUsers as $user)
                            <tr>
                                <td>{{ $user->first_name }}</td>
                                <td>{{ ucfirst($user->role) }}</td>
                                <td>{{ Carbon\Carbon::parse($user->created_at)->format('M d, Y') }}</td>
                                <td>
                                    <button class="action-button">View Details</button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" style="text-align: center;">No recent users</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Recent Appointments Table -->
            <div class="data-table">
                <h3><i class="fas fa-calendar-alt"></i> Recent Appointments</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Patient</th>
                            <th>Doctor</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentAppointments as $appointment)
                            <tr>
                                <td>{{ $appointment->patient_name }}</td>
                                <td>{{ $appointment->doctor_name }}</td>
                                <td>{{ Carbon\Carbon::parse($appointment->date)->format('M d, Y') }}</td>
                                <td>
                                    <span class="status-pill status-{{ $appointment->status }}">
                                        {{ ucfirst($appointment->status) }}
                                    </span>
                                </td>
                                <td>
                                    <button class="action-button">View Details</button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="text-align: center;">No recent appointments</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>