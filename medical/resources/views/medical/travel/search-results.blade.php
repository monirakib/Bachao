<!DOCTYPE html>
<html>
<head>
    <title>Flight Search Results - Medical Travel</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter+Tight:ital,wght@0,100..900;1,100..900&family=Murecho:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Murecho', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            margin: 0;
            padding: 0;
        }

        .navbar {
            background: linear-gradient(to right, #dd2476, #ff512f);
            padding: 1rem 0;
            margin-bottom: 2rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .search-summary {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }

        .flight-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s, box-shadow 0.3s;
            margin-bottom: 1.5rem;
        }

        .flight-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }

        .flight-details {
            padding: 1.5rem;
        }

        .flight-path {
            position: relative;
            padding: 2rem 0;
        }

        .flight-path::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 15%;
            right: 15%;
            height: 2px;
            background: #e9ecef;
            z-index: 1;
        }

        .plane-icon {
            position: relative;
            z-index: 2;
            background: white;
            padding: 0.75rem;
            border-radius: 50%;
            color: #dd2476;
            box-shadow: 0 2px 10px rgba(221, 36, 118, 0.2);
        }

        .price-badge {
            background: linear-gradient(to right, #dd2476, #ff512f);
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 25px;
            font-weight: 600;
            font-size: 1.1rem;
        }

        .seat-map {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            gap: 15px;
            padding: 30px;
            background: #f8f9fa;
            border-radius: 15px;
            margin: 1rem 0;
            position: relative;
        }

        .seat {
            aspect-ratio: 1;
            width: 100%;
            max-width: 50px;
            border: 2px solid #dee2e6;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
            background: white;
            font-weight: 500;
            font-size: 0.9rem;
            margin: auto;
        }

        .seat:hover:not(.occupied) {
            border-color: #dd2476;
            transform: scale(1.05);
            box-shadow: 0 2px 8px rgba(221, 36, 118, 0.15);
        }

        .seat.selected {
            background: linear-gradient(to right, #dd2476, #ff512f);
            color: white;
            border-color: transparent;
        }

        .seat.occupied {
            background: #e9ecef;
            cursor: not-allowed;
            color: #adb5bd;
            border-color: #dee2e6;
        }

        .seat-legend {
            background: white;
            padding: 10px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .seat-legend .seat {
            width: 40px;
            height: 40px;
            font-size: 0.8rem;
        }

        .seat-map::before {
            content: '';
            position: absolute;
            top: 80px;
            left: 50%;
            height: calc(100% - 100px);
            width: 2px;
            background: #dee2e6;
            transform: translateX(-50%);
        }

        .btn-medical {
            background: linear-gradient(to right, #dd2476, #ff512f);
            border: none;
            border-radius: 25px;
            color: white;
            padding: 0.8rem 2rem;
            font-weight: 500;
            transition: all 0.3s;
        }

        .btn-medical:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(221, 36, 118, 0.2);
        }

        .time-label {
            font-size: 1.25rem;
            font-weight: 600;
            color: #2d3436;
        }

        .location-label {
            color: #636e72;
            font-size: 0.9rem;
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

        .form-select {
            border-radius: 10px;
            padding: 0.75rem;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <div class="d-flex align-items-center">
                <a href="{{ route('medical.travel.index') }}" class="btn btn-outline-light me-3">
                    <i class="fas fa-home me-2"></i>Home
                </a>
                <a class="navbar-brand text-white" href="#">
                    <i class="fas fa-plane-departure me-2"></i>
                    Medical Travel
                </a>
            </div>
            <!-- Changed to GET method and updated route -->
            <form action="{{ route('medical.travel.search') }}" method="GET" class="d-flex">
                <button type="submit" class="btn btn-outline-light">
                    <i class="fas fa-search me-2"></i>New Search
                </button>
            </form>
        </div>
    </nav>

    <div class="container">
        <div class="search-summary">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="d-flex align-items-center">
                        <div class="me-4">
                            <small class="text-muted">From</small>
                            <h5 class="mb-0">{{ request('from_location') }}</h5>
                        </div>
                        <i class="fas fa-arrow-right text-muted mx-4"></i>
                        <div>
                            <small class="text-muted">To</small>
                            <h5 class="mb-0">{{ request('to_location') }}</h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 text-md-end">
                    <small class="text-muted">Travel Date</small>
                    <h5 class="mb-0">{{ \Carbon\Carbon::parse(request('departure_date'))->format('F j, Y') }}</h5>
                </div>
            </div>
        </div>

        @if($flights->count() > 0)
            @foreach($flights as $flight)
                <div class="flight-card">
                    <div class="flight-details">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div>
                                <h4 class="mb-1">{{ $flight->airline }}</h4>
                                <div class="text-muted">Flight {{ $flight->flight_number }}</div>
                            </div>
                            <div class="price-badge">
                                ৳{{ number_format($flight->price, 0) }}
                            </div>
                        </div>

                        <div class="flight-path">
                            <div class="row align-items-center">
                                <div class="col-3 text-center">
                                    <div class="time-label">
                                        {{ \Carbon\Carbon::parse($flight->departure_datetime)->format('h:i A') }}
                                    </div>
                                    <div class="location-label">{{ $flight->from_location }}</div>
                                </div>
                                <div class="col-6 text-center">
                                    <div class="plane-icon">
                                        <i class="fas fa-plane"></i>
                                    </div>
                                </div>
                                <div class="col-3 text-center">
                                    <div class="time-label">
                                        {{ \Carbon\Carbon::parse($flight->arrival_datetime)->format('h:i A') }}
                                    </div>
                                    <div class="location-label">{{ $flight->to_location }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 d-flex justify-content-between align-items-center">
                            <div>
                                <small class="text-muted">Available Seats</small>
                                <div class="fw-bold">{{ $flight->available_seats }}</div>
                            </div>
                            <!-- Replace the modal button with this -->
                            <a href="{{ route('medical.travel.book.form', $flight) }}" class="btn btn-medical">
                                Select Seat <i class="fas fa-chair ms-2"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="text-center py-5">
                <i class="fas fa-plane-slash fa-4x text-muted mb-4"></i>
                <h3>No Flights Available</h3>
                <p class="text-muted mb-4">We couldn't find any flights matching your criteria.</p>
                <!-- Changed to GET method -->
                <form action="{{ route('medical.travel.search') }}" method="GET">
                    <button type="submit" class="btn btn-medical">
                        <i class="fas fa-search me-2"></i>New Search
                    </button>
                </form>
            </div>
        @endif
    </div>

    <script>
        function initializeSeats(flightId) {
            const seatMap = document.getElementById(`seatMap${flightId}`);
            seatMap.innerHTML = '';

            // Create seat legend
            const legend = document.createElement('div');
            legend.className = 'seat-legend mb-4 d-flex gap-3 justify-content-center w-100';
            legend.style.gridColumn = '1 / -1';
            legend.innerHTML = `
                <div class="d-flex align-items-center">
                    <div class="seat me-2">A1</div>
                    <small>Available</small>
                </div>
                <div class="d-flex align-items-center">
                    <div class="seat occupied me-2">A2</div>
                    <small>Occupied</small>
                </div>
                <div class="d-flex align-items-center">
                    <div class="seat selected me-2">A3</div>
                    <small>Selected</small>
                </div>
            `;
            seatMap.appendChild(legend);

            // Get booked seats for this flight
            const booked = (window.bookedSeats && window.bookedSeats[flightId]) ? window.bookedSeats[flightId] : [];

            // Generate rows A through F (6 rows)
            for (let row = 0; row < 6; row++) {
                const rowLetter = String.fromCharCode(65 + row);

                // Generate seats 1 through 6 for each row
                for (let seatNum = 1; seatNum <= 6; seatNum++) {
                    const seatId = `${rowLetter}${seatNum}`;

                    const seat = document.createElement('div');
                    seat.className = 'seat';
                    seat.dataset.seatId = seatId;
                    seat.innerHTML = seatId;

                    // Add aisle space after seat 3
                    if (seatNum === 3) {
                        seat.style.marginRight = '20px';
                    }

                    // Mark as occupied if booked
                    if (booked.includes(seatId)) {
                        seat.classList.add('occupied');
                    } else {
                        seat.addEventListener('click', () => selectSeat(seat, flightId));
                    }

                    seatMap.appendChild(seat);
                }
            }
        }

        function selectSeat(seat, flightId) {
            if (seat.classList.contains('occupied')) return;
            
            const selectedSeat = document.querySelector(`#seatMap${flightId} .selected`);
            if (selectedSeat) {
                selectedSeat.classList.remove('selected');
            }
            
            seat.classList.add('selected');
            document.getElementById(`selectedSeat${flightId}`).value = seat.dataset.seatId;
            document.getElementById(`confirmButton${flightId}`).disabled = false;
        }

        function validateBooking(flightId) {
            const form = document.getElementById(`bookingForm${flightId}`);
            const seatNumber = document.getElementById(`selectedSeat${flightId}`).value;
            const specialRequirements = form.special_requirements.value;

            if (!seatNumber) {
                alert('Please select a seat first');
                return false;
            }

            if (!specialRequirements) {
                alert('Please select medical assistance type');
                return false;
            }

            return true;
        }
    </script>

    @foreach($flights as $flight)
    <script>
        window.bookedSeats = window.bookedSeats || {};
        window.bookedSeats[{{ $flight->id }}] = @json($flight->booked_seats ?? []);
    </script>
    @endforeach

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>