<!DOCTYPE html>
<html>
<head>
    <title>Patient Records - Medical Services</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter+Tight:ital,wght@0,100..900;1,100..900&family=Murecho:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
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

        .records-container {
            margin-top: 120px;
            padding: 20px;
            max-width: 1000px;
            margin-left: auto;
            margin-right: auto;
        }

        .page-title {
            color: #2c3e50;
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 1.8em;
            font-weight: 600;
        }

        .record-card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 20px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }

        .record-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }

        .record-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }

        .record-doctor {
            font-size: 1.2em;
            color: #2c3e50;
        }

        .doctor-specialization {
            font-size: 0.9em;
            color: #7f8c8d;
            margin-top: 5px;
        }

        .record-date {
            color: #7f8c8d;
            font-size: 0.9em;
        }

        .record-content {
            margin-bottom: 20px;
        }

        .record-label {
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 8px;
        }

        .record-text {
            color: #34495e;
            line-height: 1.6;
        }

        .record-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 15px;
            border-top: 1px solid #eee;
        }

        .doctor-info {
            color: #7f8c8d;
            font-size: 0.9em;
        }

        .record-action {
            padding: 10px 20px;
            border: 2px solid #dd2476;
            border-radius: 25px;
            background: white;
            color: #dd2476;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .record-action:hover {
            background: #dd2476;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(221, 36, 118, 0.3);
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
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .back-button:hover {
            background: #dd2476;
            color: white;
        }

        .no-records {
            text-align: center;
            padding: 50px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .no-records i {
            font-size: 50px;
            color: #dd2476;
            margin-bottom: 20px;
        }

        .no-records h2 {
            color: #2c3e50;
            margin-bottom: 10px;
        }

        .status-badge {
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.9em;
        }

        .status-active {
            background: #e8f5e9;
            color: #2e7d32;
        }

        .status-completed {
            background: #ede7f6;
            color: #4527a0;
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

    <div class="records-container">
        <h1 class="page-title">
            <i class="fas fa-file-medical"></i>
            Medical Records History
        </h1>
        
        @if(count($records) > 0)
            @foreach($records as $record)
                <div class="record-card">
                    <div class="record-header">
                        <div class="record-doctor">
                            <i class="fas fa-user-md"></i>
                            {{ $record->doctor_name ?? 'Not Assigned' }}
                            <div class="doctor-specialization">{{ $record->doctor_specialization ?? '' }}</div>
                        </div>
                        <div class="record-date">
                            <i class="far fa-calendar-alt"></i>
                            {{ \Carbon\Carbon::parse($record->created_at)->format('F j, Y') }}
                        </div>
                    </div>

                    <div class="record-content">
                        <div class="record-label">Record Type</div>
                        <div class="record-text">
                            {{ $record->record_type }}
                        </div>
                    </div>

                    <div class="record-content">
                        <div class="record-label">Description</div>
                        <div class="record-text">
                            {!! nl2br(e($record->description)) !!}
                        </div>
                    </div>

                    @if($record->diagnosis)
                        <div class="record-content">
                            <div class="record-label">Diagnosis</div>
                            <div class="record-text">
                                {!! nl2br(e($record->diagnosis)) !!}
                            </div>
                        </div>
                    @endif

                    @if($record->treatment)
                        <div class="record-content">
                            <div class="record-label">Treatment Plan</div>
                            <div class="record-text">
                                {!! nl2br(e($record->treatment)) !!}
                            </div>
                        </div>
                    @endif

                    <div class="record-footer">
                        <span class="doctor-info">{{ $record->doctor_specialization ?? '' }}</span>
                        <button class="record-action" onclick="window.location.href='{{ route('patient.records.show', $record->id) }}'">
                            View Details
                        </button>
                    </div>
                </div>
            @endforeach
        @else
            <div class="no-records">
                <i class="fas fa-folder-open"></i>
                <h2>No Medical Records Found</h2>
                <p>Your medical history will appear here once you have received treatment.</p>
            </div>
        @endif
    </div>

</body>
</html>