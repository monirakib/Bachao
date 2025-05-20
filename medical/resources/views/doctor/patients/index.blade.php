@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col">
            <h2>My Patients</h2>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Gender</th>
                        <th>Contact</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($patients as $patient)
                        <tr>
                            <td>{{ $patient->first_name }} {{ $patient->last_name }}</td>
                            <td>{{ ucfirst($patient->gender) }}</td>
                            <td>
                                <div>{{ $patient->email }}</div>
                                <small class="text-muted">{{ $patient->phone }}</small>
                            </td>
                            <td>
                                <a href="{{ route('doctor.patients.show', $patient->user_id) }}" 
                                   class="btn btn-sm btn-primary">
                                    View Details
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">No patients found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="d-flex justify-content-center mt-4">
                {{ $patients->links() }}
            </div>
        </div>
    </div>
</div>
@endsection