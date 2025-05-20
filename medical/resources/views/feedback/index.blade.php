@extends('layouts.plain')

@section('content')
<style>
    body {
        background-color: #f0f4f8;
        background-image: url('https://www.transparenttextures.com/patterns/medical.png');
        background-repeat: repeat;
        background-size: 300px 300px;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .feedback-container {
        max-width: 1200px; /* Increased width */
        width: 90vw;       /* Responsive: uses 90% of viewport width */
        margin: 40px auto;
        background: #ffffff;
        border-radius: 14px;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.05);
        padding: 36px 40px 30px 40px; /* More horizontal padding */
        border: 1px solid #e3e9ef;
    }

    .feedback-container h2, .feedback-container h3 {
        color: #34495e;
        margin-bottom: 14px;
    }

    .feedback-success {
        background: #eafaf1;
        border-left: 4px solid #27ae60;
        color: #2e7d32;
        padding: 12px;
        margin-bottom: 18px;
        border-radius: 6px;
        font-weight: 500;
    }

    .feedback-form textarea {
        width: 100%;
        border-radius: 8px;
        border: 1.2px solid #cfd8dc;
        padding: 14px;
        font-size: 1em;
        background: #fcfdff;
        margin-bottom: 14px;
        transition: all 0.2s ease;
    }

    .feedback-form textarea:focus {
        border-color: #1976d2;
        background-color: #eaf3fb;
        outline: none;
        box-shadow: 0 0 0 3px rgba(25, 118, 210, 0.15);
    }

    .feedback-form button {
        background: #1976d2;
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 10px 30px;
        font-size: 1em;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.2s ease;
    }

    .feedback-form button:hover {
        background: #1253a2;
    }

    .rating-label {
        display: block;
        margin-bottom: 6px;
        font-weight: 600;
        color: #2c3e50;
    }

    .rating-select {
        border-radius: 6px;
        border: 1px solid #cfd8dc;
        padding: 8px 10px;
        font-size: 1em;
        margin-bottom: 14px;
        background: #f9f9fc;
        width: 100%;
    }

    .feedback-list {
        margin-top: 32px;
    }

    .feedback-item {
        background: #f9fafb;
        padding: 16px 20px;
        border-radius: 10px;
        margin-bottom: 16px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.035);
        border-left: 4px solid #1976d2;
    }

    .feedback-item strong {
        color: #34495e;
        font-size: 1em;
    }

    .feedback-item .feedback-date {
        color: #999;
        font-size: 0.92em;
        margin-left: 8px;
    }

    .rating-stars {
        font-size: 1.2em;
        color: #f39c12;
        margin-bottom: 4px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .back-button {
        display: inline-block;
        margin-bottom: 24px;
        background: #34495e;
        color: #fff;
        padding: 10px 24px;
        border-radius: 6px;
        text-decoration: none;
        font-weight: 600;
        font-size: 0.95em;
        transition: background 0.2s;
    }

    .back-button:hover {
        background: #2c3e50;
    }

    .emoji-slider {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 18px;
    }

    .emoji-range {
        width: 160px;
        accent-color: #1976d2;
    }
</style>


<div class="feedback-container">
    <a href="{{ route('dashboard') }}" class="back-button">
        ← Back to Dashboard
    </a>
    <h2>Leave Your Feedback</h2>
    <div id="feedback-success" class="feedback-success" style="display:none;"></div>
    <form method="POST" action="{{ route('feedback.store') }}" class="feedback-form" id="feedbackForm">
        @csrf
        <label class="rating-label" for="rating">Rating:</label>
        <select name="rating" id="rating" class="rating-select" required>
            <option value="" disabled selected>Rate</option>
            <option value="5">★★★★★ (Excellent)</option>
            <option value="4">★★★★☆ (Good)</option>
            <option value="3">★★★☆☆ (Average)</option>
            <option value="2">★★☆☆☆ (Poor)</option>
            <option value="1">★☆☆☆☆ (Very Poor)</option>
        </select>
        <br>
        <label class="rating-label" for="feeling">How did you feel?</label>
        <div class="emoji-slider" id="emojiSliderWrapper">
            <input type="range" min="1" max="5" value="3" name="feeling" id="feeling" class="emoji-range">
            <span id="emojiDisplay" style="font-size:2em; margin-left:12px;">😐</span>
        </div>
        <br>
        <textarea name="content" rows="4" required placeholder="Your feedback..."></textarea>
        <button type="submit">Submit</button>
    </form>
    <hr>
    <h3>All Feedback</h3>
    <div class="feedback-list" id="feedbackList">
        @foreach($feedbacks as $feedback)
            <div class="feedback-item">
                <div class="rating-stars" style="display: flex; align-items: center; gap: 10px;">
                    <span style="font-size:1.3em;">
                        @php $rating = intval($feedback->rating ?? 0); @endphp
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= $rating)
                                ★
                            @else
                                ☆
                            @endif
                        @endfor
                    </span>
                    <span style="font-weight: bold; color: #1976d2; font-size: 1.1em;">
                        {{ $rating }}/5
                    </span>
                    @php
                        $emojiMap = [1 => "😡", 2 => "😞", 3 => "😐", 4 => "😊", 5 => "😍"];
                        $feeling = $feedback->feeling ?? 3;
                    @endphp
                    <span style="font-size:1.5em; margin-left:8px;">
                        {{ $emojiMap[$feeling] ?? '😐' }}
                    </span>
                </div>
                <br>
                <strong>Anonymous</strong>
                <span class="feedback-date">({{ $feedback->created_at->diffForHumans() }})</span>
                <div>{{ $feedback->content }}</div>
            </div>
        @endforeach
    </div>
</div>

<script>
document.getElementById('feedbackForm').addEventListener('submit', function(e) {
    e.preventDefault();

    let form = this;
    let formData = {
        rating: form.rating.value,
        feeling: form.feeling.value,
        content: form.content.value,
        _token: document.querySelector('input[name="_token"]').value
    };

    fetch(form.action, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(formData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            let successDiv = document.getElementById('feedback-success');
            successDiv.style.display = 'block';
            successDiv.style.background = '#eafaf1';
            successDiv.style.borderLeftColor = '#27ae60';
            successDiv.style.color = '#2e7d32';
            successDiv.innerText = data.message || 'Thank you for your feedback!';
            
            // Add the new feedback to the top of the list
            let rating = parseInt(form.rating.value);
            let feeling = parseInt(form.feeling.value);
            let emojiMap = {1: "😡", 2: "😞", 3: "😐", 4: "😊", 5: "😍"};
            let stars = Array(5).fill('☆').fill('★', 0, rating).join('');
            
            let feedbackHtml = `
                <div class="feedback-item">
                    <div class="rating-stars" style="display: flex; align-items: center; gap: 10px;">
                        <span style="font-size:1.3em;">${stars}</span>
                        <span style="font-weight: bold; color: #1976d2; font-size: 1.1em;">${rating}/5</span>
                        <span style="font-size:1.5em; margin-left:8px;">${emojiMap[feeling] || '😐'}</span>
                    </div>
                    <br>
                    <strong>Anonymous</strong>
                    <span class="feedback-date">(just now)</span>
                    <div>${form.content.value.replace(/</g, "&lt;").replace(/>/g, "&gt;")}</div>
                </div>
            `;
            document.getElementById('feedbackList').insertAdjacentHTML('afterbegin', feedbackHtml);
            
            // Reset form
            form.reset();
            emojiDisplay.textContent = emojiMap[3]; // Reset emoji to neutral
        } else {
            throw new Error(data.message || 'Unknown error occurred');
        }
    })
    .catch((error) => {
        console.error('Error:', error);
        let successDiv = document.getElementById('feedback-success');
        successDiv.style.display = 'block';
        successDiv.style.background = '#fee2e2';
        successDiv.style.borderLeftColor = '#ef4444';
        successDiv.style.color = '#b91c1c';
        successDiv.innerText = error.message || 'There was an error submitting your feedback.';
    });
});

// Keep the existing emoji slider code
const emojiMap = {
    1: "😡",
    2: "😞", 
    3: "😐",
    4: "😊",
    5: "😍"
};
const emojiSlider = document.getElementById('feeling');
const emojiDisplay = document.getElementById('emojiDisplay');
if (emojiSlider && emojiDisplay) {
    emojiSlider.addEventListener('input', function() {
        emojiDisplay.textContent = emojiMap[this.value];
    });
    emojiDisplay.textContent = emojiMap[emojiSlider.value];
}
</script>
@endsection