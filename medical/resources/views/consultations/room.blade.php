@extends('layouts.app')

@section('content')
<div class="consultation-room">
    <div class="room-header">
        <a href="{{ route('consultations.index') }}" class="back-link">
            <i class="fas fa-arrow-left"></i> Back to Consultations
        </a>
        <h1>Consultation with {{ $appointment->role === 'doctor' ? $appointment->patient_name : 'Dr. ' . $appointment->doctor_name }}</h1>
    </div>
    
    <div class="video-container">
        <div id="remote-media"></div>
        <div id="local-media"></div>
        <div class="connecting-message" id="connecting-message">
            <i class="fas fa-circle-notch fa-spin"></i>
            <span>Connecting to video call...</span>
        </div>
    </div>

    <div class="consultation-controls">
        <button onclick="toggleAudio()" class="control-btn" id="audio-btn" title="Toggle Microphone">
            <i class="fas fa-microphone"></i>
        </button>
        <button onclick="toggleVideo()" class="control-btn" id="video-btn" title="Toggle Camera">
            <i class="fas fa-video"></i>
        </button>
        <button onclick="endCall()" class="control-btn end-call" title="End Call">
            <i class="fas fa-phone-slash"></i>
        </button>
    </div>
</div>

<script>
let videoRoom;
let localTracks = [];

async function initializeVideo() {
    try {
        console.log('Initializing video...');
        
        // First request camera and microphone permissions with higher quality settings
        localTracks = await Twilio.Video.createLocalTracks({
            audio: { 
                noiseSuppression: true,
                echoCancellation: true
            },
            video: { 
                width: 1280,
                height: 720,
                frameRate: 24
            }
        });

        console.log('Local tracks created:', localTracks);

        // Show local video preview immediately
        const localMediaContainer = document.getElementById('local-media');
        localTracks.forEach(track => {
            const element = track.attach();
            if (track.kind === 'video') {
                element.style.transform = 'scaleX(-1)'; // Mirror local video
            }
            localMediaContainer.appendChild(element);
            console.log(`Local ${track.kind} track attached`);
        });

        // Standardize room name to match server format
        const roomName = 'consultation_' + '{{ $appointment->id }}';
        console.log('Requesting token for room:', roomName);
        
        const response = await fetch('{{ route("video.token") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                roomName: roomName
            })
        });

        if (!response.ok) {
            const errorText = await response.text();
            console.error('Token request failed:', response.status, errorText);
            throw new Error(`Failed to get token: ${response.status} ${errorText}`);
        }

        const data = await response.json();
        console.log('Attempting to connect to room:', roomName);

        // Hide connecting message when connected
        document.getElementById('connecting-message').style.display = 'none';
        
        Twilio.Video.connect(data.token, {
            name: roomName,
            video: { 
                width: 640,
                height: 480,
                frameRate: 24
            },
            audio: true,
            bandwidthProfile: {
                video: {
                    mode: 'collaboration',
                    maxSubscriptionBitrate: 2500000,
                    dominantSpeakerPriority: 'high'
                }
            },
            networkQuality: {
                local: 1,
                remote: 1
            },
            maxAudioBitrate: 16000
        }).then(room => {
            console.log('Successfully joined room:', room.name);
            
            // Save room reference
            window.room = room;

            // Handle local participant
            setupLocalParticipant(room.localParticipant);

            // Handle already connected participants
            room.participants.forEach(participant => {
                console.log('Already connected participant:', participant.identity);
                handleParticipantConnected(participant);
            });

            // Handle participants joining
            room.on('participantConnected', participant => {
                console.log('A new participant connected:', participant.identity);
                handleParticipantConnected(participant);
            });

            // Handle participants leaving
            room.on('participantDisconnected', participant => {
                console.log('Participant disconnected:', participant.identity);
                const participantDiv = document.getElementById(participant.identity);
                if (participantDiv) {
                    participantDiv.remove();
                }
            });

            // Handle room disconnection
            room.on('disconnected', (room, error) => {
                console.log('Disconnected from room:', error || 'No error');
                cleanup();
            });

        }).catch(error => {
            console.error('Unable to connect to room:', error);
            alert('Unable to connect to the video room: ' + error.message);
        });

    } catch (error) {
        console.error('Failed to connect to video room:', error);
        document.getElementById('connecting-message').innerHTML = `
            <i class="fas fa-exclamation-circle"></i>
            <span>Failed to connect: ${error.message}</span>
        `;
        if (error.name === 'NotAllowedError') {
            alert('Please allow camera and microphone access to use video consultation.');
        } else {
            alert('Failed to connect to video room: ' + error.message);
        }
    }
}

function setupLocalParticipant(participant) {
    console.log('Setting up local participant:', participant.identity);
    
    const localDiv = document.createElement('div');
    localDiv.setAttribute('id', 'local-participant');
    localDiv.classList.add('participant');
    document.getElementById('local-media').appendChild(localDiv);

    participant.tracks.forEach(publication => {
        if (publication.track) {
            const element = publication.track.attach();
            element.id = `local-${publication.track.kind}`;
            
            if (publication.track.kind === 'video') {
                element.style.width = '100%';
                element.style.height = '100%';
                element.style.objectFit = 'cover';
                localDiv.style.display = 'flex';
                localDiv.style.alignItems = 'center';
                localDiv.style.justifyContent = 'center';
            }
            
            localDiv.appendChild(element);
            console.log(`Local ${publication.track.kind} track attached`);
        }
    });
}

function handleParticipantConnected(participant) {
    console.log('Setting up participant:', participant.identity);
    
    // Create a div for this participant's tracks
    const participantDiv = document.createElement('div');
    participantDiv.setAttribute('id', participant.identity);
    participantDiv.classList.add('participant');
    document.getElementById('remote-media').appendChild(participantDiv);

    // Handle any tracks that are already subscribed
    participant.tracks.forEach(publication => {
        console.log('Checking publication:', publication.kind, publication.isSubscribed);
        if (publication.isSubscribed) {
            handleTrackSubscribed(publication.track, participant);
        }
    });

    // Handle track subscription events
    participant.on('trackSubscribed', track => {
        console.log('New track subscribed:', track.kind);
        handleTrackSubscribed(track, participant);
    });

    // Handle track publication events
    participant.on('trackPublished', publication => {
        console.log('Track published by participant:', publication.kind);
        // Subscribe to the track if it's not already subscribed
        if (!publication.isSubscribed) {
            publication.on('subscribed', track => {
                console.log('Track subscription succeeded:', track.kind);
                handleTrackSubscribed(track, participant);
            });
            publication.on('subscriptionFailed', error => {
                console.error('Track subscription failed:', error);
            });
        }
    });

    participant.on('trackUnpublished', publication => {
        console.log('Track was unpublished:', publication.kind);
    });

    participant.on('trackUnsubscribed', track => {
        console.log('Track unsubscribed:', track.kind);
        handleTrackUnsubscribed(track);
    });
}

function handleParticipantDisconnected(participant) {
    console.log('Removing participant:', participant.identity);
    const participantDiv = document.getElementById(participant.identity);
    if (participantDiv) {
        participantDiv.remove();
    }
}

function handleTrackSubscribed(track, participant) {
    console.log('Attaching track:', track.kind, 'from participant:', participant.identity);
    const participantDiv = document.getElementById(participant.identity);
    if (participantDiv) {
        const element = track.attach();
        element.id = `track-${participant.identity}-${track.kind}`;
        
        if (track.kind === 'video') {
            element.style.width = '100%';
            element.style.height = '100%';
            element.style.objectFit = 'cover'; // Changed to cover for better video display
            participantDiv.style.display = 'flex';
            participantDiv.style.alignItems = 'center';
            participantDiv.style.justifyContent = 'center';
        } else if (track.kind === 'audio') {
            element.style.display = 'none'; // Hide audio elements but keep them in DOM
        }
        
        participantDiv.appendChild(element);
        console.log(`${track.kind} track attached for participant:`, participant.identity);
    } else {
        console.error('Could not find participant div for:', participant.identity);
    }
}

function handleTrackUnsubscribed(track) {
    console.log('Detaching track:', track.kind);
    const elements = track.detach();
    elements.forEach(element => {
        console.log('Removing track element:', element.id);
        element.remove();
    });
}

function highlightDominantSpeaker(participant) {
    // Remove highlight from all participant divs
    document.querySelectorAll('.participant').forEach(div => {
        div.classList.remove('dominant-speaker');
    });
    
    // Add highlight to current dominant speaker
    const participantDiv = document.getElementById(participant.identity);
    if (participantDiv) {
        participantDiv.classList.add('dominant-speaker');
    }
}

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

function endCall() {
    if (videoRoom) {
        videoRoom.disconnect();
        localTracks.forEach(track => track.stop());
    }
    window.location.href = '{{ route("consultations.index") }}';
}

// Initialize when page loads
window.addEventListener('load', initializeVideo);

// Clean up when leaving
window.addEventListener('beforeunload', () => {
    if (videoRoom) {
        videoRoom.disconnect();
    }
    localTracks.forEach(track => track.stop());
});
</script>

<style>
.consultation-room {
    background: white;
    border-radius: 20px;
    padding: 25px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    margin: 20px auto;
    max-width: 1400px;
}

.room-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.back-link {
    color: #666;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 8px;
}

.back-link:hover {
    color: #333;
}

.video-container {
    position: relative;
    height: calc(100vh - 250px);
    min-height: 600px;
    background: #1a1a1a;
    border-radius: 12px;
    overflow: hidden;
    margin-bottom: 20px;
}

.connecting-message {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    color: white;
    font-size: 1.2em;
    display: flex;
    align-items: center;
    gap: 10px;
    z-index: 100;
}

.connecting-message i {
    font-size: 1.5em;
}

#remote-media {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.participant {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}

.participant.dominant-speaker {
    border: 2px solid #4CAF50;
}

#local-media {
    position: absolute;
    bottom: 20px;
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

.consultation-controls {
    display: flex;
    justify-content: center;
    gap: 20px;
    margin-top: 20px;
}

.control-btn {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    border: none;
    background: #f0f0f0;
    color: #333;
    font-size: 1.2em;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
}

.control-btn:hover {
    background: #e0e0e0;
    transform: translateY(-2px);
}

.control-btn.end-call {
    background: #ff4444;
    color: white;
}

.control-btn.end-call:hover {
    background: #ff0000;
}

video {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
}
</style>
@endsection
