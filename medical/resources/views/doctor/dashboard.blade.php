<!DOCTYPE html>
<html>
<head>
    <title>Doctor Dashboard - Medical Services</title>
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
            background: linear-gradient(to right, #1d976c, #93f9b9);
            padding: 20px 50px;
            color: white;
            position: fixed;
            width: calc(100% - 100px); /* Fix width calculation accounting for padding */
            top: 0;
            left: 0;
            z-index: 100;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .dashboard-container {
            display: grid;
            grid-template-columns: 250px 1fr;
            gap: 30px;
            margin-top: 80px;
            padding: 20px;
        }

        .sidebar {
            background: white;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            position: sticky;
            top: 100px; /* Account for header height */
            max-height: calc(100vh - 120px);
            overflow-y: auto;
        }

        .main-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }

        .stat-card {
            background: white;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .appointments-list {
            background: white;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            grid-column: 1 / -1;
        }

        .menu-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 15px;
            color: #2c3e50;
            text-decoration: none;
            border-radius: 8px;
            margin-bottom: 5px;
            transition: all 0.3s ease;
        }

        .menu-item:hover {
            background: #f8f9fa;
            color: #1d976c;
        }

        .menu-item.active {
            background: #1d976c;
            color: white;
        }

        .stat-value {
            font-size: 2em;
            font-weight: bold;
            color: #1d976c;
        }

        .stat-label {
            color: #666;
            font-size: 0.9em;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        th {
            font-weight: 600;
            color: #2c3e50;
        }

        .status-pill {
            padding: 5px 12px;
            border-radius: 15px;
            font-size: 0.85em;
            font-weight: 500;
        }

        .status-upcoming {
            background: #e3f2fd;
            color: #1976d2;
        }

        .status-completed {
            background: #e8f5e9;
            color: #2e7d32;
        }

        .action-button {
            padding: 8px 15px;
            border-radius: 20px;
            border: none;
            background: #1d976c;
            color: white;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .action-button:hover {
            background: #166e4e;
        }

        @media (max-width: 768px) {
            .dashboard-container {
                grid-template-columns: 1fr;
                margin-top: 120px;
            }
            
            .header {
                padding: 15px 20px;
                width: calc(100% - 40px);
            }
            
            .sidebar {
                position: static;
                max-height: none;
            }
            
            .main-content {
                grid-template-columns: 1fr;
            }
            
            table {
                display: block;
                overflow-x: auto;
                white-space: nowrap;
            }
            
            .header h2 {
                font-size: 1.2rem;
            }
        }

        .back-button {
            padding: 0.5rem 1rem;
            background: rgba(255, 255, 255, 0.1);
            color: white;
            text-decoration: none;
            border-radius: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .back-button:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateX(-2px);
        }
    </style>
</head>
<body>
    <div class="header">
        <div style="display: flex; align-items: center; gap: 1rem;">
            <a href="{{ route('dashboard') }}" class="back-button">
                <i class="fas fa-arrow-left"></i> Back to Home
            </a>
            <h2>Welcome, Dr. {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</h2>
        </div>
        <div class="header-actions">
            <span class="status-pill status-upcoming">
                <i class="fas fa-circle"></i> Online
            </span>
        </div>
    </div>

    <div class="dashboard-container">
        <div class="sidebar">
            <a href="{{ route('doctor.dashboard') }}" class="menu-item {{ request()->routeIs('doctor.dashboard') ? 'active' : '' }}">
                <i class="fas fa-home"></i> Dashboard
            </a>
            <a href="{{ route('doctor.appointments') }}" class="menu-item {{ request()->routeIs('doctor.appointments') ? 'active' : '' }}">
                <i class="fas fa-calendar-alt"></i> Appointments
            </a>
            <a href="{{ route('doctor.patients') }}" class="menu-item {{ request()->routeIs('doctor.patients') ? 'active' : '' }}">
                <i class="fas fa-user-injured"></i> Patients
            </a>
            <a href="{{ route('doctor.records') }}" class="menu-item {{ request()->routeIs('doctor.records') ? 'active' : '' }}">
                <i class="fas fa-notes-medical"></i> Medical Records
            </a>
            <a href="{{ route('doctor.telemedicine') }}" class="menu-item {{ request()->routeIs('doctor.telemedicine') ? 'active' : '' }}">
                <i class="fas fa-video"></i> Telemedicine
            </a>
            <a href="{{ route('doctor.settings') }}" class="menu-item {{ request()->routeIs('doctor.settings') ? 'active' : '' }}">
                <i class="fas fa-cog"></i> Settings
            </a>
        </div>

        <div class="main-content">
            <div class="stat-card">
                <div class="stat-value">{{ $todayAppointments }}</div>
                <div class="stat-label">Today's Appointments</div>
            </div>
            <div class="stat-card">
                <div class="stat-value">{{ $totalPatients }}</div>
                <div class="stat-label">Total Patients</div>
            </div>
            <div class="stat-card">
                <div class="stat-value">{{ $scheduledAppointments }}</div>
                <div class="stat-label">Scheduled Appointments</div>
            </div>

            <div class="appointments-list">
                <h3>Upcoming Appointments</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Patient</th>
                            <th>Date & Time</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($appointments as $appointment)
                            <tr>
                                <td>{{ $appointment->user->first_name ?? 'N/A' }} {{ $appointment->user->last_name ?? '' }}</td>
                                <td>
                                    <div>
                                        {{ \Carbon\Carbon::parse($appointment->date)->format('M d, Y') }}
                                        <div style="font-size: 0.9em; color: #666;">
                                            {{ \Carbon\Carbon::parse($appointment->time)->format('h:i A') }}
                                        </div>
                                    </div>
                                </td>
                                <td>{{ ucfirst($appointment->appointment_type ?? 'N/A') }}</td>
                                <td>
                                    <span class="status-pill status-{{ strtolower($appointment->status ?? 'pending') }}">
                                        {{ ucfirst($appointment->status ?? 'Pending') }}
                                    </span>
                                </td>
                                <td>
                                    <button class="action-button" onclick="viewAppointment('{{ $appointment->id }}')">View Details</button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="text-align: center;">No upcoming appointments</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>