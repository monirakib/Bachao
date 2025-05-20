<!DOCTYPE html>
<html>
<head>
    <title>Emergency Services - Medical Services</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
        
        .container {
            margin-top: 120px;
            padding: 20px;
            max-width: 1200px;
            margin-left: auto;
            margin-right: auto;
        }

        .page-title {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .page-title h1 {
            margin: 0;
            color: #2c3e50;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 1.8em;
        }

        .emergency-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 30px;
        }

        .hospital-list {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .hospital-card {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 15px;
            transition: all 0.3s ease;
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 20px;
        }

        .hospital-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .form-group {
            margin-bottom: 15px; /* Reduce from 20px */
            margin-right: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 10px;
            color: #2c3e50;
            font-weight: 600;
        }

        .form-group select,
        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 2px solid #eee;
            border-radius: 10px;
            font-size: 1em;
            transition: all 0.3s ease;
        }

        .form-group select:focus,
        .form-group input:focus,
        .form-group textarea:focus {
            border-color: #dd2476;
            outline: none;
            box-shadow: 0 0 0 3px rgba(221, 36, 118, 0.1);
        }

        .form-group textarea {
            height: 80px; /* Add this to reduce textarea height */
            resize: none; /* Add this to prevent resizing */
        }

        .form-group:last-child {
            margin-bottom: 0; /* Add this */
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

        .emergency-button {
            background: linear-gradient(to right, #dd2476, #ff512f);
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 25px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
        }

        .emergency-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(221, 36, 118, 0.3);
        }

        .ambulance-type-selector {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .radio-label {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 12px;
            border: 2px solid #eee;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .radio-label:hover {
            border-color: #dd2476;
        }

        .radio-label input[type="radio"] {
            display: none;
        }

        .radio-label input[type="radio"]:checked + span {
            color: #dd2476;
            font-weight: 600;
        }

        @media (max-width: 768px) {
            .emergency-grid {
                grid-template-columns: 1fr;
            }
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

        .alert {
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-success {
            background: #e8f5e9;
            color: #2e7d32;
            border: 1px solid #a5d6a7;
        }

        .alert-danger {
            background: #ffebee;
            color: #c62828;
            border: 1px solid #ef9a9a;
        }

        .popup-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .popup-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .popup {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 5px 30px rgba(0, 0, 0, 0.2);
            text-align: center;
            max-width: 400px;
            width: 90%;
            transform: translateY(-20px);
            transition: all 0.3s ease;
        }

        .popup-overlay.active .popup {
            transform: translateY(0);
        }

        .popup i {
            font-size: 3em;
            margin-bottom: 15px;
        }

        .popup.success i {
            color: #2e7d32;
        }

        .popup.error i {
            color: #c62828;
        }

        .popup h3 {
            margin: 0 0 10px;
            color: #2c3e50;
        }

        .popup p {
            margin: 0 0 20px;
            color: #666;
        }

        .popup-close {
            background: #dd2476;
            color: white;
            border: none;
            padding: 10px 25px;
            border-radius: 25px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .popup-close:hover {
            background: #ff512f;
        }

        .book-ambulance-card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            text-align: left;
        }
        
        .book-ambulance-card h2 {
            color: #dd2476;
            margin-bottom: 25px;
            font-size: 1.8em;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .book-ambulance-button {
            background: linear-gradient(to right, #dd2476, #ff512f);
            color: white;
            text-decoration: none;
            padding: 15px 30px;
            border-radius: 25px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s ease;
            margin-top: 20px;
        }
        
        .book-ambulance-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(221, 36, 118, 0.3);
        }

        .emergency-info {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 20px;
            margin: 20px 0;
        }

        .emergency-info p {
            margin: 12px 0;
            color: #2c3e50;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .emergency-info p i {
            color: #dd2476;
        }

        .emergency-desc {
            color: #666;
            line-height: 1.6;
            margin: 20px 0;
        }

        .ambulance-info {
            padding: 20px;
        }

        @media (max-width: 768px) {
            .book-ambulance-card {
                padding: 20px;
            }
            
            .emergency-info {
                padding: 15px;
            }
            
            .book-ambulance-button {
                width: 100%;
                justify-content: center;
            }
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

    <div class="container">
        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-ambulance"></i>
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i>
                {{ session('error') }}
            </div>
        @endif

        <div class="page-title">
            <h1><i class="fas fa-ambulance"></i> Emergency Services</h1>
        </div>

        <div class="emergency-grid">
            <div class="hospital-list">
                <h2><i class="fas fa-hospital"></i> Nearby Hospitals</h2>
                
                @forelse($hospitals as $hospital)
                    <div class="hospital-card">
                        <div class="hospital-info">
                            <h3>{{ $hospital->name }}</h3>
                            <p><i class="fas fa-map-marker-alt"></i> {{ $hospital->address }}</p>
                            <p><i class="fas fa-phone"></i> Emergency: {{ $hospital->emergency_phone }}</p>
                            @if($hospital->has_air_ambulance)
                                <p class="air-ambulance-badge">
                                    <i class="fas fa-helicopter"></i> Air Ambulance Available
                                </p>
                            @endif
                        </div>
                        <div class="hospital-status">
                            <p class="beds-available">{{ $hospital->available_beds }} Beds Available</p>
                            <p class="wait-time">Wait Time: ~{{ $hospital->wait_time }} mins</p>
                            <button class="emergency-button" onclick="getDirections({{ $hospital->latitude }}, {{ $hospital->longitude }})">
                                <i class="fas fa-directions"></i> Get Directions
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="no-hospitals">
                        <i class="fas fa-exclamation-circle"></i>
                        <h3>No Hospitals Found</h3>
                        <p>Please try again later or call emergency services directly.</p>
                    </div>
                @endforelse
            </div>

            <div class="book-ambulance-card">
                <div class="ambulance-info">
                    <h2><i class="fas fa-ambulance"></i> Need an Ambulance?</h2>
                    <div class="emergency-info">
                        <p><i class="fas fa-info-circle"></i> 24/7 Emergency Service Available</p>
                        <p><i class="fas fa-clock"></i> Average Response Time: 10-15 minutes</p>
                        <p><i class="fas fa-phone-alt"></i> Emergency Hotline: <strong>999</strong></p>
                    </div>
                    <p class="emergency-desc">
                        Request immediate medical transportation to any of our partner hospitals.
                        Our ambulances are equipped with life-saving equipment and trained medical staff.
                    </p>
                    <a href="{{ route('emergency.book') }}" class="book-ambulance-button">
                        <i class="fas fa-phone-alt"></i>
                        Book Emergency Ambulance
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        function getDirections(lat, lng) {
            window.open(`https://www.google.com/maps/dir/?api=1&destination=${lat},${lng}`);
        }
    </script>
</body>
</html>