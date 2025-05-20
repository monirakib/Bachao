@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col">
            <h2>Patient Details</h2>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h4>Personal Information</h4>
                    <p><strong>Name:</strong> {{ $user->first_name }} {{ $user->last_name }}</p>
                    <p><strong>Gender:</strong> {{ ucfirst($user->gender) }}</p>
                    <p><strong>Email:</strong> {{ $user->email }}</p>
                    <p><strong>Phone:</strong> {{ $user->phone }}</p>
                    <p><strong>Date of Birth:</strong> {{ $user->date_of_birth }}</p>
                    <p><strong>Address:</strong> {{ $user->address }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h4>Appointment History</h4>
            <table class="table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Type</th>
                        <th>Reason</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($appointments as $appointment)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($appointment->date)->format('M d, Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($appointment->time)->format('h:i A') }}</td>
                            <td>{{ ucfirst($appointment->appointment_type) }}</td>
                            <td>{{ $appointment->reason }}</td>
                            <td>
                                <span class="badge bg-{{ $appointment->status === 'completed' ? 'success' : ($appointment->status === 'cancelled' ? 'danger' : 'primary') }}">
                                    {{ ucfirst($appointment->status) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">No appointment history found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection