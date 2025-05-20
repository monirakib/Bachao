@extends('layouts.app')

@section('content')
<!-- Add CSRF token meta tag -->
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="container-fluid px-4">
    <div class="row">
        <div class="col-md-9">
            <div class="video-container">
                <div id="remote-media"></div>
                <div id="local-media"></div>
                
                <div class="controls-container">
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
        </div>
        
        <div class="col-md-3">
            <div class="patient-info">
                <h5>Patient Information</h5>
                <p><strong>Name:</strong> {{ $appointment->first_name }} {{ $appointment->last_name }}</p>
                <p><strong>Email:</strong> {{ $appointment->email }}</p>
            </div>

            <div class="notes-section">
                <h5>Session Notes</h5>
                <textarea class="form-control mb-3" id="sessionNotes" rows="6"></textarea>
                <button onclick="saveNotes()" class="btn btn-primary w-100">
                    <i class="fas fa-save"></i> Save Notes
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://sdk.twilio.com/js/video/releases/2.26.2/twilio-video.min.js"></script>
<script>
let videoRoom;
let localTracks = [];

async function initializeVideo() {
    try {
        // First request user permissions with optimal settings
        const tracks = await Twilio.Video.createLocalTracks({
            audio: { 
                noiseSuppression: true,
                echoCancellation: true
            },
            video: { 
                width: { min: 640, ideal: 1280, max: 1920 },
                height: { min: 480, ideal: 720, max: 1080 },
                frameRate: { min: 24, max: 30 },
                aspectRatio: 16/9
            }
        });
        
        localTracks = tracks;
        tracks.forEach(track => {
            const localElement = document.getElementById('local-media');
            const mediaElement = track.attach();
            if (track.kind === 'video') {
                mediaElement.style.transform = 'scaleX(-1)'; // Mirror local video
            }
            localElement.appendChild(mediaElement);
        });

        // Get token from server
        const response = await fetch('{{ route("video.token") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                roomName: '{{ $appointment->id }}'
            })
        });

        if (!response.ok) {
            const errorText = await response.text();
            console.error('Token request failed:', response.status, errorText);
            throw new Error(`Failed to get token: ${response.status} ${errorText}`);
        }

        const data = await response.json();
        if (!data.token) {
            console.error('Invalid token response:', data);
            throw new Error('Invalid token response from server');
        }
        
        // Connect to room
        videoRoom = await Twilio.Video.connect(data.token, {
            name: '{{ $appointment->id }}',
            tracks: localTracks
        });

        // Handle remote participant
        videoRoom.participants.forEach(participant => {
            handleParticipantConnected(participant);
        });

        videoRoom.on('participantConnected', handleParticipantConnected);
        videoRoom.on('participantDisconnected', handleParticipantDisconnected);
        
    } catch (error) {
        console.error('Error:', error);
        if (error.name === 'NotAllowedError') {
            alert('Please allow camera and microphone access to use video consultation.');
        } else {
            alert('Failed to connect: ' + error.message);
        }
    }
}

function handleParticipantConnected(participant) {
    participant.tracks.forEach(publication => {
        if (publication.isSubscribed) {
            handleTrackSubscribed(publication.track);
        }
    });

    participant.on('trackSubscribed', handleTrackSubscribed);
}

function handleParticipantDisconnected(participant) {
    participant.tracks.forEach(publication => {
        if (publication.track) {
            const attachedElements = publication.track.detach();
            attachedElements.forEach(element => element.remove());
        }
    });
}

function handleTrackSubscribed(track) {
    const remoteMedia = document.getElementById('remote-media');
    const mediaElement = track.attach();
    
    if (track.kind === 'video') {
        mediaElement.style.objectFit = 'contain';
    }
    
    remoteMedia.appendChild(mediaElement);
}

function handleTrackUnsubscribed(track) {
    track.detach().forEach(element => {
        element.remove();
    });
    
    // Show reconnecting message if no video tracks
    const remoteMedia = document.getElementById('remote-media');
    if (!remoteMedia.querySelector('video')) {
        const message = document.createElement('div');
        message.className = 'reconnecting-message';
        message.innerHTML = '<i class="fas fa-sync-alt fa-spin"></i> Reconnecting...';
        remoteMedia.appendChild(message);
    }
}

