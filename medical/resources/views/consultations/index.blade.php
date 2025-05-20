<!DOCTYPE html>
<html>
<head>
    <title>Online Consultations - Medical Services</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css2?family=Murecho:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="//sdk.twilio.com/js/video/releases/2.26.2/twilio-video.min.js"></script>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Murecho', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
        }

        .container {
            margin-top: 110px;
            padding: 20px 40px;
            max-width: 1200px;
            margin-left: auto;
            margin-right: auto;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .page-title {
            display: flex;
            align-items: center;
            gap: 15px;
            color: #2c3e50;
        }

        .page-title i {
            font-size: 2em;
            color: #dd2476;
        }

        .page-title h1 {
            margin: 0;
            font-size: 2em;
        }

        .new-consultation-btn {
            background: linear-gradient(to right, #dd2476, #ff512f);
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 25px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .new-consultation-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(221, 36, 118, 0.3);
        }

        .consultations-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 25px;
            margin-top: 20px;
        }

        .consultation-card {
            background: white;
            border-radius: 20px;
            padding: 25px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
        }

        .consultation-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.12);
        }

        .consultation-header {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 1px solid #eee;
        }

        .doctor-avatar {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #dd2476;
            padding: 2px;
        }

        .doctor-info h3 {
            margin: 0;
            color: #2c3e50;
            font-size: 1.2em;
        }

        .doctor-info p {
            margin: 5px 0 0;
            color: #666;
            font-size: 0.9em;
        }

        .consultation-details {
            flex: 1;
            margin-bottom: 20px;
        }

        .detail-row {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 12px;
            color: #2c3e50;
            font-size: 0.95em;
        }

        .detail-row i {
            color: #dd2476;
            width: 20px;
        }

        .status-badge {
            padding: 6px 15px;
            border-radius: 20px;
            font-size: 0.85em;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .status-scheduled {
            background: #e3f2fd;
            color: #1565c0;
        }

        .status-ongoing {
            background: #f0f4c3;
            color: #827717;
        }

        .status-completed {
            background: #e8f5e9;
            color: #2e7d32;
        }

        .card-actions {
            text-align: center;
        }

        .join-button {
            background: linear-gradient(to right, #dd2476, #ff512f);
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 15px;
            width: 80%;
            font-size: 1em;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .join-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(221, 36, 118, 0.3);
        }

        .join-button.completed {
            background: #e8f5e9;
            color: #2e7d32;
            cursor: not-allowed;
        }

        .join-button.completed:hover {
            transform: none;
            box-shadow: none;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            background: white;
            border-radius: 20px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            margin: 40px auto;
            max-width: 500px;
        }

        .empty-state i {
            font-size: 64px;
            color: #dd2476;
            margin-bottom: 20px;
        }

        .empty-state h2 {
            color: #2c3e50;
            margin: 0 0 15px;
        }

        .empty-state p {
            color: #666;
            margin: 0 0 25px;
            font-size: 1.1em;
        }

        @media (max-width: 768px) {
            .container {
                padding: 20px;
            }

            .page-header {
                flex-direction: column;
                gap: 15px;
                text-align: center;
            }

            .consultations-grid {
                grid-template-columns: 1fr;
            }

            .join-button {
                width: 100%;
            }
        }

        .consultation-room {
            background: white;
            border-radius: 20px;
            padding: 25px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        }

        .room-header {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 20px;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #dd2476;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .back-link:hover {
            transform: translateX(-5px);
        }

        .video-container {
            aspect-ratio: 16/9;
            background: #2c3e50;
            border-radius: 10px;
            overflow: hidden;
            margin-bottom: 20px;
        }

        .consultation-controls {
            display: flex;
            gap: 15px;
            justify-content: center;
        }

        .control-btn {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            border: none;
            background: #f8f9fa;
            color: #2c3e50;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .control-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .control-btn.end-call {
            background: #e74c3c;
            color: white;
        }

        #local-media {
            position: absolute;
            bottom: 20px;
            right: 20px;
            width: 200px;
            height: 150px;
            border-radius: 8px;
            overflow: hidden;
            z-index: 10;
        }

        #remote-media {
            width: 100%;
            height: 100%;
            background: #2c3e50;
            border-radius: 10px;
        }

        #local-media video,
        #remote-media video {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
    </style>
