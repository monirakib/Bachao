<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $type === 'patient' ? 'Appointment Confirmation' : 'New Appointment Scheduled' }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: #f9f9f9;
            padding: 20px;
            border-radius: 5px;
        }
        .header {
            background: #4a90e2;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }
        .content {
            background: white;
            padding: 20px;
            border-radius: 0 0 5px 5px;
        }
        .details {
            margin: 20px 0;
            padding: 15px;
            background: #f5f5f5;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>{{ $type === 'patient' ? 'Appointment Confirmation' : 'New Appointment Scheduled' }}</h1>
        </div>
        
        <div class="content">
            @if($type === 'patient')
                <p>Dear {{ $appointment->patient_name }},</p>
                <p>Your appointment has been confirmed with Dr. {{ $appointment->doctor_name }} {{ $appointment->doctor_last_name }}.</p>
            @else
                <p>Dear Dr. {{ $appointment->doctor_name }},</p>
                <p>A new appointment has been scheduled with patient {{ $appointment->patient_name }}.</p>
            @endif

            <div class="details">
                <h3>Appointment Details:</h3>
                <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($appointment->date)->format('F j, Y') }}</p>
                <p><strong>Time:</strong> {{ \Carbon\Carbon::parse($appointment->time)->format('g:i A') }}</p>
                <p><strong>Type:</strong> {{ ucfirst($appointment->appointment_type) }}</p>
                <p><strong>Reason:</strong> {{ $appointment->reason }}</p>
            </div>

            @if($appointment->appointment_type === 'online')
                <p><em>Video consultation link will be sent before the appointment.</em></p>
            @endif

            <p>Thank you for choosing our medical services.</p>
        </div>
    </div>
</body>
</html>