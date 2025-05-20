@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col d-flex justify-content-between align-items-center">
            <div>
                <a href="{{ route('doctor.dashboard') }}" class="btn btn-outline-primary mb-3">
                    <i class="fas fa-arrow-left"></i> Back to Dashboard
                </a>
                <h2>Medical Records</h2>
            </div>
        </div>
    </div>

    <!-- Search Card -->
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('doctor.records.search') }}" method="POST" class="row g-3">
                @csrf
                <div class="col-md-8">
                    <input 
                        type="email" 
                        name="email" 
                        class="form-control @error('email') is-invalid @enderror" 
                        placeholder="Search by patient email"
                        value="{{ old('email') }}"
                    >
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search"></i> Search Records
                    </button>
                </div>
            </form>
        </div>
    </div>

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Search Results -->
    @if(isset($records))
        <div class="card mb-4">
            <div class="card-header bg-light">
                <h5 class="mb-0">Search Results for: {{ request('email') }}</h5>
            </div>
            <div class="card-body">
                @if($records->count() > 0)
                    @foreach($records as $record)
                        <div class="card mb-3">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-0">{{ $record->patient_first_name }} {{ $record->patient_last_name }}</h6>
                                    <small class="text-muted">{{ $record->patient_email }}</small>
                                </div>
                                <div class="text-muted">
                                    <i class="far fa-calendar-alt"></i>
                                    {{ \Carbon\Carbon::parse($record->created_at)->format('F j, Y') }}
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <strong>Record Type</strong>
                                        <p class="mb-0">{{ $record->record_type }}</p>
                                    </div>
                                    <div class="col-md-9">
                                        <strong>Description</strong>
                                        <p class="mb-0">{!! nl2br(e($record->description)) !!}</p>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <strong>Diagnosis</strong>
                                        <p class="mb-0">{!! nl2br(e($record->diagnosis)) !!}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <strong>Treatment</strong>
                                        <p class="mb-0">{!! nl2br(e($record->treatment)) !!}</p>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <span class="badge bg-{{ $record->status === 'completed' ? 'success' : 'primary' }}">
                                        {{ ucfirst($record->status) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="text-center py-5">
                        <i class="far fa-folder-open fa-3x text-muted mb-3"></i>
                        <p class="text-muted">No records found for this patient.</p>
                    </div>
                @endif
            </div>
        </div>
    @endif

    <!-- All Records -->
    <div class="card">
        <div class="card-header bg-light">
            <h5 class="mb-0">All Patient Records</h5>
        </div>
        <div class="card-body">
            @if($allRecords->count() > 0)
                @foreach($allRecords as $record)
                    <div class="card mb-3">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-0">{{ $record->patient_first_name }} {{ $record->patient_last_name }}</h6>
                                <small class="text-muted">{{ $record->patient_email }}</small>
                            </div>
                            <div class="text-muted">
                                <i class="far fa-calendar-alt"></i>
                                {{ \Carbon\Carbon::parse($record->created_at)->format('F j, Y') }}
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <strong>Record Type</strong>
                                    <p class="mb-0">{{ $record->record_type }}</p>
                                </div>
                                <div class="col-md-9">
                                    <strong>Description</strong>
                                    <p class="mb-0">{!! nl2br(e($record->description)) !!}</p>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <strong>Diagnosis</strong>
                                    <p class="mb-0">{!! nl2br(e($record->diagnosis)) !!}</p>
                                </div>
                                <div class="col-md-6">
                                    <strong>Treatment</strong>
                                    <p class="mb-0">{!! nl2br(e($record->treatment)) !!}</p>
                                </div>
                            </div>
                            <div class="mt-3">
                                <span class="badge bg-{{ $record->status === 'completed' ? 'success' : 'primary' }}">
                                    {{ ucfirst($record->status) }}
                                </span>
                            </div>
                        </div>
                    </div>
                @endforeach

                <div class="d-flex justify-content-center mt-4">
                    {{ $allRecords->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="far fa-folder-open fa-3x text-muted mb-3"></i>
                    <p class="text-muted">No medical records found.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .card-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid rgba(0,0,0,.125);
    }
    
    .badge {
        font-size: 0.875rem;
        padding: 0.5em 1em;
    }

    .card {
        box-shadow: 0 1px 3px rgba(0,0,0,.1);
    }
</style>
@endpush