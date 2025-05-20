<!DOCTYPE html>
<html>
<head>
    <title>Book Flight Mate - Medical Travel</title>
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
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .booking-form {
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            padding: 2rem;
            margin-bottom: 2rem;
        }

        .form-control:focus, .form-select:focus {
            border-color: #dd2476;
            box-shadow: 0 0 0 0.25rem rgba(221, 36, 118, 0.25);
        }

        .btn-book {
            background: linear-gradient(to right, #dd2476, #ff512f);
            border: none;
            color: white;
            padding: 0.8rem 2rem;
            border-radius: 25px;
            transition: all 0.3s;
        }

        .btn-book:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(221, 36, 118, 0.2);
        }

        .flight-mate-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            padding: 1.5rem;
        }

        .flight-mate-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: linear-gradient(135deg, #dd2476 0%, #ff512f 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
        }

        .detail-item {
            padding: 0.75rem;
            border-bottom: 1px solid #eee;
            display: flex;
            align-items: center;
        }

        .detail-item:last-child {
            border-bottom: none;
        }

        .detail-icon {
            width: 30px;
            color: #dd2476;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="text-white mb-0">
                    <i class="fas fa-calendar-check me-2"></i>Book Flight Mate
                </h2>
                <a href="{{ route('medical.travel.flightmate') }}" class="btn btn-outline-light">
                    <i class="fas fa-arrow-left me-2"></i>Back
                </a>
            </div>
        </div>
    </div>

    <div class="container mt-3">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    </div>

    <div class="container py-4">
        <div class="row g-4">
            <div class="col-md-8">
                <div class="booking-form">
                    <h4 class="mb-4">Booking Details</h4>
                    <form action="{{ route('medical.travel.flightmate.book.store', $flightMate->id) }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="form-label">When do you need assistance?</label>
                            <input type="date" name="booking_date" class="form-control" required min="{{ date('Y-m-d') }}">
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label">Start Time</label>
                                <input type="time" name="start_time" class="form-control" required>
                                <small class="text-muted">Service start time</small>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">End Time</label>
                                <input type="time" name="end_time" class="form-control" required>
                                <small class="text-muted">Expected end time</small>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Special Requirements or Notes</label>
                            <textarea name="notes" class="form-control" rows="3" 
                                placeholder="Please mention any specific requirements or additional information"></textarea>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-book">
                                <i class="fas fa-check-circle me-2"></i>Confirm Booking
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-md-4">
                <div class="flight-mate-card">
                    <div class="text-center mb-4">
                        <div class="flight-mate-avatar mx-auto">
                            <i class="fas fa-user fa-2x text-white"></i>
                        </div>
                        <h5 class="mb-1">{{ $flightMate->first_name }} {{ $flightMate->last_name }}</h5>
                        <span class="badge bg-primary">{{ str_replace('_', ' ', ucfirst($flightMate->service_type)) }}</span>
                    </div>

                    <div class="detail-item">
                        <span class="detail-icon"><i class="fas fa-language"></i></span>
                        <div>
                            <small class="text-muted d-block">Languages</small>
                            <strong>{{ $flightMate->languages }}</strong>
                        </div>
                    </div>

                    <div class="detail-item">
                        <span class="detail-icon"><i class="fas fa-star"></i></span>
                        <div>
                            <small class="text-muted d-block">Experience</small>
                            <strong>{{ $flightMate->experience }} years</strong>
                        </div>
                    </div>

                    <div class="detail-item">
                        <span class="detail-icon"><i class="fas fa-dollar-sign"></i></span>
                        <div>
                            <small class="text-muted d-block">Hourly Rate</small>
                            <strong>৳{{ number_format($flightMate->hourly_rate, 2) }}</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>