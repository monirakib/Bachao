<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Hotel - {{ $hotel->name }}</title>
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

        .hotel-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .header {
            background: linear-gradient(to right, #dd2476, #ff512f);
            padding: 20px;
            color: white;
            border-radius: 10px 10px 0 0;
        }

        .price {
            font-size: 24px;
            color: #dd2476;
            font-weight: bold;
        }

        .btn-primary {
            background: linear-gradient(to right, #dd2476, #ff512f);
            border: none;
        }

        .btn-primary:hover {
            background: linear-gradient(to right, #c72167, #e54a2a);
            transform: translateY(-1px);
        }

        .btn-light {
            border: 2px solid white;
        }

        .btn-light:hover {
            background: rgba(255,255,255,0.9);
            transform: translateY(-1px);
        }

        .form-control:focus, .form-select:focus {
            border-color: #dd2476;
            box-shadow: 0 0 0 0.25rem rgba(221, 36, 118, 0.25);
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <span class="navbar-brand">
                <i class="fas fa-hotel me-2"></i>Hotel Booking
            </span>
        </div>
    </nav>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="hotel-card">
                    <div class="header d-flex justify-content-between align-items-center">
                        <h3 class="mb-0">{{ $hotel->name }}</h3>
                        <a href="{{ route('hotels.index') }}" class="btn btn-light btn-sm">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                    
                    <div class="card-body p-4">
                        @if($errors->any())
                            <div class="alert alert-danger mb-4">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- Hotel Info -->
                        <div class="mb-4">
                            <p><i class="fas fa-map-marker-alt me-2"></i>{{ $hotel->location }}</p>
                            <p class="price mb-2">৳{{ number_format($hotel->price_per_night, 2) }} <small>/night</small></p>
                            @if($hotel->has_medical_facilities)
                                <span class="badge bg-success me-2">Medical Facilities</span>
                            @endif
                            @if($hotel->wheelchair_accessible)
                                <span class="badge bg-info">Wheelchair Access</span>
                            @endif
                        </div>

                        <!-- Booking Form -->
                        <form action="{{ route('hotels.book.store', $hotel->id) }}" method="POST">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Check-in Date</label>
                                    <input type="date" name="check_in" class="form-control" 
                                        value="{{ old('check_in') }}"
                                        min="{{ date('Y-m-d') }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Check-out Date</label>
                                    <input type="date" name="check_out" class="form-control" 
                                        value="{{ old('check_out') }}"
                                        min="{{ date('Y-m-d', strtotime('+1 day')) }}" required>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Number of Guests</label>
                                    <select name="guests" class="form-select">
                                        @for($i = 1; $i <= 4; $i++)
                                            <option value="{{ $i }}" {{ old('guests') == $i ? 'selected' : '' }}>
                                                {{ $i }} {{ Str::plural('Guest', $i) }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Special Requirements</label>
                                    <textarea name="requirements" class="form-control" rows="3" 
                                        placeholder="Any medical requirements or special assistance needed?">{{ old('requirements') }}</textarea>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary w-100">
                                        <i class="fas fa-check me-2"></i>Confirm Booking
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>