<!DOCTYPE html>
<html>
<head>
    <title>Book Emergency Ambulance - Medical Services</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Murecho:wght@100..900&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Murecho', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            color: #2c3e50;
        }

        .header1 {
            background: linear-gradient(to right, #dd2476, #ff512f);
            height: 70px;
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
            height: 45px;
            transition: transform 0.3s ease;
        }

        .logo img:hover {
            transform: scale(1.05);
        }

        .user-section {
            color: white;
            font-weight: 500;
            font-size: 0.95em;
        }

        .container {
            max-width: 650px;
            margin: 100px auto 40px;
            padding: 20px;
        }

        .ambulance-form {
            background: white;
            border-radius: 20px;
            padding: 35px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        .ambulance-form h2 {
            color: #dd2476;
            margin: 0 0 30px 0;
            font-size: 2em;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            margin-bottom: 10px;
            color: #2c3e50;
            font-weight: 600;
            font-size: 0.95em;
        }

        .form-group select,
        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 14px;
            border: 2px solid #e1e8ed;
            border-radius: 12px;
            font-size: 1em;
            transition: all 0.3s ease;
            background: #f8fafc;
            color: #2c3e50;
        }

        .form-group select:focus,
        .form-group input:focus,
        .form-group textarea:focus {
            border-color: #dd2476;
            outline: none;
            box-shadow: 0 0 0 4px rgba(221, 36, 118, 0.1);
            background: white;
        }

        .form-group select option {
            padding: 10px;
        }

        .ambulance-type-selector {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-top: 5px;
        }

        .radio-label {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 15px;
            border: 2px solid #e1e8ed;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            background: #f8fafc;
        }

        .radio-label:hover {
            border-color: #dd2476;
            background: white;
        }

        .radio-label input[type="radio"] {
            display: none;
        }

        .radio-label input[type="radio"]:checked + span {
            color: #dd2476;
            font-weight: 600;
        }

        .radio-label input[type="radio"]:checked + span i {
            transform: scale(1.2);
        }

        .radio-label span {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.95em;
        }

        .radio-label span i {
            font-size: 1.2em;
            transition: transform 0.3s ease;
        }

        .emergency-button {
            background: linear-gradient(to right, #dd2476, #ff512f);
            color: white;
            border: none;
            padding: 16px 30px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 1.1em;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            margin-top: 10px;
        }

        .emergency-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(221, 36, 118, 0.4);
        }

        .back-link {
            color: #dd2476;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 25px;
            font-weight: 500;
            padding: 8px 15px;
            border-radius: 8px;
            transition: all 0.3s ease;
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .back-link:hover {
            transform: translateX(-5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.15);
        }

        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 20px 25px;
            border-radius: 12px;
            background: white;
            box-shadow: 0 5px 20px rgba(0,0,0,0.15);
            display: flex;
            align-items: center;
            gap: 12px;
            z-index: 1000;
            transition: all 0.3s ease;
            transform: translateX(120%);
            opacity: 0;
            min-width: 300px;
            max-width: 500px;
        }

        .notification.show {
            transform: translateX(0);
            opacity: 1;
        }

        .notification.success {
            border-left: 4px solid #2ecc71;
        }

        .notification.success i {
            color: #2ecc71;
            font-size: 1.2em;
        }

        .notification.error {
            border-left: 4px solid #e74c3c;
        }

        .notification.error i {
            color: #e74c3c;
            font-size: 1.2em;
        }

        @media (max-width: 768px) {
            .container {
                padding: 15px;
                margin-top: 90px;
            }

            .ambulance-form {
                padding: 25px;
            }

            .ambulance-type-selector {
                grid-template-columns: 1fr;
            }

            .header1 {
                padding: 0 20px;
            }

            .notification {
                top: auto;
                bottom: 20px;
                left: 20px;
                right: 20px;
                min-width: auto;
            }
        }
    </style>
</head>
<body>
    <nav class="header1">
        @include('layouts.header')
            <span>Welcome, {{ Auth::user()->first_name }}</span>
        </div>
    </nav>

    <div class="container">
        <a href="{{ route('emergency.index') }}" class="back-link">
            <i class="fas fa-arrow-left"></i> Back to Emergency Services
        </a>
        <div class="ambulance-form">
            <h2><i class="fas fa-ambulance"></i> Book Emergency Ambulance</h2>
            <form id="emergencyForm">
                @csrf
                <div class="form-group">
                    <label>Select Hospital</label>
                    <select name="hospital_id" required>
                        <option value="">Choose a hospital</option>
                        @foreach($hospitals as $hospital)
                            <option value="{{ $hospital->id }}">
                                {{ $hospital->name }} 
                                ({{ $hospital->available_beds }} beds, 
                                {{ $hospital->normal_ambulances }} normal ambulances, 
                                {{ $hospital->air_ambulances }} air ambulances available)
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Ambulance Type</label>
                    <div class="ambulance-type-selector">
                        <label class="radio-label">
                            <input type="radio" name="type" value="normal" checked>
                            <span><i class="fas fa-ambulance"></i> Normal Ambulance</span>
                        </label>
                        <label class="radio-label">
                            <input type="radio" name="type" value="air">
                            <span><i class="fas fa-helicopter"></i> Air Ambulance</span>
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <label>Your Location</label>
                    <input type="text" name="pickup_location" placeholder="Enter your current address" required>
                </div>

                <div class="form-group">
                    <label>Emergency Type</label>
                    <input type="text" name="emergency_type" placeholder="Describe the emergency" required>
                </div>

                <div class="form-group">
                    <label>Additional Notes</label>
                    <textarea name="notes" placeholder="Any additional information that might help"></textarea>
                </div>

                <button type="submit" class="emergency-button">
                    <i class="fas fa-phone-alt"></i> Request Emergency Service
                </button>
            </form>
        </div>
    </div>

    <script>
        function showNotification(message, type = 'success') {
            const notification = document.getElementById('notification');
            const icon = notification.querySelector('i');
            const messageEl = document.getElementById('notificationMessage');
            
            // Set icon and class based on type
            if (type === 'success') {
                icon.className = 'fas fa-check-circle';
                notification.className = 'notification success show';
            } else {
                icon.className = 'fas fa-exclamation-circle';
                notification.className = 'notification error show';
            }
            
            messageEl.textContent = message;
            
            // Hide notification after 5 seconds
            setTimeout(() => {
                notification.classList.remove('show');
            }, 5000);
        }

        document.getElementById('emergencyForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const form = this;
            const formData = new FormData(form);
            const data = {};
            formData.forEach((value, key) => { data[key] = value; });

            // Disable submit button to prevent double submission
            const submitButton = form.querySelector('button[type="submit"]');
            submitButton.disabled = true;

            fetch('{{ route("emergency.book-ambulance") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    hospital_id: data.hospital_id,
                    type: data.type,
                    pickup_location: data.pickup_location,
                    emergency_type: data.emergency_type,
                    notes: data.notes
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification('Your ambulance has been dispatched and is on the way!', 'success');
                    // Redirect after 2 seconds
                    setTimeout(() => {
                        window.location.href = '{{ route("emergency.index") }}';
                    }, 2000);
                } else {
                    showNotification(data.message || 'Failed to request ambulance', 'error');
                    submitButton.disabled = false;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Failed to request ambulance. Please try again.', 'error');
                submitButton.disabled = false;
            });
        });
    </script>
    <div id="notification" class="notification">
        <i class="fas"></i>
        <span id="notificationMessage"></span>
    </div>
</body>
</html>