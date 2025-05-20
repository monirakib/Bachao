<!DOCTYPE html>
<html>
<head>
    <title>Edit Profile - Medical Services</title>
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
            background: linear-gradient(to right, #dd2476, #ff512f);
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

        .profile-header h2 {
            color: #2c3e50;
            font-size: 2em;
            margin-bottom: 10px;
        }

        .profile-picture {
            width: 120px;
            height: 120px;
            border-radius: 60px;
            margin: 0 auto 20px;
            display: block;
            border: 4px solid #dd2476;
            padding: 3px;
        }

        .form-group {
            margin-bottom: 25px;
            position: relative;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #2c3e50;
            font-weight: 600;
            font-size: 0.9em;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-group input {
            width: 100%;
            padding: 15px;
            border: 2px solid #e1e8ed;
            border-radius: 12px;
            font-size: 1em;
            transition: all 0.3s ease;
            box-sizing: border-box;
            background: #f8f9fa;
        }

        .form-group input:focus {
            border-color: #dd2476;
            outline: none;
            box-shadow: 0 0 0 3px rgba(221, 36, 118, 0.1);
            background: white;
        }

        .form-group i {
            position: absolute;
            right: 15px;
            top: 45px;
            color: #95a5a6;
        }

        .submit-button {
            background: linear-gradient(to right, #dd2476, #ff512f);
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 12px;
            font-size: 1em;
            cursor: pointer;
            transition: all 0.3s ease;
            display: block;
            width: 100%;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: 40px;
        }

        .submit-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(221, 36, 118, 0.3);
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
            color: #dd2476;
            transform: translateX(-5px);
        }

        .alert {
            padding: 15px 20px;
            border-radius: 12px;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert i {
            font-size: 1.2em;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .alert-error ul {
            margin: 5px 0 0 20px;
            padding: 0;
        }

        .alert-error li {
            margin-bottom: 3px;
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
    @include('layouts.header')

    <div class="container">
        {{-- <a href="{{ route('dashboard') }}" class="back-link">
            <i class="fas fa-arrow-left"></i> Back to Dashboard
        </a> --}}

        <div class="profile-header">
            <img src="{{ asset('pics/guest-removebg-preview.png') }}" alt="Profile Picture" class="profile-picture">
            <h2>Edit Your Profile</h2>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle"></i>
                <div>
                    <strong>Oops! There were some problems:</strong>
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <form action="{{ route('profile.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="first_name">First Name</label>
                <input type="text" id="first_name" name="first_name" value="{{ old('first_name', $user->first_name) }}" required>
                <i class="fas fa-user"></i>
            </div>

            <div class="form-group">
                <label for="last_name">Last Name</label>
                <input type="text" id="last_name" name="last_name" value="{{ old('last_name', $user->last_name) }}" required>
                <i class="fas fa-user"></i>
            </div>

            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                <i class="fas fa-envelope"></i>
            </div>

            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input type="tel" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" required>
                <i class="fas fa-phone"></i>
            </div>

            <div class="form-group">
                <label for="address">Address</label>
                <input type="text" id="address" name="address" value="{{ old('address', $user->address) }}" required>
                <i class="fas fa-home"></i>
            </div>

            <hr class="profile-divider" style="margin: 30px 0;">

            <div class="password-section">
                <h3>Change Password</h3>
                <p class="text-muted">Leave password fields empty if you don't want to change it</p>

                <div class="form-group">
                    <label for="current_password">Current Password</label>
                    <input type="password" id="current_password" name="current_password">
                    <i class="fas fa-lock"></i>
                </div>

                <div class="form-group">
                    <label for="new_password">New Password</label>
                    <input type="password" id="new_password" name="new_password">
                    <i class="fas fa-key"></i>
                </div>

                <div class="form-group">
                    <label for="new_password_confirmation">Confirm New Password</label>
                    <input type="password" id="new_password_confirmation" name="new_password_confirmation">
                    <i class="fas fa-check-circle"></i>
                </div>
            </div>

            <button type="submit" class="submit-button">
                <i class="fas fa-save"></i> Update Profile
            </button>
        </form>
    </div>
</body>
</html>