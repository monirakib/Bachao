<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hospitals Management - Admin Dashboard</title>
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

        .table th {
            background-color: #f8f9fa;
            font-weight: 600;
        }

        .btn-group {
            display: flex;
            gap: 5px;
        }

        .alert-success {
            border-left: 4px solid #198754;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <span class="navbar-brand">
                <i class="fas fa-hospital me-2"></i>Hospitals Management
            </span>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-light btn-sm">
                <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
            </a>
        </div>
    </nav>

    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3">Manage Hospitals</h1>
            <a href="{{ route('admin.hospitals.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Add New Hospital
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="hospitalsTable">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Address</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th width="120">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($hospitals as $hospital)
                                <tr>
                                    <td>{{ $hospital->name }}</td>
                                    <td>{{ $hospital->address }}</td>
                                    <td>{{ $hospital->phone }}</td>
                                    <td>{{ $hospital->email }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('admin.hospitals.edit', $hospital->id) }}" 
                                               class="btn btn-warning btn-sm" 
                                               title="Edit Hospital">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.hospitals.delete', $hospital->id) }}" 
                                                  method="POST" 
                                                  class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="btn btn-danger btn-sm" 
                                                        onclick="return confirm('Are you sure you want to delete this hospital?')"
                                                        title="Delete Hospital">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4">
                                        <i class="fas fa-hospital text-muted mb-2" style="font-size: 2rem;"></i>
                                        <p class="text-muted mb-0">No hospitals found</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <div class="d-flex justify-content-end mt-3">
                    {{ $hospitals->links() }}
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
            $('#hospitalsTable').DataTable({
                "order": [[0, "asc"]],
                "pageLength": 10,
                "language": {
                    "search": "Search hospitals:",
                    "emptyTable": "No hospitals found"
                }
            });
        });
    </script>
</body>
</html>

