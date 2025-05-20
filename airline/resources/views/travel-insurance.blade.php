@extends('layouts.app')

@section('content')
    <a href="{{ route('dashboard') }}" class="back-btn">
        <i class="fas fa-arrow-left"></i> Back to Dashboard
    </a>
    
    <div class="insurance-container">
        <h1>Travel Insurance Plans</h1>
        <div class="insurance-plans">
            <div class="plan-card">
                <div class="plan-title">Basic Coverage</div>
                <div class="plan-price">৳500</div>
                <ul class="plan-features">
                    <li><i class="fas fa-check"></i> Medical emergencies up to ৳50,000</li>
                    <li><i class="fas fa-check"></i> Lost baggage compensation</li>
                    <li><i class="fas fa-check"></i> Flight delay coverage</li>
                </ul>
            </div>
            
            <div class="plan-card">
                <div class="plan-title">Premium Coverage</div>
                <div class="plan-price">৳1,000</div>
                <ul class="plan-features">
                    <li><i class="fas fa-check"></i> Medical emergencies up to ৳100,000</li>
                    <li><i class="fas fa-check"></i> Lost baggage compensation</li>
                    <li><i class="fas fa-check"></i> Flight delay coverage</li>
                    <li><i class="fas fa-check"></i> Trip cancellation protection</li>
                    <li><i class="fas fa-check"></i> 24/7 emergency assistance</li>
                </ul>
            </div>
            
            <div class="plan-card">
                <div class="plan-title">Elite Coverage</div>
                <div class="plan-price">৳2,000</div>
                <ul class="plan-features">
                    <li><i class="fas fa-check"></i> Medical emergencies up to ৳200,000</li>
                    <li><i class="fas fa-check"></i> Lost baggage compensation</li>
                    <li><i class="fas fa-check"></i> Flight delay coverage</li>
                    <li><i class="fas fa-check"></i> Trip cancellation protection</li>
                    <li><i class="fas fa-check"></i> 24/7 emergency assistance</li>
                    <li><i class="fas fa-check"></i> Adventure sports coverage</li>
                    <li><i class="fas fa-check"></i> Family protection plan</li>
                </ul>
            </div>
        </div>
    </div>
@endsection

@section('styles')
<style>
    body {
        font-family: 'Murecho', sans-serif;
        margin: 0;
        padding: 20px;
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        min-height: 100vh;
    }
    .insurance-container {
        max-width: 1200px;
        margin: 50px auto;
        padding: 20px;
    }
    .insurance-plans {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 30px;
        margin-top: 30px;
    }
    .plan-card {
        background: white;
        border-radius: 15px;
        padding: 30px;
        box-shadow: 0 8px 32px rgba(0,0,0,0.1);
        transition: transform 0.3s ease;
    }
    .plan-card:hover {
        transform: translateY(-5px);
    }
    .plan-title {
        color: #2da0a8;
        font-size: 24px;
        font-weight: 700;
        margin-bottom: 15px;
    }
    .plan-price {
        font-size: 32px;
        color: #FF8C00;
        font-weight: 700;
        margin: 20px 0;
    }
    .plan-features {
        list-style: none;
        padding: 0;
    }
    .plan-features li {
        padding: 10px 0;
        border-bottom: 1px solid #eee;
    }
    .plan-features li i {
        color: #2da0a8;
        margin-right: 10px;
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
</style>
@endsection