<!DOCTYPE html>
<html>
<head>
    <title>Edit Profile - Bachao Airlines</title>
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

        .profile-header h2 {
            color: #2c3e50;
            font-size: 2em;
            margin-bottom: 10px;
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

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 15px;
            border: 2px solid #e1e8ed;
            border-radius: 12px;
            font-size: 1em;
            transition: all 0.3s ease;
            box-sizing: border-box;
            background: #f8f9fa;
        }

        .form-group input:focus,
        .form-group select:focus {
            border-color: #2da0a8;
            outline: none;
            box-shadow: 0 0 0 3px rgba(45, 160, 168, 0.1);
            background: white;
        }

        .form-group i {
            position: absolute;
            right: 15px;
            top: 45px;
            color: #95a5a6;
        }

        .save-button {
            background: linear-gradient(to right, #5c6bc0, #2da0a8);
            color: white;
            border: none;
            padding: 15px 40px;
            border-radius: 12px;
            font-size: 1em;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            width: 100%;
            margin-top: 20px;
        }

        .save-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(45, 160, 168, 0.3);
        }

        .back-link {
            color: white;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .back-link:hover {
            transform: translateX(-5px);
            opacity: 0.9;
        }

        .alert {
            padding: 15px 20px;
            border-radius: 12px;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 10px;
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

        .error {
            color: #e74c3c;
            font-size: 0.9em;
            margin-top: 5px;
        }

        @media (max-width: 768px) {
            .container {
                margin: 110px 20px 40px;
                padding: 30px;
            }
        }

        .password-section h3 {
            position: relative;
        }

        .password-section h3:after {
            content: '';
            display: block;
            width: 50px;
            height: 3px;
            background: linear-gradient(to right, #5c6bc0, #2da0a8);
            margin-top: 10px;
        }

        .form-group input[type="password"] {
            padding-right: 40px;
        }

        .form-group input[type="password"]:focus + i {
            color: #2da0a8;
        }
    </style>
</head>
<body>
    <nav class="header1">
        <a href="{{ route('user.profile') }}" class="back-link">
            <i class="fas fa-arrow-left"></i> Back to Profile
        </a>
    </nav>

    <div class="container">
        <div class="profile-header">
            <img src="{{ asset('pics/guest-removebg-preview.png') }}" alt="Profile Picture" class="profile-picture">
            <h2>Edit Profile</h2>
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
                    <strong>Please check the following:</strong>
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <form method="POST" action="{{ route('user.update') }}">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label for="first_name">First Name</label>
                <input type="text" id="first_name" name="first_name" value="{{ old('first_name', $user->first_name) }}" required>
                <i class="fas fa-user"></i>
                @error('first_name')<span class="error">{{ $message }}</span>@enderror
            </div>

            <div class="form-group">
                <label for="last_name">Last Name</label>
                <input type="text" id="last_name" name="last_name" value="{{ old('last_name', $user->last_name) }}" required>
                <i class="fas fa-user"></i>
                @error('last_name')<span class="error">{{ $message }}</span>@enderror
            </div>

            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input type="tel" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" required>
                <i class="fas fa-phone"></i>
                @error('phone')<span class="error">{{ $message }}</span>@enderror
            </div>

            <div class="form-group">
                <label for="date_of_birth">Date of Birth</label>
                <input type="date" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth', $user->date_of_birth) }}" required>
                <i class="fas fa-calendar"></i>
                @error('date_of_birth')<span class="error">{{ $message }}</span>@enderror
            </div>

            <div class="form-group">
                <label for="gender">Gender</label>
                <select id="gender" name="gender" required>
                    <option value="1" {{ old('gender', $user->gender) == 1 ? 'selected' : '' }}>Male</option>
                    <option value="2" {{ old('gender', $user->gender) == 2 ? 'selected' : '' }}>Female</option>
                </select>
                <i class="fas fa-venus-mars"></i>
                @error('gender')<span class="error">{{ $message }}</span>@enderror
            </div>

            <div class="password-section">
                <h3 style="color: #2c3e50; margin: 30px 0 20px; padding-top: 20px; border-top: 1px solid #eee;">
                    Change Password
                </h3>

                <div class="form-group">
                    <label for="current_password">Current Password</label>
                    <input type="password" id="current_password" name="current_password">
                    <i class="fas fa-lock"></i>
                    @error('current_password')<span class="error">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label for="new_password">New Password</label>
                    <input type="password" id="new_password" name="new_password">
                    <i class="fas fa-key"></i>
                    @error('new_password')<span class="error">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label for="new_password_confirmation">Confirm New Password</label>
                    <input type="password" id="new_password_confirmation" name="new_password_confirmation">
                    <i class="fas fa-check-circle"></i>
                    @error('new_password_confirmation')<span class="error">{{ $message }}</span>@enderror
                </div>
            </div>

            <button type="submit" class="save-button">
                <i class="fas fa-save"></i> Save Changes
            </button>
        </form>
    </div>
</body>
</html>