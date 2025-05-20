@extends('layouts.app')

@section('content')
<header class="header">
    <a href="{{ route('dashboard') }}" class="back-btn">
        <i class="fas fa-arrow-left"></i> Back to Dashboard
    </a>
</header>

<div class="container">
    <aside class="sidebar">
        <div class="section">
            <h2>Contact Us</h2>
            <div class="contact-info">
                <i class="fas fa-phone"></i>
                <a href="tel:01855123216">01855123216</a>
            </div>
            <div class="contact-info">
                <i class="fas fa-envelope"></i>
                <a href="mailto:support@bachaoairlines.com">support@bachaoairlines.com</a>
            </div>
        </div>

        <div class="section">
            <h2>Suggest a FAQ</h2>
            <form action="{{ route('faq.suggest') }}" method="POST">
                @csrf
                <div class="form-group">
                    <textarea rows="4" name="question" placeholder="Your question..." class="faq-suggestion"></textarea>
                </div>
                <button type="submit" class="submit-btn">Submit Question</button>
            </form>
        </div>
    </aside>

    <main class="main-content">
        <div class="section">
            <h2>Leave Your Feedback</h2>
            <form method="POST" action="{{ route('feedback.store') }}">
                @csrf
                <div class="form-group">
                    <label for="name">Name *</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required>
                    @error('name')<span class="error">{{ $message }}</span>@enderror
                </div>
                
                <div class="form-group">
                    <label for="contact">Contact Number *</label>
                    <input type="tel" id="contact" name="contact" value="{{ old('contact') }}" required>
                    @error('contact')<span class="error">{{ $message }}</span>@enderror
                </div>
                
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}">
                    @error('email')<span class="error">{{ $message }}</span>@enderror
                </div>
                
                <div class="form-group">
                    <label for="rating">Rating *</label>
                    <select id="rating" name="rating" required>
                        <option value="" disabled {{ !old('rating') ? 'selected' : '' }}>Select a rating</option>
                        @foreach(range(5, 1) as $rating)
                            <option value="{{ $rating }}" {{ old('rating') == $rating ? 'selected' : '' }}>
                                {{ $rating }} - {{ ['Excellent', 'Good', 'Average', 'Poor', 'Very Poor'][5-$rating] }}
                            </option>
                        @endforeach
                    </select>
                    @error('rating')<span class="error">{{ $message }}</span>@enderror
                </div>
                
                <div class="form-group">
                    <label for="comments">Comments</label>
                    <textarea id="comments" name="comments" rows="5">{{ old('comments') }}</textarea>
                    @error('comments')<span class="error">{{ $message }}</span>@enderror
                </div>
                
                <button type="submit" class="submit-btn">Submit Feedback</button>
            </form>
        </div>

        <div class="section">
            <h2>Recent Feedback</h2>
            @forelse($feedbacks as $feedback)
                <div class="feedback-item">
                    <h4>{{ $feedback->name }}</h4>
                    <div class="stars">
                        @for($i = 0; $i < $feedback->rating; $i++)
                            ⭐
                        @endfor
                    </div>
                    <p>{{ $feedback->comments }}</p>
                    <small>Posted on: {{ $feedback->created_at->format('F j, Y') }}</small>
                </div>
            @empty
                <p>No feedback yet</p>
            @endforelse
        </div>

        <div class="section">
            <h2>Frequently Asked Questions</h2>
            @foreach($faqs as $faq)
                <div class="faq-item">
                    <h4>{{ $faq['question'] }}</h4>
                    <p>{{ $faq['answer'] }}</p>
                </div>
            @endforeach
        </div>
    </main>
</div>
@endsection

@section('styles')
<style>
    body {
        font-family: 'Murecho', sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f5f7fa;
        color: #333;
        min-height: 100vh;
    }

    .header {
        background: linear-gradient(to right, #5c6bc0, #2da0a8);
        padding: 1.5rem;  /* Increased from 1rem */
        position: fixed;
        width: 100%;
        top: 0;
        z-index: 1000;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .container {
        max-width: 1200px;
        margin: 80px auto 0;
        padding: 20px;
        display: grid;
        grid-template-columns: 320px 1fr;
        gap: 30px;
    }

    .sidebar {
        background: white;
        border-radius: 15px;
        padding: 20px;
        position: sticky;
        top: 100px;
        height: fit-content;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    .section {
        background: white;
        border-radius: 15px;
        padding: 25px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        margin-bottom: 20px;
        transition: transform 0.2s ease;
        padding-right: 45px;
    }

    .section:hover {
        transform: translateY(-2px);
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        color: #2da0a8;  /* Changed from #4C9DA3 */
        background: linear-gradient(to right, #5c6bc0, #2da0a8);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        font-weight: 600;
    }

    .form-group input,
    .form-group textarea,
    .form-group select {
        width: 100%;
        padding: 12px;
        border: 1px solid #ddd;
        border-radius: 8px;
        transition: border-color 0.2s ease;
    }

    .form-group input:focus,
    .form-group textarea:focus,
    .form-group select:focus {
        border-color: #2da0a8;  /* Changed from #4C9DA3 */
        outline: none;
    }

    .submit-btn {
        background: linear-gradient(to right, #5c6bc0, #2da0a8);  /* Changed from solid color */
        color: white;
        border: none;
        padding: 12px 25px;
        border-radius: 25px;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .submit-btn:hover {
        background: linear-gradient(to right, #4a56a3, #248f96);  /* Darker gradient for hover */
        transform: translateY(-2px);
    }

    .feedback-item {
        border-bottom: 1px solid #eee;
        padding: 15px;
        margin: 10px 0;
    }

    .stars {
        color: #2da0a8;  /* Changed from #4C9DA3 */
        font-size: 18px;
        margin: 5px 0;
    }

    .back-btn {
        color: white;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-weight: 600;
        padding: 8px 15px;
        border-radius: 20px;
        background: rgba(255, 255, 255, 0.1);
    }

    .back-btn:hover {
        background: rgba(255, 255, 255, 0.2);
    }

    .contact-info {
        display: flex;
        align-items: center;
        gap: 10px;
        margin: 15px 0;
        padding: 10px;
        border-radius: 8px;
        background: #f8f9fa;
    }

    .contact-info i {
        background: linear-gradient(to right, #5c6bc0, #2da0a8);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .contact-info a {
        color: #2da0a8;  /* Changed from #4C9DA3 */
        text-decoration: none;
        font-weight: 500;
    }

    @media (max-width: 768px) {
        .container {
            grid-template-columns: 1fr;
            margin-top: 70px;
            padding: 15px;
        }
        
        .sidebar {
            position: relative;
            top: 0;
        }
    }
</style>
@endsection