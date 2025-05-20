<!DOCTYPE html>
<html>
<head>
    <title>AI Health Assistant</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css2?family=Murecho:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            font-family: 'Murecho', Arial, sans-serif;
            background: linear-gradient(120deg, #f5f6fa 60%, #e0eafc 100%);
            margin: 0;
            padding: 0;
        }
        .dashboard-grid {
            display: flex;
            flex-direction: row;
            justify-content: center;
            align-items: flex-start;
            gap: 40px;
            min-height: 100vh;
            width: 100vw;
            box-sizing: border-box;
            padding: 0;
            margin-top: 140px; /* Moved a bit up */
        }
        .bmi-card, .chat-container {
            flex: 1 1 350px;
            max-width: 420px;
            min-width: 320px;
            margin: 0;
        }
        .bmi-card {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 4px 24px rgba(25, 118, 210, 0.10), 0 1.5px 6px rgba(221,36,118,0.07);
            padding: 36px 32px 28px 32px;
            max-width: 420px;
            width: 100%;
            transition: box-shadow 0.2s;
            border: 1.5px solid #e0eafc;
            position: relative;
            overflow: hidden;
        }
        .bmi-card:before {
            content: "";
            position: absolute;
            top: 0; left: 0; right: 0; height: 8px;
            background: linear-gradient(90deg, #1976d2 60%, #dd2476 100%);
            border-radius: 16px 16px 0 0;
        }
        .bmi-header {
            text-align: center;
            margin-bottom: 24px;
        }
        .bmi-header h3 {
            margin: 0;
            font-size: 1.7em;
            color: #1976d2;
            letter-spacing: 1px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }
        .bmi-form label {
            display: block;
            margin-bottom: 6px;
            color: #34495e;
            font-weight: 600;
            font-size: 1.05em;
        }
        .bmi-form input[type="number"] {
            width: 100%;
            padding: 12px 14px;
            border: 1.5px solid #d1d8e0;
            border-radius: 8px;
            font-size: 1.08em;
            margin-bottom: 18px;
            background: #f8fafc;
            transition: border 0.2s;
            font-family: inherit;
        }
        .bmi-form input[type="number"]:focus {
            border: 1.5px solid #1976d2;
            outline: none;
            background: #e3f0fc;
        }
        .bmi-form button {
            width: 100%;
            background: linear-gradient(90deg, #1976d2 60%, #dd2476 100%);
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 13px 0;
            font-size: 1.15em;
            font-weight: 700;
            cursor: pointer;
            box-shadow: 0 2px 8px rgba(221,36,118,0.08);
            transition: background 0.2s, box-shadow 0.2s;
            margin-top: 8px;
        }
        .bmi-form button:hover {
            background: linear-gradient(90deg, #1253a2 60%, #ff512f 100%);
            box-shadow: 0 4px 16px rgba(25, 118, 210, 0.13);
        }
        #bmiResult {
            margin-top: 22px;
            font-size: 1.22em;
            font-weight: bold;
            color: #1976d2;
            text-align: center;
            letter-spacing: 0.5px;
        }
        #bmiAdvice {
            margin-top: 12px;
            font-size: 1.05em;
            color: #34495e;
            background: #e3f0fc;
            border-radius: 8px;
            padding: 14px 10px;
            text-align: center;
            box-shadow: 0 1px 4px rgba(25, 118, 210, 0.07);
        }
        /* Chat styles remain unchanged */
        .chat-container {
            max-width: 500px;
            margin: 0; /* Remove any vertical margin */
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            padding: 0 0 16px 0;
        }
        .metric-header {
            background: #1976d2;
            color: #fff;
            border-radius: 12px 12px 0 0;
            padding: 18px 24px;
            text-align: center;
        }
        .chat-messages {
            min-height: 220px;
            max-height: 350px;
            overflow-y: auto;
            padding: 18px;
            background: #f0f4f8;
        }
        .message {
            margin-bottom: 10px;
            padding: 10px 15px;
            border-radius: 10px;
            max-width: 80%;
            word-break: break-word;
        }
        .user-message {
            background: #dd2476;
            color: white;
            margin-left: auto;
        }
        .bot-message {
            background: #1976d2;
            color: white;
        }
        .chat-input {
            display: flex;
            padding: 12px 18px 0 18px;
            gap: 8px;
        }
        .chat-input textarea {
            flex: 1;
            border-radius: 8px;
            border: 1px solid #ccc;
            padding: 8px;
            resize: none;
            font-size: 1em;
        }
        .add-button {
            background: #1976d2;
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 0 18px;
            font-size: 1.2em;
            cursor: pointer;
            transition: background 0.2s;
        }
        .add-button:hover {
            background: #1253a2;
        }
    </style>
</head>

<body>
    @include('layouts.header')

    <div class="dashboard-grid">
        <!-- BMI Calculator -->
        <div class="bmi-card">
            <div class="bmi-header">
                <h3><i class="fas fa-weight"></i> BMI Calculator</h3>
            </div>
            <form id="bmiForm" class="bmi-form">
                <label for="bmiWeight">Weight (kg):</label>
                <input type="number" id="bmiWeight" required min="1" step="0.1" placeholder="Enter your weight">
                <label for="bmiHeight">Height (cm):</label>
                <input type="number" id="bmiHeight" required min="1" step="0.1" placeholder="Enter your height">
                <button type="submit">Calculate BMI</button>
            </form>
            <div id="bmiResult"></div>
            <div id="bmiAdvice"></div>
        </div>

        <!-- AI Health Assistant -->
        <div class="metric-card chat-container">
            <div class="metric-header">
                <h3 class="metric-title">
                    <i class="fas fa-robot"></i> AI Health Assistant
                </h3>
            </div>
            <div class="chat-messages" id="chatMessages">
                <div class="message bot-message">
                    Hello! I'm your health assistant. How can I help you today?
                </div>
            </div>
            <form id="chatForm" class="chat-input">
                @csrf
                <textarea 
                    name="message" 
                    placeholder="Ask me about your health concerns..."
                    required
                ></textarea>
                <button type="submit" class="add-button">
                    <i class="fas fa-paper-plane"></i>
                </button>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('bmiForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const weight = parseFloat(document.getElementById('bmiWeight').value);
            const heightCm = parseFloat(document.getElementById('bmiHeight').value);
            const heightM = heightCm / 100;
            const bmi = weight / (heightM * heightM);
            let advice = '';
            let status = '';

            if (bmi < 18.5) {
                status = 'Underweight';
                advice = 'You are underweight. Consider a balanced diet with more calories and consult a healthcare provider if needed.';
            } else if (bmi < 24.9) {
                status = 'Normal weight';
                advice = 'Your BMI is normal. Maintain a healthy lifestyle with regular exercise and a balanced diet.';
            } else if (bmi < 29.9) {
                status = 'Overweight';
                advice = 'You are overweight. Consider regular exercise, a healthy diet, and consult a healthcare provider for guidance.';
            } else {
                status = 'Obese';
                advice = 'You are in the obese range. It is recommended to consult a healthcare provider for a personalized plan.';
            }

            document.getElementById('bmiResult').textContent = `Your BMI: ${bmi.toFixed(2)} (${status})`;
            document.getElementById('bmiAdvice').textContent = advice;
        });

        document.getElementById('chatForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            const form = e.target;
            const message = form.message.value.trim();

            // Validate message
            if (!message || message.length > 500) {
                addMessage('Your message must be between 1 and 500 characters.', 'bot');
                return;
            }

            // Show user message
            addMessage(message, 'user');
            form.message.value = '';

            try {
                const response = await fetch('/health/gpt', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ message })
                });

                const data = await response.json();

                if (!response.ok) {
                    throw new Error(data.response || 'Network response was not ok');
                }

                addMessage(data.response, 'bot');

            } catch (error) {
                console.error('Error:', error);
                addMessage('Sorry, I encountered an error. Please try again.', 'bot');
            }
        });

        // Helper function to add messages to the chat
        function addMessage(message, type) {
            const chatMessages = document.querySelector('.chat-messages');
            const messageElement = document.createElement('div');
            messageElement.classList.add('message', `${type}-message`);
            messageElement.textContent = message;
            chatMessages.appendChild(messageElement);
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }
    </script>
</body>
</html>