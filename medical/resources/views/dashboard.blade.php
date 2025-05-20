<!DOCTYPE html>
<html>
<head>
    <title>Medical Services Dashboard</title>
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
        }

        .header1 {
            background: linear-gradient(to right, #dd2476, #ff512f);
            height: 110px;  /* Increased from 90px */
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
            height: 130px;  /* Increased from 60px */
            width: 100px;
            
        }

        .user-section {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .guest {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .guest-logo {
            width: 40px;
            height: 40px;
            transition: all 0.3s ease;
        }

        .guest-logo:hover {
            transform: scale(1.1);
        }

        .login-button {
            padding: 8px 16px;
            border-radius: 5px;
            background: rgba(255, 255, 255, 0.1);
            color: white;
            text-decoration: none;
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
            font-size: 0.9em;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .login-button:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-1px);
        }

        .login-button i {
            font-size: 0.9em;
        }

        .services-grid {
            margin-top: 140px;  /* Increased from 120px */
            padding: 20px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            max-width: 1200px;
            margin-left: auto;
            margin-right: auto;
        }

        .service-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            text-align: center;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .service-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }

        .service-icon {
            font-size: 40px;
            color: #e74c3c;
            margin-bottom: 15px;
        }

        .service-title {
            font-size: 1.5em;
            color: #2c3e50;
            margin-bottom: 10px;
        }

        .service-description {
            color: #7f8c8d;
            margin-bottom: 20px;
        }

        .service-button {
            padding: 10px 25px;
            border: none;
            border-radius: 25px;
            background: linear-gradient(to right, #dd2476, #ff512f);
            color: white;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .service-button:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 15px rgba(231, 76, 60, 0.3);
        }

        .back-button {
            padding: 10px 20px;
            background: white;
            color: #e74c3c;
            border: 2px solid #e74c3c;
            border-radius: 25px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .back-button:hover {
            background: #e74c3c;
            color: white;
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            backdrop-filter: blur(5px);
            z-index: 1000;
        }

        .modal-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            padding: 30px;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 4px 20px rgba(0,0,0,0.2);
        }

        .modal-content i {
            color: #e74c3c;
            font-size: 50px;
            margin-bottom: 20px;
        }
        .background-clips {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -1;
        }

        .profile-dropdown {
            position: relative;
            display: inline-block;
        }

        .profile-menu {
            display: none;
            position: absolute;
            top: 45px;
            right: 0;
            background: white;
            min-width: 200px;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.15);
            z-index: 1000;
        }

        .profile-menu-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 20px;
            color: #2c3e50;
            text-decoration: none;
            font-size: 0.9em;
            transition: all 0.3s ease;
            border: none;
            background: none;
            width: 100%;
            text-align: left;
            cursor: pointer;
        }

        .profile-menu-item:hover {
            background: #f8f9fa;
            color: #dd2476;
        }

        .profile-divider {
            margin: 5px 0;
            border: none;
            border-top: 1px solid #eee;
        }

        .insurance-btn {
            padding: 8px 16px;
            border-radius: 5px;
            background: rgba(255, 255, 255, 0.1);
            color: white;
            text-decoration: none;
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
            font-size: 0.9em;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .insurance-btn:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-1px);
        }

        .insurance-btn i {
            font-size: 0.9em;
            color: white;  /* Changed icon color to white */
        }

    </style>
