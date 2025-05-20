<!DOCTYPE html>
<html>
<head>
    <title>Medical Travel Services</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter+Tight:ital,wght@0,100..900;1,100..900&family=Murecho:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Murecho', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
        }

        .header {
            background: linear-gradient(to right, #dd2476, #ff512f);
            padding: 1.5rem 0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .logo img {
            height: 70px;
            width: 100px;
        }

        .main-content {
            padding: 2rem 0;
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            transition: transform 0.2s;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .input-group-text {
            background-color: #f8f9fa;
            border: 1px solid #ced4da;
        }

        .btn-primary {
            background: linear-gradient(to right, #dd2476, #ff512f);
            border: none;
            padding: 0.8rem 2rem;
        }

        .btn-outline-primary {
            border: 2px solid #dd2476;
            color: #dd2476;
            font-weight: 500;
        }

        .btn-outline-primary:hover {
            background: linear-gradient(to right, #dd2476, #ff512f);
            border-color: transparent;
            color: white;
        }

        .travel-tips li {
            padding: 0.5rem 0;
            border-bottom: 1px solid #eee;
        }

        .travel-tips li:last-child {
            border-bottom: none;
        }

        @media (max-width: 768px) {
            .header {
                text-align: center;
            }
            
            .btn-primary {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header text-white mb-4">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <div class="logo">
                    <img src="{{ asset('pics/medical/medichain_logo.png') }}" alt="Logo">
                </div>
                <div>
                    <a href="{{ route('doctor.dashboard') }}" class="btn btn-outline-light">
                        <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="container">
            <div class="row">
                <!-- Trip Planning Section -->
                <div class="col-md-8">
                    <div class="card mb-4">
                        <div class="card-body p-4">
                            <h3 class="mb-4">Plan Your Medical Trip</h3>
                            <form action="{{ route('medical.travel.search') }}" method="POST" class="row g-3">
                                @csrf
                                <div class="col-md-6">
                                    <label class="form-label">From</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-plane-departure"></i></span>
                                        <input type="text" class="form-control" name="from_location" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">To</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-plane-arrival"></i></span>
                                        <input type="text" class="form-control" name="to_location" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Departure Date</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                        <input type="date" class="form-control" name="departure_date" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Return Date</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                        <input type="date" class="form-control" name="return_date">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Medical Condition/Treatment</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-notes-medical"></i></span>
                                        <input type="text" class="form-control" name="medical_condition" placeholder="E.g., Heart Surgery, Dental Treatment">
                                    </div>
                                </div>
                                <div class="col-12 mt-4">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-search me-2"></i>Search Flights
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Additional Services Section -->
                <div class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-body p-4">
                            <h4 class="mb-4">Additional Services</h4>
                            <div class="d-grid gap-3">
                                <a href="{{ route('emergency.index') }}" class="btn btn-outline-primary">
                                    <i class="fas fa-ambulance me-2"></i>Medical Transport
                                </a>
                                <a href="{{ route('medical.travel.flightmate') }}" class="btn btn-outline-primary">
                                    <i class="fas fa-user-friends me-2"></i>Book a Flight Mate
                                </a>
                                <a href="{{ route('hotels.index') }}" class="btn btn-outline-primary">
                                    <i class="fas fa-hotel me-2"></i>Accommodation
                                </a>
                                <a href="#" class="btn btn-outline-primary">
                                    <i class="fas fa-wheelchair me-2"></i>Special Assistance
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Travel Tips -->
                    <div class="card">
                        <div class="card-body p-4">
                            <h4 class="mb-4">Travel Tips</h4>
                            <ul class="list-unstyled travel-tips mb-0">
                                <li><i class="fas fa-check-circle text-success me-2"></i>Carry all medical documents</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i>Check airline medical requirements</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i>Arrange travel insurance</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i>Plan rest stops during travel</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>