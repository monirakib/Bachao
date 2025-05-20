<!DOCTYPE html>
<html>
<head>
    <title>Book Flight - Medical Travel</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Murecho', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
        }

        .booking-container {
            max-width: 900px;
            margin: 2rem auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            padding: 2rem;
        }

        .seat-container {
            border: 1px solid #dee2e6;
            margin: 2rem 0;
        }

        .seat-map {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            gap: 10px;
            max-width: 600px;
        }

        .seat {
            aspect-ratio: 1;
            width: 100%;
            max-width: 45px;
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
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }

        .demo-seat {
            width: 35px;
            height: 35px;
            cursor: default;
        }

        .seat:hover:not(.occupied):not(.demo-seat) {
            border-color: #dd2476;
            transform: scale(1.05);
            box-shadow: 0 4px 8px rgba(221, 36, 118, 0.2);
        }

        .seat.selected {
            background: linear-gradient(to right, #dd2476, #ff512f);
            color: white;
            border-color: transparent;
            box-shadow: 0 4px 8px rgba(221, 36, 118, 0.3);
        }

        .seat.occupied {
            background: #e9ecef;
            cursor: not-allowed;
            color: #adb5bd;
            border-color: #dee2e6;
            opacity: 0.7;
            pointer-events: none;
            box-shadow: none;
        }

        .seat.occupied:hover {
            transform: none;
            border-color: #dee2e6;
            box-shadow: none;
        }

        .btn-medical {
            background: linear-gradient(to right, #dd2476, #ff512f);
            border: none;
            color: white;
            padding: 0.8rem 2rem;
            border-radius: 25px;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(221, 36, 118, 0.2);
        }

        .btn-medical:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(221, 36, 118, 0.3);
        }

        .btn-medical:disabled {
            opacity: 0.7;
            cursor: not-allowed;
        }

        .flight-summary {
            background: #f8f9fa;
            padding: 1.5rem;
            border-radius: 12px;
            border: 1px solid #dee2e6;
        }

        .form-select {
            border-radius: 8px;
            padding: 0.8rem 1rem;
            border-color: #dee2e6;
        }

        .form-select:focus {
            border-color: #dd2476;
            box-shadow: 0 0 0 0.25rem rgba(221, 36, 118, 0.25);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="booking-container">
            <h3 class="mb-4">
                <i class="fas fa-plane-departure me-2"></i>
                Book Flight - {{ $flight->airline }} {{ $flight->flight_number }}
            </h3>

            <div class="flight-summary mb-4">
                <div class="row">
                    <div class="col-md-6">
                        <small class="text-muted">From</small>
                        <h5>{{ $flight->from_location }}</h5>
                    </div>
                    <div class="col-md-6">
                        <small class="text-muted">To</small>
                        <h5>{{ $flight->to_location }}</h5>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <small class="text-muted">Departure</small>
                        <h5>{{ \Carbon\Carbon::parse($flight->departure_datetime)->format('F j, Y h:i A') }}</h5>
                    </div>
                    <div class="col-md-6">
                        <small class="text-muted">Price</small>
                        <h5>৳{{ number_format($flight->price, 0) }}</h5>
                    </div>
                </div>
            </div>

            <form id="bookingForm" action="{{ route('medical.travel.book', $flight) }}" method="POST" onsubmit="return validateForm()">
                @csrf                <input type="hidden" name="selected_seat" id="selectedSeat">

                <!-- Success/Error Messages -->
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="seat-legend mb-4">
                    <div class="d-flex justify-content-center gap-4">
                        <div class="d-flex align-items-center">
                            <div class="seat me-2 demo-seat">A1</div>
                            <small>Available</small>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="seat occupied me-2 demo-seat">A2</div>
                            <small>Occupied</small>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="seat selected me-2 demo-seat">A3</div>
                            <small>Selected</small>
                        </div>
                    </div>
                </div>

                <div class="seat-container p-4 bg-light rounded-3">
                    <div class="plane-header mb-4 text-center">
                        <i class="fas fa-plane mb-2" style="font-size: 2rem; color: #dd2476;"></i>
                        <div class="small text-muted">Front of Aircraft</div>
                    </div>
                    <div class="seat-map" id="seatMap"></div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Medical Condition</label>
                        <textarea class="form-control" name="medical_condition" required rows="3" placeholder="Please describe your medical condition">{{ request('medical_condition') }}</textarea>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Medical Assistance Required</label>
                        <select class="form-select" name="special_requirements" required>
                            <option value="">Select Assistance</option>
                            <option value="wheelchair">Wheelchair Assistance</option>
                            <option value="medical_escort">Medical Escort</option>
                            <option value="oxygen">Oxygen Support</option>
                            <option value="none">No Special Assistance</option>
                        </select>
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <div>
                        <a href="{{ route('medical.travel.index') }}" class="btn btn-light me-2">
                            <i class="fas fa-home me-2"></i>Back to Home
                        </a>
                        <a href="{{ route('medical.travel.search') }}" class="btn btn-light me-2">
                            <i class="fas fa-search me-2"></i>Back to Search
                        </a>
                        <a href="{{ url()->previous() }}" class="btn btn-light">
                            <i class="fas fa-arrow-left me-2"></i>Back
                        </a>
                    </div>
                    <button type="submit" class="btn btn-medical" id="confirmButton" disabled>
                        Confirm Booking
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        window.bookedSeats = @json($bookedSeats ?? []);

        function initializeSeats() {
            const seatMap = document.getElementById('seatMap');
            
            // Add row labels
            for (let row = 0; row < 6; row++) {
                const rowLetter = String.fromCharCode(65 + row);
                const rowLabel = document.createElement('div');
                rowLabel.className = 'text-muted small text-center';
                rowLabel.style.gridColumn = '1 / -1';
                rowLabel.innerHTML = `Row ${rowLetter}`;
                seatMap.appendChild(rowLabel);

                // Generate seats for this row
                for (let seatNum = 1; seatNum <= 6; seatNum++) {
                    const seatId = `${rowLetter}${seatNum}`;
                    const seat = document.createElement('div');
                    seat.className = 'seat';
                    seat.dataset.seatId = seatId;
                    seat.innerHTML = seatId;

                    if (seatNum === 3) {
                        seat.style.marginRight = '20px';
                    }

                    // Check if seat is booked using the data from database
                    if (window.bookedSeats.includes(seatId)) {
                        seat.classList.add('occupied');
                        seat.title = 'This seat is already booked';
                        seat.style.pointerEvents = 'none';
                        seat.style.backgroundColor = '#e9ecef';
                        seat.style.opacity = '0.7';
                    } else {
                        seat.addEventListener('click', () => selectSeat(seat));
                    }

                    seatMap.appendChild(seat);
                }
            }
        }

        function selectSeat(seat) {
            // Double check if seat is occupied before allowing selection
            if (seat.classList.contains('occupied') || window.bookedSeats.includes(seat.dataset.seatId)) {
                return;
            }
            
            const selectedSeat = document.querySelector('.selected');
            if (selectedSeat) {
                selectedSeat.classList.remove('selected');
            }
            
            seat.classList.add('selected');
            document.getElementById('selectedSeat').value = seat.dataset.seatId;
            document.getElementById('confirmButton').disabled = false;
        }

        // Initialize seats when page loads
        document.addEventListener('DOMContentLoaded', initializeSeats);

        function validateForm() {
            const seatNumber = document.getElementById('selectedSeat').value;
            
            // Check if seat is in bookedSeats array
            if (window.bookedSeats.includes(seatNumber)) {
                alert('This seat is already booked. Please select another seat.');
                return false;
            }

            const specialReq = document.querySelector('select[name="special_requirements"]').value;
            const medicalCondition = document.querySelector('textarea[name="medical_condition"]').value;

            if (!seatNumber) {
                alert('Please select a seat');
                return false;
            }

            if (!specialReq) {
                alert('Please select medical assistance type');
                return false;
            }

            if (!medicalCondition) {
                alert('Medical condition is missing');
                return false;
            }

            return true;
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>