function toggleAudio() {
    if (localTracks) {
        localTracks.forEach(track => {
            if (track.kind === 'audio') {
                if (track.isEnabled) {
                    track.disable();
                    document.getElementById('audio-btn').innerHTML = '<i class="fas fa-microphone-slash"></i>';
                } else {
                    track.enable();
                    document.getElementById('audio-btn').innerHTML = '<i class="fas fa-microphone"></i>';
                }
            }
        });
    }
}

function toggleVideo() {
    if (localTracks) {
        localTracks.forEach(track => {
            if (track.kind === 'video') {
                if (track.isEnabled) {
                    track.disable();
                    document.getElementById('video-btn').innerHTML = '<i class="fas fa-video-slash"></i>';
                } else {
                    track.enable();
                    document.getElementById('video-btn').innerHTML = '<i class="fas fa-video"></i>';
                }
            }
        });
    }
}

async function endCall() {
    if (videoRoom) {
        videoRoom.disconnect();
        localTracks.forEach(track => track.stop());
    }
    
    try {
        await fetch('{{ route("doctor.telemedicine.end", $appointment->id) }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });
    } catch (error) {
        console.error('Error ending session:', error);
    }
    
    window.location.href = '{{ route("doctor.telemedicine") }}';
}

// Initialize when page loads
document.addEventListener('DOMContentLoaded', initializeVideo);

// Cleanup when leaving
window.addEventListener('beforeunload', () => {
    if (videoRoom) {
        videoRoom.disconnect();
    }
    localTracks.forEach(track => track.stop());
});
</script>

<style>
.video-container {
    position: relative;
    height: calc(100vh - 250px);
    min-height: 600px;
    background: #1a1a1a;
    border-radius: 12px;
    overflow: hidden;
}

.video-container::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 100px;
    background: linear-gradient(to bottom, rgba(0,0,0,0.5) 0%, transparent 100%);
    pointer-events: none;
    z-index: 5;
}

.video-container::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 150px;
    background: linear-gradient(to top, rgba(0,0,0,0.5) 0%, transparent 100%);
    pointer-events: none;
    z-index: 5;
}

#remote-media {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
}

#remote-media video {
    max-width: 90%;
    max-height: 90%;
    object-fit: contain;
    border-radius: 8px;
}

#local-media {
    position: absolute;
    bottom: 100px;
    right: 20px;
    width: 240px;
    height: 180px;
    border-radius: 12px;
    overflow: hidden;
    z-index: 10;
    background: #2c3e50;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    border: 2px solid rgba(255, 255, 255, 0.1);
    transition: all 0.3s ease;
}

#local-media:hover {
    transform: scale(1.05);
    border-color: rgba(255, 255, 255, 0.3);
}

#local-media video {
    width: 100%;
    height: 100%;
    object-fit: contain;
    transform: scaleX(-1); /* Mirror the local video */
}

.controls-container {
    position: absolute;
    bottom: 20px;
    left: 50%;
    transform: translateX(-50%);
    display: flex;
    gap: 16px;
    padding: 16px;
    background: rgba(0, 0, 0, 0.6);
    backdrop-filter: blur(8px);
    border-radius: 16px;
    z-index: 20;
}

.control-btn {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    border: 2px solid rgba(255, 255, 255, 0.2);
    background: rgba(255, 255, 255, 0.15);
    color: white;
    font-size: 1.4em;
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
}

.control-btn:hover {
    background: rgba(255, 255, 255, 0.25);
    border-color: rgba(255, 255, 255, 0.4);
    transform: scale(1.05);
}

.control-btn:active {
    transform: scale(0.95);
}

.control-btn.end-call {
    background: rgba(220, 38, 38, 0.8);
    border-color: rgba(255, 255, 255, 0.2);
}

.control-btn.end-call:hover {
    background: rgb(220, 38, 38);
    border-color: rgba(255, 255, 255, 0.4);
}

.reconnecting-message {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: rgba(0, 0, 0, 0.8);
    color: white;
    padding: 16px 24px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 1.2em;
}

.reconnecting-message i {
    color: #60a5fa;
}

.error-message {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: rgba(220, 38, 38, 0.9);
    color: white;
    padding: 16px 24px;
    border-radius: 8px;
    text-align: center;
    max-width: 80%;
}

/* Patient info panel styling */
.patient-info {
    background: white;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    margin-bottom: 20px;
}

.notes-section {
    background: white;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}
</style>
@endpush
@endsection