</head>
<body>
    @include('layouts.header')

    <div class="container">
        @if(isset($isConsultationRoom) && $isConsultationRoom)
            <!-- Consultation Room View -->
            <div class="consultation-room">
                <div class="room-header">
                    <a href="{{ route('consultations.index') }}" class="back-link">
                        <i class="fas fa-arrow-left"></i> Back to Consultations
                    </a>
                    <h1>Consultation with Dr. {{ $appointment->doctor_name }}</h1>
                </div>
                
                <div class="video-container">
                    <div id="remote-media"></div>
                    <div id="local-media"></div>
                </div>

                <div class="consultation-controls">
                    <button onclick="toggleAudio()" class="control-btn" id="audio-btn">
                        <i class="fas fa-microphone"></i>
                    </button>
                    <button onclick="toggleVideo()" class="control-btn" id="video-btn">
                        <i class="fas fa-video"></i>
                    </button>
                    <button onclick="endCall()" class="control-btn end-call">
                        <i class="fas fa-phone-slash"></i>
                    </button>
                </div>
            </div>

            <script>
                let videoRoom;
                let localTrack;
                
                async function initializeVideo() {
                    try {
                        // Get token from server
                        const response = await fetch('{{ route("video.token") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({
                                roomName: '{{ $appointment->id }}'
                            })
                        });
                        const data = await response.json();
                        
                        // Connect to room
                        videoRoom = await Twilio.Video.connect(data.token, {
                            name: '{{ $appointment->id }}',
                            audio: true,
                            video: true
                        });

                        // Handle local participant
                        videoRoom.localParticipant.tracks.forEach(publication => {
                            if (publication.track) {
                                document.getElementById('local-media').appendChild(
                                    publication.track.attach()
                                );
                            }
                        });

                        // Handle remote participants
                        videoRoom.participants.forEach(participant => {
                            participant.tracks.forEach(publication => {
                                if (publication.isSubscribed) {
                                    document.getElementById('remote-media').appendChild(
                                        publication.track.attach()
                                    );
                                }
                            });
                        });

                        // Handle participant connections
                        videoRoom.on('participantConnected', participant => {
                            participant.tracks.forEach(publication => {
                                if (publication.isSubscribed) {
                                    document.getElementById('remote-media').appendChild(
                                        publication.track.attach()
                                    );
                                }
                            });
                        });

                    } catch (error) {
                        console.error('Failed to connect to video room:', error);
                        alert('Failed to connect to video room. Please try refreshing the page.');
                    }
                }

                // Toggle audio
                function toggleAudio() {
                    if (videoRoom && videoRoom.localParticipant) {
                        videoRoom.localParticipant.audioTracks.forEach(publication => {
                            if (publication.track.isEnabled) {
                                publication.track.disable();
                                document.getElementById('audio-btn').innerHTML = '<i class="fas fa-microphone-slash"></i>';
                            } else {
                                publication.track.enable();
                                document.getElementById('audio-btn').innerHTML = '<i class="fas fa-microphone"></i>';
                            }
                        });
                    }
                }

                // Toggle video
                function toggleVideo() {
                    if (videoRoom && videoRoom.localParticipant) {
                        videoRoom.localParticipant.videoTracks.forEach(publication => {
                            if (publication.track.isEnabled) {
                                publication.track.disable();
                                document.getElementById('video-btn').innerHTML = '<i class="fas fa-video-slash"></i>';
                            } else {
                                publication.track.enable();
                                document.getElementById('video-btn').innerHTML = '<i class="fas fa-video"></i>';
                            }
                        });
                    }
                }

                // End call
                function endCall() {
                    if (videoRoom) {
                        videoRoom.disconnect();
                        window.location.href = '{{ route("consultations.index") }}';
                    }
                }

                // Initialize when page loads
                window.addEventListener('load', initializeVideo);
            </script>
        @else
            <div class="page-header">
                <div class="page-title">
                    <i class="fas fa-video"></i>
                    <h1>My Online Consultations</h1>
                </div>
                <a href="{{ route('appointments.create') }}" class="new-consultation-btn">
                    <i class="fas fa-plus"></i> New Consultation
                </a>
            </div>

            <div class="consultations-grid">
                @forelse($appointments as $appointment)
                    <div class="consultation-card">
                        <div class="consultation-header">
                            <img src="{{ asset('pics/guest-removebg-preview.png') }}" alt="Doctor" class="doctor-avatar">
                            <div class="doctor-info">
                                <h3>Dr. {{ $appointment->doctor_name }}</h3>
                                <p>{{ $appointment->specialization }}</p>
                            </div>
                        </div>

                        <div class="consultation-details">
                            <div class="detail-row">
                                <i class="far fa-calendar"></i>
                                <span>{{ Carbon\Carbon::parse($appointment->date)->format('M d, Y') }}</span>
                            </div>
                            <div class="detail-row">
                                <i class="far fa-clock"></i>
                                <span>{{ Carbon\Carbon::parse($appointment->time)->format('h:i A') }}</span>
                            </div>
                            <div class="detail-row">
                                <i class="fas fa-tag"></i>
                                <span class="status-badge status-{{ $appointment->status }}">
                                    <i class="fas fa-{{ $appointment->status === 'scheduled' ? 'calendar-check' : ($appointment->status === 'ongoing' ? 'video' : 'check-circle') }}"></i>
                                    {{ ucfirst($appointment->status) }}
                                </span>
                            </div>
                        </div>

                        <div class="card-actions">
                            @if($appointment->status !== 'completed')
                                <a href="{{ route('consultation.join', $appointment->id) }}" class="join-button">
                                    <i class="fas fa-video"></i> Join Consultation
                                </a>
                            @else
                                <button class="join-button completed" disabled>
                                    <i class="fas fa-check-circle"></i> Consultation Completed
                                </button>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="empty-state">
                        <i class="fas fa-video-slash"></i>
                        <h2>No Online Consultations</h2>
                        <p>You don't have any upcoming online consultations scheduled.</p>
                        <a href="{{ route('appointments.create') }}" class="join-button">
                            <i class="fas fa-plus"></i> Book a Consultation
                        </a>
                    </div>
                @endforelse
            </div>
        @endif
    </div>
</body>
</html>