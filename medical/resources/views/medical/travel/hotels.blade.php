<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medical-Friendly Hotels</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
        }

        .hotel-card {
            transition: transform 0.2s;
            border: none;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .hotel-card:hover {
            transform: translateY(-5px);
        }

        .hotel-image {
            height: 200px;
            object-fit: cover;
        }

        .search-form {
            background: white;
            padding: 1.5rem;
            border-radius: 8px;
            margin-bottom: 2rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .location {
            color: #6c757d;
            font-size: 0.9rem;
        }

        .price {
            font-size: 1.2rem;
            font-weight: 600;
            color: #2c3e50;
        }

        .badges {
            min-height: 24px;
        }

        .btn-primary {
            background: linear-gradient(to right, #dd2476, #ff512f);
            border: none;
        }

        .btn-primary:hover {
            background: linear-gradient(to right, #c72167, #e54a2a);
            transform: translateY(-1px);
        }

        .btn-outline-secondary {
            border-color: #dd2476;
            color: #dd2476;
        }

        .btn-outline-secondary:hover {
            background: linear-gradient(to right, #dd2476, #ff512f);
            border-color: transparent;
            color: white;
            transform: translateY(-1px);
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

        .navbar-brand:hover {
            color: rgba(255,255,255,0.9);
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-hotel me-2"></i>Medical-Friendly Hotels
            </a>
        </div>
    </nav>

    <div class="container py-4">
        <!-- Back Button -->
        <div class="mb-4">
            <a href="{{ route('medical.travel.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Back to Medical Travel
            </a>
        </div>

        <!-- Search Form -->
        <div class="search-form">
            <h4 class="mb-4">Find Medical-Friendly Hotels</h4>
            <form action="{{ route('hotels.search') }}" method="GET" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Location</label>
                    <input type="text" name="location" class="form-control" 
                        value="{{ request('location') }}" placeholder="Enter city">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Price Range (per night)</label>
                    <div class="input-group">
                        <input type="number" name="min_price" class="form-control" 
                            value="{{ request('min_price') }}" placeholder="Min">
                        <input type="number" name="max_price" class="form-control" 
                            value="{{ request('max_price') }}" placeholder="Max">
                    </div>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Facilities</label>
                    <div class="d-flex gap-3">
                        <div class="form-check">
                            <input type="checkbox" name="medical_facilities" 
                                class="form-check-input" id="medical"
                                {{ request('medical_facilities') ? 'checked' : '' }}>
                            <label class="form-check-label" for="medical">Medical Facilities</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" name="wheelchair_accessible" 
                                class="form-check-input" id="wheelchair"
                                {{ request('wheelchair_accessible') ? 'checked' : '' }}>
                            <label class="form-check-label" for="wheelchair">Wheelchair Access</label>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search me-2"></i>Search Hotels
                    </button>
                </div>
            </form>
        </div>

        <!-- Hotel Listings -->
        <div class="row g-4">
            @forelse($hotels as $hotel)
                <div class="col-md-4">
                    <div class="card hotel-card h-100">
                        <img src="{{ $hotel->image_url }}" class="hotel-image card-img-top" 
                            alt="{{ $hotel->name }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $hotel->name }}</h5>
                            <p class="location">
                                <i class="fas fa-map-marker-alt me-2"></i>{{ $hotel->location }}
                            </p>
                            <div class="badges mb-3">
                                @if($hotel->has_medical_facilities)
                                    <span class="badge bg-success">
                                        <i class="fas fa-medkit me-1"></i>Medical Facilities
                                    </span>
                                @endif
                                @if($hotel->wheelchair_accessible)
                                    <span class="badge bg-info ms-2">
                                        <i class="fas fa-wheelchair me-1"></i>Wheelchair Access
                                    </span>
                                @endif
                            </div>
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <div class="price">৳{{ number_format($hotel->price_per_night, 2) }}/night</div>
                                <div class="rating">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star {{ $i <= $hotel->rating ? 'text-warning' : 'text-muted' }}"></i>
                                    @endfor
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-white border-0 pb-3">
                            <a href="{{ route('hotels.book', $hotel->id) }}" class="btn btn-primary w-100">
                                <i class="fas fa-calendar-check me-2"></i>Book Now
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>No hotels found matching your criteria.
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>