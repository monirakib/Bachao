<!DOCTYPE html>
<html>
<head>
    <title>Book New Appointment - Medical Services</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter+Tight:ital,wght@0,100..900;1,100..900&family=Murecho:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Murecho', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
        }

        .header1 {
            background: linear-gradient(to right, #dd2476, #ff512f);
            height: 90px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 50px;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 100;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .logo img {
            height: 120px;
            width: 100px;
        }

        .user-section {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .back-button {
            padding: 10px 20px;
            background: white;
            color: #dd2476;
            border: 2px solid #dd2476;
            border-radius: 25px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .back-button:hover {
            background: #dd2476;
            color: white;
        }

        .booking-container {
            margin-top: 120px;
            padding: 20px;
            max-width: 1000px;
            margin-left: auto;
            margin-right: auto;
        }

        .page-title {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }

        .page-title h1 {
            margin: 0;
            color: #2c3e50;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 1.8em;
        }

        .booking-form {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .doctor-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 20px;
            margin: 20px 0;
        }

        .doctor-card {
            background: #f8f9fa;
            padding: 25px;
            border-radius: 15px;
            cursor: pointer;
            transition: all 0.3s ease;
            border: 2px solid transparent;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .doctor-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            border-color: #dd2476;
        }

        .doctor-card.selected {
            background: linear-gradient(to right, #dd2476, #ff512f);
            color: white;
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(221, 36, 118, 0.2);
        }

        .doctor-card h3 {
            margin: 0;
            font-size: 1.2em;
        }

        .doctor-card p {
            margin: 0;
            opacity: 0.8;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            margin-bottom: 10px;
            color: #2c3e50;
            font-weight: 600;
            font-size: 1.1em;
        }

        .form-group select,
        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 2px solid #eee;
            border-radius: 10px;
            font-size: 1em;
            color: #34495e;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }

        .form-group select:focus,
        .form-group input:focus,
        .form-group textarea:focus {
            border-color: #dd2476;
            box-shadow: 0 0 0 3px rgba(221, 36, 118, 0.1);
            outline: none;
            background: white;
        }

        .form-group textarea {
            height: 120px;
            resize: vertical;
        }

        .new-appointment-btn {
            width: 100%;
            padding: 15px;
            background: linear-gradient(to right, #dd2476, #ff512f);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 1.1em;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .new-appointment-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(221, 36, 118, 0.3);
        }

        .background-clips {
            position: fixed;
            right: 0;
            bottom: 0;
            min-width: 100%;
            min-height: 100%;
            width: auto;
            height: auto;
            z-index: -1;
            opacity: 0.1;
        }

        .appointment-type-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin: 10px 0;
        }

        .type-card {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            border: 2px solid transparent;
            text-align: center;
        }

        .type-card i {
            font-size: 2em;
            color: #dd2476;
            margin-bottom: 10px;
        }

        .type-card h3 {
            margin: 10px 0;
            font-size: 1.1em;
            color: #2c3e50;
        }

        .type-card p {
            margin: 0;
            font-size: 0.9em;
            color: #666;
        }

        .type-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            border-color: #dd2476;
        }

        .type-card.selected {
            background: linear-gradient(to right, #dd2476, #ff512f);
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(221, 36, 118, 0.2);
        }

        .type-card.selected i,
        .type-card.selected h3,
        .type-card.selected p {
            color: white;
        }

        .title-wrapper {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #dd2476;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            width: fit-content;
        }

        .back-link:hover {
            transform: translateX(-5px);
            color: #ff512f;
        }

        .back-link i {
            font-size: 0.9em;
        }
    </style>
</head>
<body>
    {{-- <nav class="header1">
        <div class="logo">
            <img src="{{ asset('pics/medical/medichain_logo.png') }}" alt="Logo">
        </div>
        <div class="user-section">
            <a href="{{ route('appointments.index') }}" class="back-button">
                <i class="fas fa-arrow-left"></i> Back to Appointments
            </a>
            <span style="color: white;">Welcome, {{ Auth::user()->first_name }}</span>
        </div>
    </nav> --}}
    @include('layouts.header')

    <video autoplay loop muted plays-inline class="background-clips">
        <source src="{{ asset('pics/medical/medical_dashboard.mp4') }}" type="video/mp4">
    </video>

    <div class="booking-container">
        <div class="page-title">
            <div class="title-wrapper">
                <a href="{{ route('appointments.index') }}" class="back-link">
                    <i class="fas fa-arrow-left"></i> Back to Appointments
                </a>
                <h1><i class="fas fa-calendar-plus"></i> Book New Appointment</h1>
            </div>
        </div>

        <div class="booking-form">
            <form action="{{ route('appointments.store') }}" method="POST" onsubmit="return validateForm()">
                @csrf
                
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <input type="hidden" name="doctor_id" id="selected_doctor" required>
                
                <div class="form-group">
                    <label><i class="fas fa-user-md"></i> Select Doctor</label>
                    <div class="doctor-grid">
                        @foreach($doctors as $doctor)
                            <div class="doctor-card" onclick="selectDoctor(this, {{ $doctor->user_id }})">
                                <h3>Dr. {{ $doctor->first_name }} {{ $doctor->last_name }}</h3>
                                <p>{{ $doctor->specialization }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="form-group">
                    <label><i class="fas fa-calendar-alt"></i> Select Date</label>
                    <input type="date" name="date" required min="{{ date('Y-m-d') }}" 
                           onchange="loadTimeSlots()" id="appointment_date">
                </div>

                <div class="form-group">
                    <label><i class="far fa-clock"></i> Available Time Slots</label>
                    <select name="time_slot" id="time_slot" required>
                        <option value="">Select a date first</option>
                    </select>
                </div>

                <div class="form-group">
                    <label><i class="fas fa-notes-medical"></i> Reason for Visit</label>
                    <textarea name="reason" required 
                              placeholder="Please describe your symptoms or reason for visit"></textarea>
                </div>

                <div class="form-group">
                    <label><i class="fas fa-video"></i> Appointment Type</label>
                    <div class="appointment-type-grid">
                        <div class="type-card" onclick="selectType(this, 'offline')">
                            <i class="fas fa-hospital"></i>
                            <h3>In-Person Visit</h3>
                            <p>Visit the doctor at the hospital</p>
                        </div>
                        <div class="type-card" onclick="selectType(this, 'online')">
                            <i class="fas fa-video"></i>
                            <h3>Video Consultation</h3>
                            <p>Consult with doctor online</p>
                        </div>
                    </div>
                    <input type="hidden" name="appointment_type" id="appointment_type" value="offline" required>
                </div>

                <button type="submit" class="new-appointment-btn">
                    <i class="fas fa-check"></i> Book Appointment
                </button>
            </form>
        </div>
    </div>

    <script>
        function selectDoctor(card, doctorId) {
            // Remove selected class from all cards
            document.querySelectorAll('.doctor-card').forEach(c => {
                c.classList.remove('selected');
            });
            
            // Add selected class to clicked card
            card.classList.add('selected');
            
            // Update hidden input
            document.getElementById('selected_doctor').value = doctorId;
            
            // Load time slots if date is selected
            loadTimeSlots();
        }

        function loadTimeSlots() {
            const doctorId = document.getElementById('selected_doctor').value;
            const date = document.getElementById('appointment_date').value;
            const select = document.getElementById('time_slot');
            
            if (!doctorId || !date) {
                select.innerHTML = '<option value="">Select a doctor and date first</option>';
                return;
            }

            select.innerHTML = '<option value="">Loading time slots...</option>';
            select.disabled = true;

            fetch(`/get-doctor-slots?doctor_id=${doctorId}&date=${date}`, {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(slots => {
                select.innerHTML = '<option value="">Select time slot</option>';
                
                if (slots.length === 0) {
                    select.innerHTML = '<option value="">No available slots for this date</option>';
                } else {
                    slots.forEach(slot => {
                        select.innerHTML += `
                            <option value="${slot.id}">${slot.formatted_time}</option>
                        `;
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                select.innerHTML = '<option value="">Error loading time slots</option>';
            })
            .finally(() => {
                select.disabled = false;
            });
        }

        function selectType(card, type) {
            // Remove selected class from all cards
            document.querySelectorAll('.type-card').forEach(c => {
                c.classList.remove('selected');
            });
            
            // Add selected class to clicked card
            card.classList.add('selected');
            
            // Update hidden input
            document.getElementById('appointment_type').value = type;
        }

        function validateForm() {
            const doctorId = document.getElementById('selected_doctor').value;
            const date = document.getElementById('appointment_date').value;
            const timeSlot = document.getElementById('time_slot').value;
            const reason = document.querySelector('textarea[name="reason"]').value;
            const appointmentType = document.getElementById('appointment_type').value;

            if (!doctorId) {
                alert('Please select a doctor');
                return false;
            }
            if (!date) {
                alert('Please select a date');
                return false;
            }
            if (!timeSlot) {
                alert('Please select a time slot');
                return false;
            }
            if (!reason.trim()) {
                alert('Please enter a reason for the visit');
                return false;
            }
            if (!appointmentType) {
                alert('Please select an appointment type');
                return false;
            }

            // Log form data for debugging
            console.log({
                doctorId,
                date,
                timeSlot,
                reason,
                appointmentType
            });

            return true;
        }
    </script>
</body>
</html>