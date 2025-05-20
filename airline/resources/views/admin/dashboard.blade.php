@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">Dashboard Overview</h2>
    
    <div class="row">
        <div class="col-md-3">
            <div class="stats-card">
                <h4>Total Users</h4>
                <p class="h2">{{ $stats['total_users'] }}</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card">
                <h4>Total Flights</h4>
                <p class="h2">{{ $stats['total_flights'] }}</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card">
                <h4>Total Bookings</h4>
                <p class="h2">{{ $stats['total_bookings'] }}</p>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5>Recent Bookings</h5>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>User</th>
                                <th>Flight</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($stats['recent_bookings'] as $booking)
                            <tr>
                                <td>{{ $booking->id }}</td>
                                <td>{{ $booking->user->name }}</td>
                                <td>{{ $booking->flight->Flight_ID }}</td>
                                <td>৳{{ number_format($booking->total_amount, 2) }}</td>
                                <td>{{ $booking->status }}</td>
                                <td>{{ $booking->created_at->format('M d, Y') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection