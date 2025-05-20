@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col">
            <a href="{{ route('doctor.appointments.show', $appointment->id) }}" class="btn btn-outline-primary mb-3">
                <i class="fas fa-arrow-left"></i> Back to Appointment
            </a>
            <h2>Add Prescription</h2>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-6">
                    <h4>Patient Information</h4>
                    <p><strong>Name:</strong> {{ $appointment->first_name }} {{ $appointment->last_name }}</p>
                    <p><strong>Email:</strong> {{ $appointment->email }}</p>
                </div>
            </div>

            @if($existingRecord)
                <div class="alert alert-info">
                    <h5>Previous Medical Record</h5>
                    <p><strong>Description:</strong> {{ $existingRecord->description }}</p>
                    <p><strong>Diagnosis:</strong> {{ $existingRecord->diagnosis }}</p>
                    <p><strong>Treatment:</strong> {{ $existingRecord->treatment }}</p>
                    @if($existingRecord->next_appointment)
                        <p><strong>Next Appointment:</strong> After {{ $existingRecord->next_appointment }} days</p>
                    @endif
                </div>
            @endif

            <form action="{{ route('doctor.prescriptions.store', $appointment->id) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="diagnosis" class="form-label">Diagnosis</label>
                    <textarea class="form-control @error('diagnosis') is-invalid @enderror" 
                              id="diagnosis" 
                              name="diagnosis" 
                              rows="3">{{ old('diagnosis') }}</textarea>
                    @error('diagnosis')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" 
                              id="description" 
                              name="description" 
                              rows="3">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="treatment" class="form-label">Treatment</label>
                    <textarea class="form-control @error('treatment') is-invalid @enderror" 
                              id="treatment" 
                              name="treatment" 
                              rows="3">{{ old('treatment') }}</textarea>
                    @error('treatment')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="next_appointment_days" class="form-label">Schedule Next Appointment After (Days)</label>
                    <input type="number" 
                           class="form-control @error('next_appointment_days') is-invalid @enderror"
                           id="next_appointment_days" 
                           name="next_appointment_days"
                           min="1"
                           max="365"
                           value="{{ old('next_appointment_days') }}">
                    @error('next_appointment_days')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Save Medical Record</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection