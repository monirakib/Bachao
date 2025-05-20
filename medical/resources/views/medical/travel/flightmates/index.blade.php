<!DOCTYPE html>
<html>
<head>
    <title>Flight Mates - Medical Travel</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css2?family=Murecho:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Murecho', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
        }

        .header {
            background: linear-gradient(to right, #dd2476, #ff512f);
            padding: 1.5rem 0;
            margin-bottom: 2rem;
        }

        .flight-mate-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s;
            border: none;
        }

        .flight-mate-card:hover {
            transform: translateY(-5px);
        }

        .service-badge {
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.85rem;
            background: rgba(221, 36, 118, 0.1);
            color: #dd2476;
        }

        .btn-book {
            background: linear-gradient(to right, #dd2476, #ff512f);
            border: none;
            color: white;
            padding: 0.8rem 2rem;
            border-radius: 25px;
        }

        .btn-register {
            background: white;
            border: 2px solid #dd2476;
            color: #dd2476;
            padding: 0.8rem 2rem;
            border-radius: 25px;
            transition: all 0.3s;
        }

        .btn-register:hover {
            background: linear-gradient(to right, #dd2476, #ff512f);
            color: white;
            border-color: transparent;
        }

        .modal-content {
            border-radius: 15px;
            border: none;
        }

        .modal-header {
            background: linear-gradient(to right, #dd2476, #ff512f);
            color: white;
            border-radius: 15px 15px 0 0;
        }

        .btn-close {
            filter: brightness(0) invert(1);
        }

        .list-group-item {
            border-left: none;
            border-right: none;
            padding: 1rem;
        }

        .list-group-item:first-child {
            border-top: none;
        }

        .list-group-item:last-child {
            border-bottom: none;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="text-white mb-0">
                    <i class="fas fa-user-friends me-2"></i>Flight Mates
                </h2>
                <div>
                    <a href="{{ route('medical.travel.index') }}" class="btn btn-outline-light me-2">
                        <i class="fas fa-arrow-left me-2"></i>Back
                    </a>
                    <a href="{{ route('medical.travel.flightmate.register') }}" class="btn btn-register">
                        <i class="fas fa-plus me-2"></i>Register as Flight Mate
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0">Available Flight Mates</h4>
            <div>
                @if($isFlightMate)
                    <button type="button" class="btn btn-info me-2" data-bs-toggle="modal" data-bs-target="#receivedBookingsModal">
                        <i class="fas fa-inbox me-2"></i>Bookings Received
                    </button>
                @endif
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#bookingsModal">
                    <i class="fas fa-calendar me-2"></i>My Bookings
                </button>
            </div>
        </div>

        <div class="row g-4">
            @forelse($flightMates as $mate)
                <div class="col-md-6 col-lg-4">
                    <div class="flight-mate-card p-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="flex-shrink-0">
                                <div class="rounded-circle bg-light p-3">
                                    <i class="fas fa-user fa-2x text-primary"></i>
                                </div>
                            </div>
                            <div class="ms-3">
                                <h5 class="mb-1">
                                    {{ $mate->first_name }} {{ $mate->last_name }}
                                </h5>
                                <span class="service-badge">{{ str_replace('_', ' ', ucfirst($mate->service_type)) }}</span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <p class="mb-2"><i class="fas fa-language me-2"></i>{{ $mate->languages }}</p>
                            <p class="mb-2"><i class="fas fa-star me-2"></i>{{ $mate->experience }} years experience</p>
                            <p class="mb-0"><i class="fas fa-dollar-sign me-2"></i>{{ number_format($mate->hourly_rate, 2) }}/hour</p>
                        </div>
                        <!-- Replace the Book Now button -->
                        <div class="d-grid">
                            <a href="{{ route('medical.travel.flightmate.book', $mate->id) }}" class="btn btn-book">
                                <i class="fas fa-calendar-check me-2"></i>Book Now
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info">
                        No flight mates available at the moment. Why not <a href="{{ route('medical.travel.flightmate.register') }}" class="alert-link">register as one</a>?
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    <!-- My Bookings Modal -->
    <div class="modal fade" id="bookingsModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-calendar-check me-2"></i>My Flight Mate Bookings
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    @if($myBookings->isEmpty())
                        <div class="text-center py-5">
                            <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                            <p class="mb-0">You haven't booked any flight mates yet.</p>
                        </div>
                    @else
                        <div class="list-group">
                            @foreach($myBookings as $booking)
                                <div class="list-group-item">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-1">{{ $booking->first_name }} {{ $booking->last_name }}</h6>
                                            <p class="mb-1 text-muted">
                                                <i class="fas fa-user-tag me-2"></i>
                                                {{ str_replace('_', ' ', ucfirst($booking->service_type)) }}
                                            </p>
                                            <p class="mb-1">
                                                <i class="fas fa-calendar me-2"></i>
                                                {{ \Carbon\Carbon::parse($booking->booking_date)->format('F j, Y') }}
                                            </p>
                                            <p class="mb-0">
                                                <i class="fas fa-clock me-2"></i>
                                                {{ \Carbon\Carbon::parse($booking->start_time)->format('g:i A') }} - 
                                                {{ \Carbon\Carbon::parse($booking->end_time)->format('g:i A') }}
                                            </p>
                                        </div>
                                        <div class="text-end">
                                            <span class="badge bg-{{ $booking->status === 'confirmed' ? 'success' : 
                                                ($booking->status === 'pending' ? 'warning' : 
                                                ($booking->status === 'cancelled' ? 'danger' : 'primary')) }} mb-2">
                                                {{ ucfirst($booking->status) }}
                                            </span>
                                            <div class="text-muted small">
                                                Total: ৳{{ number_format($booking->total_amount, 2) }}
                                            </div>
                                        </div>
                                    </div>
                                    @if($booking->notes)
                                        <div class="mt-2 small text-muted">
                                            <i class="fas fa-sticky-note me-2"></i>{{ $booking->notes }}
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    @if($isFlightMate)
    <!-- Received Bookings Modal -->
    <div class="modal fade" id="receivedBookingsModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-inbox me-2"></i>Bookings Received
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    @if($receivedBookings->isEmpty())
                        <div class="text-center py-5">
                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                            <p class="mb-0">No bookings received yet.</p>
                        </div>
                    @else
                        <div class="list-group">
                            @foreach($receivedBookings as $booking)
                                <div class="list-group-item" id="booking-{{ $booking->id }}">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-1">From: {{ $booking->first_name }} {{ $booking->last_name }}</h6>
                                            <p class="mb-1">
                                                <i class="fas fa-calendar me-2"></i>
                                                {{ \Carbon\Carbon::parse($booking->booking_date)->format('F j, Y') }}
                                            </p>
                                            <p class="mb-0">
                                                <i class="fas fa-clock me-2"></i>
                                                {{ \Carbon\Carbon::parse($booking->start_time)->format('g:i A') }} - 
                                                {{ \Carbon\Carbon::parse($booking->end_time)->format('g:i A') }}
                                            </p>
                                        </div>
                                        <div class="text-end">
                                            <div class="status-badge mb-2">
                                                <span class="badge bg-{{ $booking->status === 'confirmed' ? 'success' : 
                                                    ($booking->status === 'pending' ? 'warning' : 
                                                    ($booking->status === 'cancelled' ? 'danger' : 'primary')) }}">
                                                    {{ ucfirst($booking->status) }}
                                                </span>
                                            </div>
                                            @if($booking->status === 'pending')
                                                <div class="btn-group btn-group-sm">
                                                    <button type="button" class="btn btn-success btn-accept" 
                                                        data-booking-id="{{ $booking->id }}">
                                                        <i class="fas fa-check me-1"></i>Accept
                                                    </button>
                                                    <button type="button" class="btn btn-danger btn-reject" 
                                                        data-booking-id="{{ $booking->id }}">
                                                        <i class="fas fa-times me-1"></i>Reject
                                                    </button>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    @if($booking->notes)
                                        <div class="mt-2 small text-muted">
                                            <i class="fas fa-sticky-note me-2"></i>{{ $booking->notes }}
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Add this before the closing body tag -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const updateBookingStatus = async (bookingId, status) => {
            try {
                const response = await fetch(`/medical/travel/flightmate/booking/${bookingId}/status`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ status })
                });

                if (!response.ok) throw new Error('Failed to update status');

                const booking = document.getElementById(`booking-${bookingId}`);
                const statusBadge = booking.querySelector('.status-badge');
                const actionButtons = booking.querySelector('.btn-group');

                statusBadge.innerHTML = `<span class="badge bg-${status === 'confirmed' ? 'success' : 'danger'}">
                    ${status === 'confirmed' ? 'Confirmed' : 'Cancelled'}</span>`;
                actionButtons.remove();

            } catch (error) {
                alert('Failed to update booking status. Please try again.');
            }
        };

        document.querySelectorAll('.btn-accept').forEach(button => {
            button.addEventListener('click', () => {
                updateBookingStatus(button.dataset.bookingId, 'confirmed');
            });
        });

        document.querySelectorAll('.btn-reject').forEach(button => {
            button.addEventListener('click', () => {
                if (confirm('Are you sure you want to reject this booking?')) {
                    updateBookingStatus(button.dataset.bookingId, 'cancelled');
                }
            });
        });
    });
    </script>
    @endif

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>