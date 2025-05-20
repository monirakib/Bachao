<!DOCTYPE html>
<html>
<head>
    <title>Appointments - Medical Services</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter+Tight:ital,wght@0,100..900;1,100..900&family=Murecho:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css">
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

        .appointments-container {
            margin-top: 120px;
            padding: 20px;
            max-width: 1200px;
            margin-left: auto;
            margin-right: auto;
            position: relative;
            z-index: 1;
        }

        .page-title {
            background: white;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .page-title h1 {
            margin: 0;
            color: #2c3e50;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .new-appointment-btn {
            padding: 12px 25px;
            background: linear-gradient(to right, #dd2476, #ff512f);
            color: white;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .new-appointment-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(221, 36, 118, 0.3);
        }

        .appointment-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 25px;
        }

        .appointment-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
            margin-bottom: 10px;
        }

        .appointment-card:hover {
            transform: translateY(-5px);
        }

        .appointment-date {
            font-size: 1.3em;
            color: #2c3e50;
            margin-bottom: 10px;
            font-weight: 600;
        }

        .appointment-time {
            color: #dd2476;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .appointment-details {
            margin: 20px 0;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 10px;
        }

        .appointment-details p {
            margin: 10px 0;
            color: #34495e;
        }

        .status-scheduled {
            background: #e8f5e9;
            color: #2e7d32;
            padding: 5px 12px;
            border-radius: 15px;
            font-size: 0.9em;
        }

        .status-completed {
            background: #e3f2fd;
            color: #1565c0;
            padding: 5px 12px;
            border-radius: 15px;
            font-size: 0.9em;
        }

        .status-cancelled {
            background: #ffebee;
            color: #c62828;
            padding: 5px 12px;
            border-radius: 15px;
            font-size: 0.9em;
        }

        .appointment-actions {
            display: flex;
            gap: 10px;
            margin-top: 20px;
            justify-content: flex-end;
        }

        .action-button {
            padding: 8px 20px;
            border: none;
            border-radius: 20px;
            cursor: pointer;
            font-size: 0.9em;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .reschedule-btn {
            background: #e8f5e9;
            color: #2e7d32;
        }

        .cancel-btn {
            background: #ffebee;
            color: #c62828;
        }

        .action-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        }

        .no-appointments {
            text-align: center;
            padding: 50px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            color: #2c3e50;
        }

        .no-appointments i {
            color: #dd2476;
            margin-bottom: 20px;
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

        .calendar-section {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            margin-top: 30px;
        }

        .fc {
            background: white;
            padding: 20px;
            border-radius: 10px;
        }

        .fc .fc-daygrid-day.fc-day-today {
            background: rgba(221, 36, 118, 0.1);
        }

        .fc .appointment-event {
            opacity: 0.3;
        }

        .fc .fc-daygrid-day:hover {
            background: rgba(221, 36, 118, 0.05);
        }

        .fc .fc-daygrid-day.has-appointment {
            font-weight: bold;
            color: #dd2476;
        }

        .doctor-slot {
            background: linear-gradient(to right, #dd2476, #ff512f);
            border: none;
            color: white;
        }

        .booking-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 1000;
        }

        .modal-content {
            background: white;
            width: 90%;
            max-width: 500px;
            margin: 50px auto;
            padding: 30px;
            border-radius: 15px;
            position: relative;
        }

        .close-modal {
            position: absolute;
            right: 20px;
            top: 15px;
            font-size: 24px;
            cursor: pointer;
            color: #666;
        }

        .slot-info {
            margin: 20px 0;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 10px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #2c3e50;
            font-weight: 600;
        }

        .form-group select,
        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 1em;
            color: #34495e;
            transition: all 0.3s ease;
        }

        .form-group select:focus,
        .form-group input:focus,
        .form-group textarea:focus {
            border-color: #dd2476;
            box-shadow: 0 0 0 2px rgba(221, 36, 118, 0.1);
            outline: none;
        }

        .form-group textarea {
            height: 100px;
            resize: vertical;
        }

        .fc-timegrid-slot {
            height: 60px !important;
        }

        .fc-timegrid-event {
            border-radius: 8px;
        }

        .fc-timegrid-event .fc-event-main {
            padding: 4px 8px;
        }

        .fc .fc-button-primary {
            background: linear-gradient(to right, #dd2476, #ff512f);
            border: none;
            transition: all 0.3s ease;
        }

        .fc .fc-button-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(221, 36, 118, 0.3);
        }

        .fc .fc-button-primary:not(:disabled).fc-button-active {
            background: #dd2476;
        }

        .fc .fc-timegrid-now-indicator-line {
            border-color: #dd2476;
        }

        .fc .fc-timegrid-now-indicator-arrow {
            border-color: #dd2476;
            color: #dd2476;
        }
    </style>
