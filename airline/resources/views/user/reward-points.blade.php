@extends('layouts.app')

@section('content')
<style>
    body {
        font-family: 'Murecho', sans-serif;
        margin: 0;
        padding: 20px;
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    }
    .points-container {
        max-width: 800px;
        margin: 50px auto;
        background: white;
        padding: 30px;
        border-radius: 15px;
        box-shadow: 0 8px 32px rgba(0,0,0,0.1);
    }
    .points-header {
        text-align: center;
        color: #2da0a8;
        margin-bottom: 30px;
    }
    .points-display {
        font-size: 48px;
        text-align: center;
        color: #FF8C00;
        margin: 20px 0;
    }
    .points-info {
        text-align: center;
        color: #666;
        margin: 20px 0;
    }
    .back-btn {
        position: fixed;
        top: 20px;
        left: 20px;
        background: rgba(255, 140, 0, 0.9);
        color: white;
        padding: 12px 25px;
        border-radius: 25px;
        text-decoration: none;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
    }
    .back-btn:hover {
        transform: translateX(-5px);
    }
    .membership-badge {
        text-align: center;
        margin: 20px 0;
        padding: 20px;
        border-radius: 10px;
        background: linear-gradient(145deg, #ffffff, #f5f7fa);
    }

    .badge-icon {
        font-size: 48px;
        margin-bottom: 10px;
    }

    .bronze { color: #cd7f32; }
    .silver { color: #c0c0c0; }
    .gold { color: #ffd700; }

    .benefits-list {
        list-style: none;
        padding: 0;
        margin: 20px 0;
    }

    .benefits-list li {
        padding: 10px;
        margin: 5px 0;
        background: rgba(45, 160, 168, 0.1);
        border-radius: 5px;
    }

    .level-progress {
        background: #eee;
        height: 10px;
        border-radius: 5px;
        margin: 20px 0;
    }

    .progress-bar {
        height: 100%;
        border-radius: 5px;
        background: #2da0a8;
        transition: width 0.3s ease;
    }
</style>
<div class="points-container">
    <a href="{{ route('dashboard') }}" class="back-btn">
        <i class="fas fa-arrow-left"></i> Back to Dashboard
    </a>

    <div class="points-header">
        <h1>Your Rewards Status</h1>
    </div>
    
    <div class="membership-badge">
        @php
            $icon = match($membership_level) {
                'Gold' => 'crown',
                'Silver' => 'medal',
                default => 'award'
            };
        @endphp
        <i class="fas fa-{{ $icon }} badge-icon {{ strtolower($membership_level) }}"></i>
        <h2>{{ $membership_level }} Member</h2>
    </div>

    <div class="points-display">
        {{ number_format($total_points) }} Points
    </div>

    <div class="benefits-list">
        <h3>Your Benefits:</h3>
        <ul>
            @foreach($benefits[$membership_level] as $benefit)
                <li><i class="fas fa-check"></i> {{ $benefit }}</li>
            @endforeach
        </ul>
    </div>
    
    <div class="points-info">
        <p>Earn points by:</p>
        <ul>
            <li>Booking a flight (+100 points)</li>
            <li>Logging in daily (+20 points)</li>
        </ul>
    </div>
</div>
@endsection