</head>
<body>
    <a href="{{ route('feedback.index') }}" 
       style="position: fixed; top: 20px; left: 180px; z-index: 2000; background: linear-gradient(to right, #dd2476, #ff512f); color: #fff; padding: 10px 22px; border-radius: 8px; text-decoration: none; font-weight: 600; box-shadow: 0 2px 8px rgba(221,36,118,0.12); transition: background 0.2s;">
        <i class="fas fa-comments"></i> Feedback
    </a>
    <nav class="header1">
        <div class="logo">
            <img src="{{ asset('pics/medical/medichain_logo.png') }}" alt="Logo">
        </div>
        @auth
            <a href="{{ route('insurance.plans') }}" class="insurance-btn">
                <i class="fas fa-heart-pulse"></i>
                Health Insurance
            </a>
        @endauth
        <div class="user-section">
            <a href="{{ route('home') }}" class="back-button">
                <i class="fas fa-arrow-left"></i> Back to Home
            </a>
            <div class="guest">
                @auth
                    <div class="profile-dropdown">
                        <img class="guest-logo" src="{{ asset('pics/guest-removebg-preview.png') }}" alt="User Profile" onclick="toggleProfileMenu()">
                        <div id="profileMenu" class="profile-menu">
                            <a href="{{ route('profile.edit') }}" class="profile-menu-item">
                                <i class="fas fa-user-edit"></i> Edit Profile
                            </a>
                            <hr class="profile-divider">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="profile-menu-item">
                                    <i class="fas fa-sign-out-alt"></i> Logout
                                </button>
                            </form>
                        </div>
                    </div>
                    <span style="color: white;">{{ Auth::user()->first_name }}</span>
                @else
                    <img class="guest-logo" src="{{ asset('pics/guest-removebg-preview.png') }}" alt="Guest">
                    <span style="color: white;">Guest</span>
                @endauth
            </div>
            @auth
                @if(Auth::user()->role === 'doctor')
                    <a href="{{ route('doctor.dashboard') }}" class="login-button">
                        <i class="fas fa-user-md"></i> Doctor Panel
                    </a>
                @endif
                @if(Auth::user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="login-button">
                        <i class="fas fa-user-shield"></i> Admin Panel
                    </a>
                @endif
                <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                    @csrf
                    <button class="login-button" type="submit">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="login-button">Login</a>
            @endauth
        </div>
    </nav>

    <div class="services-grid">
        @auth

            <!-- Medical Records & History -->
            <div class="service-card">
                <i class="fas fa-file-medical service-icon"></i>
                <h2 class="service-title">Patient Records</h2>
                <p class="service-description">Access your complete medical history, prescriptions, and treatment records securely.</p>
                <a class="service-button" href="{{ route('patient.records') }}">View Records</a>
            </div>

            <!-- Emergency Services -->
            <div class="service-card">
                <i class="fas fa-ambulance service-icon"></i>
                <h2 class="service-title">Emergency Services</h2>
                <p class="service-description">Find nearby hospitals, book ambulances, and check bed availability in real-time.</p>
                <a class="service-button" href="{{ route('emergency.index') }}">Emergency Help</a>
            </div>

            <!-- Telemedicine -->
            <div class="service-card">
                <i class="fas fa-video service-icon"></i>
                <h2 class="service-title">Telemedicine</h2>
                <p class="service-description">Connect with doctors via video calls and chat consultations.</p>
                <a class="service-button" href="{{ route('consultations.index') }}">View Consultations</a>
            </div>

            <!-- Appointment Booking -->
            <div class="service-card">
                <i class="fas fa-calendar-alt service-icon"></i>
                <h2 class="service-title">Appointments</h2>
                <p class="service-description">Schedule hospital visits and manage your medical appointments.</p>
                <a class="service-button" href="{{ route('appointments.index') }}">Book Appointment</a>
            </div>

            <!-- Medical Travel -->
            <div class="service-card">
                <i class="fas fa-plane-departure service-icon"></i>
                <h2 class="service-title">Medical Travel</h2>
                <p class="service-description">Book flights for medical treatments and find travel companions.</p>
                <a class="service-button" href="{{ route('medical.travel.index') }}">Plan Travel</a>
            </div>

            <!-- Health Monitoring -->
            <div class="service-card">
                <i class="fas fa-heartbeat service-icon"></i>
                <h2 class="service-title">Health Monitoring</h2>
                <p class="service-description">AI-powered health recommendations and medication reminders.</p>
                <a class="service-button" href="{{ route('health.monitoring') }}">Monitor Health</a>
            </div>

            <!-- Insurance Services -->
            {{-- <div class="service-card">
                <i class="fas fa-shield-alt service-icon"></i>
                <h2 class="service-title">Insurance</h2>
                <p class="service-description">Purchase health and travel insurance for medical trips.</p>
                <a class="service-button" href="{{ route('insurance') }}">Get Insurance</a>
            </div> --}}

            <!-- Language & Guide Services -->
            {{-- <div class="service-card">
                <i class="fas fa-language service-icon"></i>
                <h2 class="service-title">Travel Assistance</h2>
                <p class="service-description">Find guides, translators, and local assistance for medical travel.</p>
                <a class="service-button" href="{{ route('travel.assistance') }}">Get Assistance</a>
            </div> --}}
        @else
            @php
                $services = [
                    ['icon' => 'fa-file-medical', 'title' => 'Patient Records', 'desc' => 'Access your complete medical history, prescriptions, and treatment records securely.'],
                    ['icon' => 'fa-ambulance', 'title' => 'Emergency Services', 'desc' => 'Find nearby hospitals, book ambulances, and check bed availability in real-time.'],
                    ['icon' => 'fa-video', 'title' => 'Telemedicine', 'desc' => 'Connect with doctors via video calls and chat consultations.'],
                    ['icon' => 'fa-calendar-alt', 'title' => 'Appointments', 'desc' => 'Schedule hospital visits and manage your medical appointments.'],
                    ['icon' => 'fa-plane-departure', 'title' => 'Medical Travel', 'desc' => 'Book flights for medical treatments and find travel companions.'],
                    ['icon' => 'fa-heartbeat', 'title' => 'Health Monitoring', 'desc' => 'AI-powered health recommendations and medication reminders.'],
                    // ['icon' => 'fa-shield-alt', 'title' => 'Insurance', 'desc' => 'Purchase health and travel insurance for medical trips.'],
                    // ['icon' => 'fa-language', 'title' => 'Travel Assistance', 'desc' => 'Find guides, translators, and local assistance for medical travel.']
                ];
            @endphp
            @foreach ($services as $service)
                <div class="service-card">
                    <i class="fas {{ $service['icon'] }} service-icon"></i>
                    <h2 class="service-title">{{ $service['title'] }}</h2>
                    <p class="service-description">{{ $service['desc'] }}</p>
                    <button class="service-button" onclick="showAccessDenied()">
                        <i class="fas fa-lock"></i> Login Required
                    </button>
                </div>
            @endforeach
        @endauth
    </div>

    <!-- Access Denied Modal -->
    <div id="accessDeniedModal" class="modal">
        <div class="modal-content">
            <i class="fas fa-exclamation-circle"></i>
            <h2>Access Denied</h2>
            <p>Please log in to access this feature.</p>
            <a href="{{ route('login') }}" class="login-button">Login Now</a>
        </div>
    </div>
    <video autoplay loop muted plays-inline class="background-clips">
      <source src="{{ asset('pics/medical/medical_dashboard.mp4') }}" type="video/mp4">
    </video>

    <script>
        function showAccessDenied() {
            document.getElementById('accessDeniedModal').style.display = 'block';
        }

        window.onclick = function(event) {
            let modal = document.getElementById('accessDeniedModal');
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        }

        function toggleProfileMenu() {
            let profileMenu = document.getElementById('profileMenu');
            profileMenu.style.display = profileMenu.style.display === 'block' ? 'none' : 'block';
        }

        window.onclick = function(event) {
            if (!event.target.matches('.guest-logo')) {
                let profileMenu = document.getElementById('profileMenu');
                if (profileMenu.style.display === 'block') {
                    profileMenu.style.display = 'none';
                }
            }
        }
    </script>
</body>
</html>