</head>
<body>
    {{-- <nav class="header1">
        <div class="logo">
            <img src="{{ asset('pics/medical/medichain_logo.png') }}" alt="Logo">
        </div>
        <div class="user-section">
            <a href="{{ route('dashboard') }}" class="back-button">
                <i class="fas fa-arrow-left"></i> Back to Dashboard
            </a>
            <span style="color: white;">Welcome, {{ Auth::user()->first_name }}</span>
        </div>
    </nav> --}}
    @include('layouts.header')

    <video autoplay loop muted plays-inline class="background-clips">
        <source src="{{ asset('pics/medical/medical_dashboard.mp4') }}" type="video/mp4">
    </video>

    <div class="appointments-container">
        <div class="page-title">
            <h1><i class="fas fa-calendar-alt"></i> My Appointments</h1>
            <button onclick="window.location.href='{{ route('appointments.create') }}'" class="new-appointment-btn">
                <i class="fas fa-plus"></i> New Appointment
            </button>
        </div>

        <div class="appointment-grid">
            @forelse($appointments as $appointment)
                <div class="appointment-card">
                    <div class="appointment-date">
                        {{ \Carbon\Carbon::parse($appointment->date)->format('F j, Y') }}
                    </div>
                    <div class="appointment-time">
                        <i class="far fa-clock"></i>
                        {{ \Carbon\Carbon::parse($appointment->time)->format('h:i A') }}
                    </div>
                    <div class="appointment-details">
                        <p><strong>Doctor:</strong> {{ $appointment->doctor_name ?? 'N/A' }}</p>
                        <p><strong>Department:</strong> {{ $appointment->department ?? 'General' }}</p>
                        <p>
                            <strong>Type:</strong> 
                            <span class="type-badge type-{{ $appointment->appointment_type }}">
                                <i class="fas fa-{{ $appointment->appointment_type === 'online' ? 'video' : 'hospital' }}"></i>
                                {{ ucfirst($appointment->appointment_type) }}
                            </span>
                        </p>
                        <p><strong>Status:</strong> 
                            <span class="status-{{ $appointment->status }}">
                                {{ ucfirst($appointment->status) }}
                            </span>
                        </p>
                    </div>
                    <div class="appointment-actions">
                        @if($appointment->status == 'scheduled')
                            <button class="action-button reschedule-btn" onclick="rescheduleAppointment({{ $appointment->id }})">
                                <i class="fas fa-clock"></i> Reschedule
                            </button>
                            <button class="action-button cancel-btn" onclick="cancelAppointment({{ $appointment->id }})">
                                <i class="fas fa-times"></i> Cancel
                            </button>
                        @endif
                    </div>
                </div>
            @empty
                <div class="no-appointments">
                    <i class="fas fa-calendar-times fa-3x"></i>
                    <h2>No Appointments</h2>
                    <p>You haven't scheduled any appointments yet.</p>
                </div>
            @endforelse
        </div>

        <div class="calendar-section">
            <h2><i class="fas fa-calendar-alt"></i> Appointment Calendar</h2>
            <div id="doctorCalendar"></div>
        </div>
    </div>

    <div id="bookingModal" class="booking-modal">
        <div class="modal-content">
            <span class="close-modal" onclick="closeModal()">&times;</span>
            <h2><i class="fas fa-calendar-plus"></i> Book New Appointment</h2>
            
            <form id="bookingForm" onsubmit="bookAppointment(event)">
                <div class="form-group">
                    <label><i class="fas fa-user-md"></i> Select Doctor</label>
                    <select id="doctorSelect" name="doctor_id" required onchange="loadDoctorSlots()">
                        <option value="">Choose a doctor</option>
                    </select>
                </div>

                <div class="form-group">
                    <label><i class="fas fa-calendar-alt"></i> Select Date</label>
                    <input type="date" id="appointmentDate" name="date" required 
                           min="{{ date('Y-m-d') }}" onchange="loadTimeSlots()">
                </div>

                <div class="form-group">
                    <label><i class="far fa-clock"></i> Available Time Slots</label>
                    <select id="timeSlot" name="time_slot" required>
                        <option value="">Select a date first</option>
                    </select>
                </div>

                <div class="form-group">
                    <label><i class="fas fa-notes-medical"></i> Reason for Visit</label>
                    <textarea name="reason" required 
                              placeholder="Please describe your symptoms or reason for visit"></textarea>
                </div>

                <button type="submit" class="new-appointment-btn">
                    <i class="fas fa-check"></i> Confirm Booking
                </button>
            </form>
        </div>
    </div>

    <!-- Add these script tags before closing body -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('doctorCalendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek' // Added timeGridWeek view
                },
                views: {
                    timeGridWeek: { // Configure week view
                        titleFormat: { year: 'numeric', month: 'short', day: 'numeric' },
                        slotMinTime: '09:00:00',
                        slotMaxTime: '18:00:00',
                        slotDuration: '01:00:00',
                        slotLabelInterval: '01:00',
                        slotLabelFormat: {
                            hour: 'numeric',
                            minute: '2-digit',
                            meridiem: 'short'
                        }
                    }
                },
                events: [
                    @foreach($appointments as $appointment)
                    {
                        title: '{{ $appointment->appointment_type === "online" ? "🎥" : "🏥" }} Dr. {{ $appointment->doctor_name }}',
                        start: '{{ $appointment->date }}T{{ $appointment->time }}',
                        end: '{{ $appointment->date }}T{{ \Carbon\Carbon::parse($appointment->time)->addHour()->format("H:i:s") }}',
                        className: 'appointment-event',
                        backgroundColor: '{{ $appointment->status == "scheduled" ? "#dd2476" : "#666" }}',
                        borderColor: '{{ $appointment->status == "scheduled" ? "#dd2476" : "#666" }}',
                        textColor: 'white',
                        extendedProps: {
                            type: '{{ $appointment->appointment_type }}'
                        }
                    },
                    @endforeach
                ],
                eventClick: function(info) {
                    const events = calendar.getEvents().filter(event => 
                        event.start.toISOString().split('T')[0] === info.event.start.toISOString().split('T')[0]
                    );
                    if (events.length > 0) {
                        const appointmentDetails = events.map(event => 
                            `${event.title} (${event.extendedProps.type})`
                        ).join('\n');
                        alert(`Appointments on this date:\n${appointmentDetails}`);
                    }
                }
            });
            calendar.render();
        });

        function showBookingModal() {
            // Fetch available doctors
            fetch('/api/doctors')
                .then(response => response.json())
                .then(doctors => {
                    const select = document.getElementById('doctorSelect');
                    select.innerHTML = '<option value="">Choose a doctor</option>';
                    
                    doctors.forEach(doc => {
                        select.innerHTML += `
                            <option value="${doc.user_id}">
                                Dr. ${doc.first_name} ${doc.last_name} - ${doc.specialization}
                            </option>
                        `;
                    });
                    
                    document.getElementById('bookingModal').style.display = 'block';
                })
                .catch(error => {
                    console.error('Error fetching doctors:', error);
                    alert('Error loading doctors. Please try again.');
                });
        }

        function loadDoctorSlots() {
            const doctorId = document.getElementById('doctorSelect').value;
            const dateInput = document.getElementById('appointmentDate');
            
            if (doctorId) {
                dateInput.disabled = false;
                loadTimeSlots();
            } else {
                dateInput.disabled = true;
            }
        }

        function loadTimeSlots() {
            const doctorId = document.getElementById('doctorSelect').value;
            const date = document.getElementById('appointmentDate').value;
            const timeSelect = document.getElementById('timeSlot');
            
            if (!doctorId || !date) return;

            fetch(`/api/doctor-slots?doctor_id=${doctorId}&date=${date}`)
                .then(response => response.json())
                .then(slots => {
                    timeSelect.innerHTML = '<option value="">Select time slot</option>';
                    
                    slots.forEach(slot => {
                        const time = new Date(`${date}T${slot.time}`);
                        timeSelect.innerHTML += `
                            <option value="${slot.id}">
                                ${time.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}
                            </option>
                        `;
                    });
                })
                .catch(error => {
                    console.error('Error loading time slots:', error);
                    alert('Error loading available times. Please try again.');
                });
        }

        function bookAppointment(event) {
            event.preventDefault();
            const form = event.target;
            const formData = new FormData(form);

            fetch('/api/book-appointment', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify(Object.fromEntries(formData))
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Appointment booked successfully!');
                    window.location.reload();
                } else {
                    alert(data.message || 'Error booking appointment');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error booking appointment. Please try again.');
            });
        }

        function closeModal() {
            document.getElementById('bookingModal').style.display = 'none';
        }
    </script>
</body>
</html>