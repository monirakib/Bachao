@extends('layouts.app')

@section('content')
<style>
    .appointments-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 20px;
        padding: 20px;
    }

    .appointment-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        padding: 20px;
        transition: all 0.3s ease;
    }

    .appointment-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.12);
    }

    .patient-info {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 15px;
        padding-bottom: 15px;
        border-bottom: 1px solid #eee;
    }

    .patient-avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        object-fit: cover;
    }

    .patient-details h3 {
        margin: 0;
        font-size: 1.1em;
        color: #2c3e50;
    }

    .patient-details p {
        margin: 5px 0 0;
        font-size: 0.9em;
        color: #666;
    }

    .appointment-details {
        margin-bottom: 20px;
    }

    .detail-row {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 8px;
        color: #2c3e50;
    }

    .detail-row i {
        width: 20px;
        color: #dd2476;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 0.9em;
    }

    .status-scheduled {
        background: #e8f7ff;
        color: #0288d1;
    }

    .status-ongoing {
        background: #edf7ed;
        color: #2e7d32;
    }

    .status-completed {
        background: #f5f5f5;
        color: #757575;
    }

    .action-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        width: 100%;
        padding: 12px;
        border: none;
        border-radius: 8px;
        background: #dd2476;
        color: white;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .action-button:hover {
        background: #c81f68;
        transform: translateY(-2px);
    }

    .action-button:disabled {
        background: #e0e0e0;
        cursor: not-allowed;
        transform: none;
    }

    .page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 20px;
        background: white;
        border-radius: 15px;
        margin-bottom: 20px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }

    .page-title {
        margin: 0;
        font-size: 1.5em;
        color: #2c3e50;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .page-title i {
        color: #dd2476;
    }

    .empty-state {
        text-align: center;
        padding: 40px 20px;
        background: white;
        border-radius: 15px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    }

    .empty-state i {
        font-size: 3em;
        color: #dd2476;
        margin-bottom: 20px;
    }

    .empty-state h2 {
        margin: 0 0 10px;
        color: #2c3e50;
    }

    .empty-state p {
        margin: 0;
        color: #666;
    }
</style>

<div class="container-fluid px-4">
    <div class="page-header">
        <h1 class="page-title">
            <i class="fas fa-video"></i>
            Online Consultations
        </h1>
    </div>

    @if($onlineAppointments->isEmpty())
        <div class="empty-state">
            <i class="fas fa-video-slash"></i>
            <h2>No Online Consultations</h2>
            <p>You don't have any online consultations scheduled.</p>
        </div>
    @else
        <div class="appointments-grid">
            @foreach($onlineAppointments as $appointment)
                <div class="appointment-card">
                    <div class="patient-info">
                        <img src="{{ asset('pics/guest-removebg-preview.png') }}" alt="Patient" class="patient-avatar">
                        <div class="patient-details">
                            <h3>{{ $appointment->first_name }} {{ $appointment->last_name }}</h3>
                            <p>{{ $appointment->email }}</p>
                        </div>
                    </div>

                    <div class="appointment-details">
                        <div class="detail-row">
                            <i class="far fa-calendar"></i>
                            <span>{{ \Carbon\Carbon::parse($appointment->date)->format('M d, Y') }}</span>
                        </div>
                        <div class="detail-row">
                            <i class="far fa-clock"></i>
                            <span>{{ \Carbon\Carbon::parse($appointment->time)->format('h:i A') }}</span>
                        </div>
                        <div class="detail-row">
                            <i class="fas fa-tag"></i>
                            <span class="status-badge status-{{ $appointment->status }}">
                                <i class="fas fa-{{ $appointment->status === 'scheduled' ? 'calendar-check' : ($appointment->status === 'ongoing' ? 'video' : 'check-circle') }}"></i>
                                {{ ucfirst($appointment->status) }}
                            </span>
                        </div>
                    </div>

                    @if($appointment->status !== 'completed')
                        <a href="{{ route('doctor.telemedicine.show', $appointment->id) }}" class="action-button">
                            <i class="fas fa-video"></i>
                            {{ $appointment->status === 'ongoing' ? 'Join Consultation' : 'View Details' }}
                        </a>
                    @else
                        <button class="action-button" disabled>
                            <i class="fas fa-check-circle"></i>
                            Consultation Completed
                        </button>
                    @endif
                </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $onlineAppointments->links() }}
        </div>
    @endif
</div>
@endsection