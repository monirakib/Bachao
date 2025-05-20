<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointments Management - Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
        }

        .navbar {
            background: linear-gradient(to right, #4b6cb7, #182848);
            padding: 1rem 0;
            margin-bottom: 2rem;
        }

        .navbar-brand {
            color: white;
            font-weight: 600;
            font-size: 1.5rem;
        }

        .card {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border: none;
            border-radius: 10px;
        }

        .btn-primary {
            background: linear-gradient(to right, #4b6cb7, #182848);
            border: none;
        }

        .btn-primary:hover {
            background: linear-gradient(to right, #3b5998, #182848);
            transform: translateY(-1px);
        }

        .btn-group {
            display: flex;
            gap: 5px;
        }

        .table td {
            vertical-align: middle;
        }

        .badge {
            font-size: 0.85em;
            padding: 0.4em 0.8em;
        }

        .card-header {
            font-size: 1.1em;
            font-weight: 600;
            background: #f8f9fa;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <span class="navbar-brand">
                <i class="fas fa-calendar-check me-2"></i>Appointments Management
            </span>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-light btn-sm">
                <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
            </a>
        </div>
    </nav>

    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3">Manage Appointments</h1>
            <a href="{{ route('appointments.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Create Appointment
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card shadow-sm mb-4">
            <div class="card-header bg-white border-bottom">
                <i class="fas fa-table me-1"></i>
                <span class="fw-bold">Appointments List</span>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle" id="appointmentsTable">
                        <thead class="table-light">
                            <tr>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Patient</th>
                                <th>Doctor</th>
                                <th>Type</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($appointments as $appointment)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($appointment->date)->format('M d, Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($appointment->time)->format('h:i A') }}</td>
                                <td>{{ $appointment->patient_first_name }} {{ $appointment->patient_last_name }}</td>
                                <td>Dr. {{ $appointment->doctor_first_name }} {{ $appointment->doctor_last_name }}</td>
                                <td>
                                    @if(property_exists($appointment, 'type') && $appointment->type == 'video')
                                        <span class="badge bg-info">Video Call</span>
                                    @elseif(property_exists($appointment, 'type'))
                                        <span class="badge bg-primary">In-Person</span>
                                    @else
                                        <span class="badge bg-secondary">N/A</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-{{ 
                                        $appointment->status === 'completed' ? 'success' : 
                                        ($appointment->status === 'cancelled' ? 'danger' : 
                                        ($appointment->status === 'confirmed' ? 'primary' : 'warning'))
                                    }}">
                                        {{ ucfirst($appointment->status) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.appointments.show', $appointment->id) }}" 
                                           class="btn btn-sm btn-outline-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.appointments.edit', $appointment->id) }}" 
                                           class="btn btn-sm btn-outline-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @if($appointment->status !== 'completed')
                                            <form action="{{ route('admin.appointments.delete', $appointment->id) }}" 
                                                  method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" 
                                                        onclick="return confirm('Are you sure you want to delete this appointment?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-center mt-3">
                    {{ $appointments->links() }}
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#appointmentsTable').DataTable({
                "order": [[0, "desc"], [1, "desc"]],
                "pageLength": 10,
                "language": {
                    "search": "Search appointments:",
                    "emptyTable": "No appointments found"
                }
            });
        });
    </script>
</body>
</html>
