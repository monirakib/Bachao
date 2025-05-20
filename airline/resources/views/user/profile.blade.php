<!DOCTYPE html>
<html>
<head>
    <title>User Profile - Bachao Airlines</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Murecho:wght@100..900&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Murecho', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
        }

        .header1 {
            background: linear-gradient(to right, #5c6bc0, #2da0a8);
            padding: 20px 50px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 100;
            box-sizing: border-box;
        }

        .container {
            max-width: 800px;
            margin: 130px auto 40px;
            padding: 40px;
            background: white;
            border-radius: 20px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.1);
        }

        .profile-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .profile-picture {
            width: 120px;
            height: 120px;
            border-radius: 60px;
            margin: 0 auto 20px;
            display: block;
            border: 4px solid #2da0a8;
            padding: 3px;
        }

        .profile-name {
            color: #2c3e50;
            font-size: 2em;
            margin-bottom: 10px;
        }

        .profile-type {
            color: #2da0a8;
            font-size: 1.1em;
            margin-bottom: 20px;
        }

        .info-section {
            margin-bottom: 30px;
        }

        .info-group {
            padding: 15px;
            border-bottom: 1px solid #eee;
            display: flex;
            align-items: center;
        }

        .info-label {
            width: 140px;
            color: #666;
            font-weight: 600;
            font-size: 0.9em;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .info-value {
            flex: 1;
            color: #2c3e50;
            font-size: 1em;
        }

        .info-group i {
            width: 24px;
            color: #2da0a8;
            margin-right: 15px;
        }

        .edit-button {
            background: linear-gradient(to right, #5c6bc0, #2da0a8);
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 12px;
            font-size: 1em;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            font-weight: 600;
            text-decoration: none;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .edit-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(45, 160, 168, 0.3);
        }

        .back-link {
            color: #2c3e50;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 30px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .back-link:hover {
            color: #2da0a8;
            transform: translateX(-5px);
        }

        @media (max-width: 768px) {
            .container {
                margin: 110px 20px 40px;
                padding: 30px;
            }
        }
    </style>
</head>
<body>
    <nav class="header1">
        <a href="{{ route('dashboard') }}" class="back-link">
            <i class="fas fa-arrow-left"></i> Back to Dashboard
        </a>
    </nav>

    <div class="container">
        <div class="profile-header">
            <img src="{{ asset('pics/guest-removebg-preview.png') }}" alt="Profile Picture" class="profile-picture">
            <h2 class="profile-name">{{ $user->first_name }} {{ $user->last_name }}</h2>
            <p class="profile-type">{{ $user->membership_level }} Member</p>
        </div>

        <div class="info-section">
            <div class="info-group">
                <i class="fas fa-envelope"></i>
                <span class="info-label">Email</span>
                <span class="info-value">{{ $user->email }}</span>
            </div>

            <div class="info-group">
                <i class="fas fa-phone"></i>
                <span class="info-label">Phone</span>
                <span class="info-value">{{ $user->phone }}</span>
            </div>

            <div class="info-group">
                <i class="fas fa-birthday-cake"></i>
                <span class="info-label">Date of Birth</span>
                <span class="info-value">{{ $user->date_of_birth }}</span>
            </div>

            <div class="info-group">
                <i class="fas fa-venus-mars"></i>
                <span class="info-label">Gender</span>
                <span class="info-value">
                    @if($user->gender == '1' || strtolower($user->gender) == 'male')
                        Male
                    @elseif($user->gender == '2' || strtolower($user->gender) == 'female')
                        Female
                    @else
                        Not Specified
                    @endif
                </span>
            </div>

            <div class="info-group">
                <i class="fas fa-award"></i>
                <span class="info-label">Reward Points</span>
                <span class="info-value">{{ number_format($user->reward_point) }} points</span>
            </div>
        </div>

        <div style="text-align: center;">
            <a href="{{ route('user.edit') }}" class="edit-button">
                <i class="fas fa-edit"></i> Edit Profile
            </a>
        </div>
    </div>
</body>
</html>