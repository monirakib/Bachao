<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
        }

        .navbar {
            background: linear-gradient(to right, #dd2476, #ff512f);
            padding: 1rem 0;
            margin-bottom: 2rem;
        }

        .navbar-brand {
            color: white;
            font-weight: 600;
            font-size: 1.5rem;
        }

        .gradient-bg {
            background: linear-gradient(to right, #dd2476, #ff512f);
        }

        .hotel-info {
            background: #f8f9fa;
            padding: 1.5rem;
            border-radius: 8px;
        }

        .hotel-name {
            color: #2d3436;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .location {
            color: #636e72;
        }

        .form-label {
            color: #2d3436;
            font-weight: 500;
            font-size: 0.9rem;
        }

        .detail-text {
            font-size: 1.1rem;
            margin-bottom: 0;
        }

        .requirements {
            background: #fff3f7;
            padding: 1rem;
            border-radius: 8px;
            border-left: 4px solid #dd2476;
        }

        .price-section {
            background: #fff3f7;
            padding: 1.5rem;
            border-radius: 8px;
            text-align: center;
        }

        .price-text {
            color: #dd2476;
            font-weight: 600;
            font-size: 2rem;
        }

        .btn-light {
            border: 2px solid white;
        }

        .btn-light:hover {
            background: rgba(255,255,255,0.9);
            transform: translateY(-1px);
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <span class="navbar-brand">
                <i class="fas fa-hotel me-2"></i>Booking Details
            </span>
        </div>
    </nav>

    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <!-- Card Header -->
                    <div class="card-header gradient-bg">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="mb-0 text-white">Booking Details</h4>
                            <a href="{{ route('hotels.index') }}" class="btn btn-light btn-sm">
                                <i class="fas fa-arrow-left"></i> Back to Hotels
                            </a>
                        </div>
                    </div>

                    <!-- Card Body -->
                    <div class="card-body p-4">
                        <!-- Hotel Info -->
                        <div class="hotel-info mb-4">
                            <h5 class="hotel-name">{{ $booking->hotel->name }}</h5>
                            <p class="location mb-2">
                                <i class="fas fa-map-marker-alt me-2"></i>
                                {{ $booking->hotel->location }}
                            </p>
                            <div class="badges">
                                @if($booking->hotel->has_medical_facilities)
                                    <span class="badge bg-success me-2">
                                        <i class="fas fa-medkit me-1"></i>Medical Facilities
                                    </span>
                                @endif
                                @if($booking->hotel->wheelchair_accessible)
                                    <span class="badge bg-info">
                                        <i class="fas fa-wheelchair me-1"></i>Wheelchair Access
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Booking Info -->
                        <div class="booking-details">
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label class="form-label">Check-in Date</label>
                                    <p class="detail-text">{{ $booking->check_in->format('M d, Y') }}</p>
                                </div>
                                
                                <div class="col-md-6">
                                    <label class="form-label">Check-out Date</label>
                                    <p class="detail-text">{{ $booking->check_out->format('M d, Y') }}</p>
                                </div>

                                <div class="col-12">
                                    <label class="form-label">Number of Guests</label>
                                    <p class="detail-text">
                                        {{ $booking->guests }} {{ Str::plural('Guest', $booking->guests) }}
                                    </p>
                                </div>

                                @if($booking->requirements)
                                    <div class="col-12">
                                        <label class="form-label">Special Requirements</label>
                                        <p class="detail-text requirements">{{ $booking->requirements }}</p>
                                    </div>
                                @endif

                                <div class="col-12">
                                    <div class="price-section">
                                        <label class="form-label">Total Price</label>
                                        <h3 class="price-text mb-1">৳{{ number_format($booking->total_price, 2) }}</h3>
                                        <small class="text-muted">
                                            For {{ $booking->check_in->diffInDays($booking->check_out) }} nights
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>