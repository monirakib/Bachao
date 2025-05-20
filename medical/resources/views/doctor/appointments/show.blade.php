@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col">
            <h2>Appointment Details</h2>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h4>Patient Information</h4>
                    <p><strong>Name:</strong> {{ $appointment->user->first_name }} {{ $appointment->user->last_name }}</p>
                    <p><strong>Email:</strong> {{ $appointment->user->email }}</p>
                    <p><strong>Phone:</strong> {{ $appointment->user->phone }}</p>
                </div>
                <div class="col-md-6">
                    <h4>Appointment Information</h4>
                    <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($appointment->date)->format('M d, Y') }}</p>
                    <p><strong>Time:</strong> {{ \Carbon\Carbon::parse($appointment->time)->format('h:i A') }}</p>
                    <p><strong>Type:</strong> {{ ucfirst($appointment->appointment_type) }}</p>
                    <p><strong>Reason:</strong> {{ $appointment->reason }}</p>
                    <p><strong>Status:</strong> 
                        <span class="badge bg-{{ $appointment->status === 'completed' ? 'success' : ($appointment->status === 'cancelled' ? 'danger' : 'primary') }}">
                            {{ ucfirst($appointment->status) }}
                        </span>
                    </p>
                </div>
            </div>

            <div class="mt-4">
                <form action="{{ route('doctor.appointments.update', $appointment->id) }}" method="POST" class="d-inline">
                    @csrf
                    <select name="status" class="form-select d-inline-block w-auto">
                        <option value="scheduled" {{ $appointment->status === 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                        <option value="completed" {{ $appointment->status === 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ $appointment->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                    <button type="submit" class="btn btn-primary ms-2">Update Status</button>
                </form>
                
                <a href="{{ route('doctor.prescriptions.create', $appointment->id) }}" class="btn btn-success ms-2">
                    <i class="fas fa-prescription"></i> Add Prescription
                </a>
            </div>
        </div>
    </div>
</div>
@endsection