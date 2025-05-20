@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col">
            <h2>Medical Record Details</h2>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('doctor.records.store', $appointment->id) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Patient Name</label>
                    <p class="form-control-static">{{ $appointment->user->first_name }} {{ $appointment->user->last_name }}</p>
                </div>

                <div class="mb-3">
                    <label class="form-label">Visit Date</label>
                    <p class="form-control-static">{{ \Carbon\Carbon::parse($appointment->date)->format('M d, Y') }}</p>
                </div>

                <div class="mb-3">
                    <label for="diagnosis" class="form-label">Diagnosis</label>
                    <textarea class="form-control @error('diagnosis') is-invalid @enderror" 
                              id="diagnosis" 
                              name="diagnosis" 
                              rows="3">{{ old('diagnosis', $appointment->diagnosis) }}</textarea>
                    @error('diagnosis')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="prescription" class="form-label">Prescription</label>
                    <textarea class="form-control @error('prescription') is-invalid @enderror" 
                              id="prescription" 
                              name="prescription" 
                              rows="3">{{ old('prescription', $appointment->prescription) }}</textarea>
                    @error('prescription')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="notes" class="form-label">Additional Notes</label>
                    <textarea class="form-control @error('notes') is-invalid @enderror" 
                              id="notes" 
                              name="notes" 
                              rows="3">{{ old('notes', $appointment->notes) }}</textarea>
                    @error('notes')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Save Record</button>
            </form>
        </div>
    </div>
</div>
@endsection