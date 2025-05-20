<!DOCTYPE html>
<html>
<head>
    <title>Telemedicine Consultation</title>
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

        .container {
            margin-top: 120px;
            padding: 20px;
            max-width: 1200px;
            margin-left: auto;
            margin-right: auto;
        }

        .telemedicine-grid {
            display: grid;
            grid-template-columns: 1fr 2fr;
            gap: 20px;
        }

        .doctors-list {
            background: white;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            max-height: calc(100vh - 160px);
            overflow-y: auto;
        }

        .video-section {
            background: white;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .doctor-card {
            border: 1px solid #e1e1e1;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 15px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .doctor-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .doctor-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .doctor-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: #e74c3c;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 24px;
        }

        .doctor-details h3 {
            margin: 0;
            color: #2c3e50;
        }

        .doctor-status {
            color: #27ae60;
            font-size: 0.9em;
        }

        .video-container {
            aspect-ratio: 16/9;
            background: #2c3e50;
            border-radius: 10px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }

        .video-controls {
            display: flex;
            gap: 10px;
            justify-content: center;
        }

        .control-button {
            padding: 12px;
            border: none;
            border-radius: 50%;
            background: #e74c3c;
            color: white;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .control-button:hover {
            transform: scale(1.1);
            background: #c0392b;
        }

        .chat-section {
            margin-top: 20px;
            border-top: 1px solid #e1e1e1;
            padding-top: 20px;
        }

        .chat-messages {
            height: 200px;
            overflow-y: auto;
            padding: 10px;
            border: 1px solid #e1e1e1;
            border-radius: 10px;
            margin-bottom: 10px;
        }

        .chat-input {
            display: flex;
            gap: 10px;
        }

        .chat-input input {
            flex: 1;
            padding: 10px;
            border: 1px solid #e1e1e1;
            border-radius: 5px;
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

        .send-button {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            background: #e74c3c;
            color: white;
            cursor: pointer;
        }

        .error-message {
            background: #fee2e2;
            border: 1px solid #ef4444;
            color: #dc2626;
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
            text-align: center;
        }
        .logo img {
            height: 120px;
            width: 100px;
        }
    </style>
</head>
<body>
    <nav class="header1">
        <div class="logo">
            <img src="{{ asset('pics/medical/medichain_logo.png') }}" alt="Logo">
        </div>
        <div class="user-section">
            <a href="{{ route('dashboard') }}" class="back-button">
                <i class="fas fa-arrow-left"></i> Back to Dashboard
            </a>
            <span style="color: white;">Welcome, {{ Auth::user()->first_name }}</span>
        </div>
    </nav>

    <div class="container">
        <div class="telemedicine-grid">
            <div class="doctors-list">
                <h2><i class="fas fa-user-md"></i> Available Doctors</h2>
                
                @if(isset($error_message))
                    <div class="error-message">
                        {{ $error_message }}
                    </div>
                @else
                    @php
                        // Example doctor data, replace with $doctors from your controller
                        $doctors = [
                            ['name' => 'Dr. Alice Smith', 'specialization' => 'Cardiologist'],
                            ['name' => 'Dr. Bob Lee', 'specialization' => 'Dermatologist'],
                            ['name' => 'Dr. Carol Jones', 'specialization' => 'General Physician'],
                        ];
                    @endphp
                    @foreach($doctors as $doctor)
                        <div class="doctor-card" onclick="startConsultation('{{ $doctor['name'] }}')">
                            <div class="doctor-info">
                                <div class="doctor-avatar">
                                    {{ strtoupper(substr($doctor['name'], 0, 2)) }}
                                </div>
                                <div class="doctor-details">
                                    <h3>{{ $doctor['name'] }}</h3>
                                    <p>{{ $doctor['specialization'] }}</p>
                                    <span class="doctor-status">
                                        <i class="fas fa-circle"></i> Available Now
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>

            <div class="video-section">
                <div class="video-container">
                    <div id="waiting-message">
                        <i class="fas fa-video fa-3x"></i>
                        <p>Select a doctor to start consultation</p>
                    </div>
                </div>

                <div class="video-controls">
                    <button class="control-button" title="Mute">
                        <i class="fas fa-microphone"></i>
                    </button>
                    <button class="control-button" title="Video">
                        <i class="fas fa-video"></i>
                    </button>
                    <button class="control-button" title="End Call">
                        <i class="fas fa-phone-slash"></i>
                    </button>
                </div>

                <div class="chat-section">
                    <h3>Chat</h3>
                    <div class="chat-messages" id="chatMessages"></div>
                    <div class="chat-input">
                        <input type="text" id="messageInput" placeholder="Type your message...">
                        <button class="send-button">
                            <i class="fas fa-paper-plane"></i> Send
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function startConsultation(doctorName) {
            document.getElementById('waiting-message').innerHTML = `
                <i class="fas fa-spinner fa-spin fa-3x"></i>
                <p>Connecting to ${doctorName}...</p>
            `;
            
            setTimeout(() => {
                alert(`Starting consultation with ${doctorName}. Video call will begin shortly.`);
            }, 1500);
        }

        document.querySelector('.send-button').addEventListener('click', () => {
            const input = document.getElementById('messageInput');
            const messages = document.getElementById('chatMessages');
            
            if (input.value.trim()) {
                messages.innerHTML += `
                    <p><strong>You:</strong> ${input.value}</p>
                `;
                input.value = '';
                messages.scrollTop = messages.scrollHeight;
            }
        });

        // Video controls functionality
        document.querySelectorAll('.control-button').forEach(button => {
            button.addEventListener('click', function() {
                const icon = this.querySelector('i');
                if (icon.classList.contains('fa-microphone')) {
                    icon.classList.toggle('fa-microphone-slash');
                } else if (icon.classList.contains('fa-video')) {
                    icon.classList.toggle('fa-video-slash');
                } else if (icon.classList.contains('fa-phone-slash')) {
                    if (confirm('Are you sure you want to end the consultation?')) {
                        window.location.reload();
                    }
                }
            });
        });
    </script>
</body>
</html>