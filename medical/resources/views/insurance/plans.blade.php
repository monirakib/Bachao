<!DOCTYPE html>
<html>
<head>
    <title>Health Insurance Plans</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Murecho:wght@100..900&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Murecho', sans-serif;
            position: relative;
            min-height: 100vh;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 100vh;
            background: linear-gradient(to right, rgba(221, 36, 118, 0.9), rgba(255, 81, 47, 0.9));
            z-index: -1;
        }

        .container {
            max-width: 1200px;
            margin: 60px auto 40px;
            padding: 0 20px;
            position: relative;
            z-index: 1;
        }

        .plans-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            margin-top: 20px;
        }

        .plan-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            padding: 30px;
            text-align: center;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            position: relative;
            overflow: hidden;
            margin-top: 10px;
            backdrop-filter: blur(5px);
        }

        .plan-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }

        .plan-type {
            font-size: 1.8em;
            color: #2c3e50;
            margin-bottom: 15px;
        }

        .plan-price {
            font-size: 2.5em;
            color: #dd2476;
            margin-bottom: 20px;
        }

        .plan-price small {
            font-size: 0.4em;
            color: #95a5a6;
        }

        .plan-features {
            list-style: none;
            padding: 0;
            margin: 0 0 30px;
            text-align: left;
        }

        .plan-features li {
            padding: 10px 0;
            color: #7f8c8d;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .plan-features i {
            color: #2ecc71;
        }

        .plan-button {
            display: inline-block;
            padding: 12px 30px;
            border-radius: 25px;
            background: linear-gradient(to right, #dd2476, #ff512f);
            color: white;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            width: 100%;
        }

        .plan-button:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 15px rgba(221, 36, 118, 0.3);
        }

        .plan-badge {
            position: absolute;
            top: 20px;
            right: -35px;
            background: #2ecc71;
            color: white;
            padding: 5px 40px;
            transform: rotate(45deg);
            font-size: 0.8em;
        }

        .payment-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 1000;
        }

        .payment-content {
            position: relative;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            padding: 30px;
            border-radius: 20px;
            width: 90%;
            max-width: 500px;
        }

        .payment-options {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 15px;
            margin: 20px 0;
        }

        .payment-option {
            padding: 15px;
            border: 2px solid #e1e8ed;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: center;
        }

        .payment-option:hover {
            border-color: #dd2476;
        }

        .payment-option.selected {
            border-color: #dd2476;
            background: rgba(221, 36, 118, 0.05);
        }

        .payment-details {
            margin-top: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #2c3e50;
        }

        .form-group input {
            width: 100%;
            padding: 12px;
            border: 2px solid #e1e8ed;
            border-radius: 10px;
            font-size: 16px;
        }

        .close-modal {
            position: absolute;
            top: 15px;
            right: 15px;
            font-size: 24px;
            cursor: pointer;
            color: #95a5a6;
        }

        /* Add this new style for header navigation */
        .header-nav {
            position: fixed;
            top: 15px;
            left: 20px;  /* Changed from right to left */
            display: flex;
            gap: 10px;
            z-index: 1000;
        }

        .nav-link {
            display: inline-flex;
            align-items: center;
            padding: 8px 16px;
            background: rgba(255, 255, 255, 0.9);
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            text-decoration: none;
            color: #4B5563;
            font-size: 0.9rem;
            transition: all 0.2s;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .nav-link:hover {
            transform: translateY(-1px);
            box-shadow: 0 2px 4px rgba(0,0,0,0.15);
        }

        .nav-link i {
            margin-right: 8px;
        }

        h1 {
            margin-top: 0;
            margin-bottom: 20px;
            color: #2c3e50;
            font-size: 2em;
        }

        .animated-title {
            color: white;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
            background: none;
            -webkit-background-clip: unset;
            background-clip: unset;
            font-size: 2.5em;
            font-weight: bold;
            text-align: center;
            margin-bottom: 30px;
            transition: transform 0.3s ease;
            cursor: pointer;
            text-shadow: 0 0 20px rgba(221, 36, 118, 0.1);
        }

        .animated-title:hover {
            transform: translateY(-5px) scale(1.02);
        }

        @keyframes gradientMove {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Add this if you want drag functionality */
        .draggable {
            user-select: none;
            position: relative;
            z-index: 10;
        }
    </style>
</head>
<body>
    <div class="header-nav">
        <a href="{{ route('dashboard') }}" class="nav-link">
            <i class="fas fa-arrow-left"></i>
            Back to Dashboard
        </a>
    </div>

    <div class="container">
        <h1 class="animated-title draggable" id="draggableTitle">Available Insurance Plans</h1>
        <div class="plans-grid">
            <!-- Basic Plan -->
            <div class="plan-card">
                <h2 class="plan-type">Basic Coverage</h2>
                <div class="plan-price">
                    1000 TK<small>/month</small>
                </div>
                <ul class="plan-features">
                    <li><i class="fas fa-check"></i> 30% coverage on emergency services</li>
                    <li><i class="fas fa-check"></i> Basic health checkups</li>
                    <li><i class="fas fa-check"></i> Medicine discounts</li>
                    <li><i class="fas fa-check"></i> 24/7 helpline support</li>
                </ul>
                <form action="{{ route('insurance.purchase') }}" method="POST">
                    @csrf
                    <input type="hidden" name="plan_type" value="basic">
                    <button type="submit" class="plan-button">Get Basic Plan</button>
                </form>
            </div>

            <!-- Premium Plan -->
            <div class="plan-card">
                <div class="plan-badge">Popular</div>
                <h2 class="plan-type">Premium Coverage</h2>
                <div class="plan-price">
                    3000 TK<small>/month</small>
                </div>
                <ul class="plan-features">
                    <li><i class="fas fa-check"></i> 60% coverage on all services</li>
                    <li><i class="fas fa-check"></i> Comprehensive health checkups</li>
                    <li><i class="fas fa-check"></i> Enhanced medicine discounts</li>
                    <li><i class="fas fa-check"></i> Priority ambulance service</li>
                    <li><i class="fas fa-check"></i> Family doctor consultation</li>
                </ul>
                <form action="{{ route('insurance.purchase') }}" method="POST">
                    @csrf
                    <input type="hidden" name="plan_type" value="premium">
                    <button type="submit" class="plan-button">Get Premium Plan</button>
                </form>
            </div>

            <!-- Elite Plan -->
            <div class="plan-card">
                <h2 class="plan-type">Elite Coverage</h2>
                <div class="plan-price">
                    6500 TK<small>/month</small>
                </div>
                <ul class="plan-features">
                    <li><i class="fas fa-check"></i> 90% coverage on all services</li>
                    <li><i class="fas fa-check"></i> VIP health checkups</li>
                    <li><i class="fas fa-check"></i> Maximum medicine discounts</li>
                    <li><i class="fas fa-check"></i> Priority services</li>
                    <li><i class="fas fa-check"></i> International coverage</li>
                    <li><i class="fas fa-check"></i> Personal medical concierge</li>
                </ul>
                <form action="{{ route('insurance.purchase') }}" method="POST">
                    @csrf
                    <input type="hidden" name="plan_type" value="elite">
                    <button type="submit" class="plan-button">Get Elite Plan</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Payment Modal -->
    <div id="paymentModal" class="payment-modal">
        <div class="payment-content">
            <span class="close-modal">&times;</span>
            <h2>Complete Your Purchase</h2>
            <div id="planSummary"></div>
            
            <form id="paymentForm" action="{{ route('insurance.purchase') }}" method="POST">
                @csrf
                <input type="hidden" name="plan_type" id="selectedPlan">
                
                <div class="payment-options">
                    <label class="payment-option">
                        <input type="radio" name="payment_method" value="bkash" required>
                        <i class="fas fa-mobile-alt"></i>
                        <div>bKash</div>
                    </label>
                    <label class="payment-option">
                        <input type="radio" name="payment_method" value="card">
                        <i class="fas fa-credit-card"></i>
                        <div>Card</div>
                    </label>
                    <label class="payment-option">
                        <input type="radio" name="payment_method" value="cash">
                        <i class="fas fa-money-bill-wave"></i>
                        <div>Cash</div>
                    </label>
                </div>

                <div id="paymentDetails" class="payment-details"></div>

                <button type="submit" class="plan-button">Confirm Payment</button>
            </form>
        </div>
    </div>

    <script>
        // Payment form submission handler
        document.getElementById('paymentForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const form = this;
            const submitButton = form.querySelector('button[type="submit"]');
            submitButton.disabled = true;

            // Get the form data
            const formData = new FormData(form);
            const data = Object.fromEntries(formData.entries());

            // Send the payment data to server
            fetch('{{ route("insurance.purchase") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Show success message
                    alert('Insurance plan purchased successfully!');
                    // Redirect to dashboard after 2 seconds
                    setTimeout(() => {
                        window.location.href = '{{ route("dashboard") }}';
                    }, 2000);
                } else {
                    // Show error message
                    alert(data.message || 'Failed to purchase insurance plan');
                    submitButton.disabled = false;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to process payment. Please try again.');
                submitButton.disabled = false;
            });
        });

        // Plan selection handler
        document.querySelectorAll('form[action="{{ route("insurance.purchase") }}"]').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                const planType = this.querySelector('input[name="plan_type"]').value;
                const planPrice = {
                    'basic': '1000 TK',
                    'premium': '3000 TK',
                    'elite': '6500 TK'
                }[planType];
                
                document.getElementById('selectedPlan').value = planType;
                document.getElementById('planSummary').innerHTML = `
                    <div style="margin: 20px 0; padding: 15px; background: #f8f9fa; border-radius: 10px;">
                        <h3 style="margin: 0 0 10px 0; color: #2c3e50;">Plan Summary</h3>
                        <p style="margin: 5px 0;"><strong>Selected Plan:</strong> ${planType.charAt(0).toUpperCase() + planType.slice(1)}</p>
                        <p style="margin: 5px 0;"><strong>Monthly Cost:</strong> ${planPrice}</p>
                    </div>
                `;
                document.getElementById('paymentModal').style.display = 'block';
            });
        });

        // Payment method selection handler
        document.querySelectorAll('input[name="payment_method"]').forEach(radio => {
            radio.addEventListener('change', function() {
                const detailsDiv = document.getElementById('paymentDetails');
                document.querySelectorAll('.payment-option').forEach(option => {
                    option.classList.remove('selected');
                });
                this.closest('.payment-option').classList.add('selected');
                
                switch(this.value) {
                    case 'bkash':
                        detailsDiv.innerHTML = `
                            <div class="form-group">
                                <label>bKash Number</label>
                                <input type="text" name="bkash_number" pattern="01[3-9][0-9]{8}" required>
                            </div>
                            <div class="form-group">
                                <label>Transaction ID</label>
                                <input type="text" name="transaction_id" required>
                            </div>
                        `;
                        break;
                    case 'card':
                        detailsDiv.innerHTML = `
                            <div class="form-group">
                                <label>Card Number</label>
                                <input type="text" name="card_number" pattern="[0-9]{16}" required>
                            </div>
                            <div class="form-group">
                                <label>Expiry Date</label>
                                <input type="text" name="expiry" pattern="(0[1-9]|1[0-2])\/([0-9]{2})" placeholder="MM/YY" required>
                            </div>
                            <div class="form-group">
                                <label>CVV</label>
                                <input type="text" name="cvv" pattern="[0-9]{3,4}" required>
                            </div>
                        `;
                        break;
                    case 'cash':
                        detailsDiv.innerHTML = `
                            <div class="alert" style="padding: 15px; background: #f8f9fa; border-radius: 10px; margin-top: 15px;">
                                You can pay at our office. Your insurance will be activated after payment verification.
                            </div>
                        `;
                        break;
                }
            });
        });

        // Close modal
        document.querySelector('.close-modal').addEventListener('click', function() {
            document.getElementById('paymentModal').style.display = 'none';
        });

        // Close modal when clicking outside
        window.addEventListener('click', function(e) {
            if (e.target == document.getElementById('paymentModal')) {
                document.getElementById('paymentModal').style.display = 'none';
            }
        });

        // Make the title draggable
        const draggableTitle = document.getElementById('draggableTitle');
        let isDragging = false;
        let currentX;
        let currentY;
        let initialX;
        let initialY;
        let xOffset = 0;
        let yOffset = 0;

        draggableTitle.addEventListener('mousedown', dragStart);
        document.addEventListener('mousemove', drag);
        document.addEventListener('mouseup', dragEnd);

        function dragStart(e) {
            initialX = e.clientX - xOffset;
            initialY = e.clientY - yOffset;

            if (e.target === draggableTitle) {
                isDragging = true;
            }
        }

        function drag(e) {
            if (isDragging) {
                e.preventDefault();
                currentX = e.clientX - initialX;
                currentY = e.clientY - initialY;

                xOffset = currentX;
                yOffset = currentY;

                setTranslate(currentX, currentY, draggableTitle);
            }
        }

        function dragEnd(e) {
            initialX = currentX;
            initialY = currentY;
            isDragging = false;
        }

        function setTranslate(xPos, yPos, el) {
            el.style.transform = `translate(${xPos}px, ${yPos}px)`;
        }
    </script>
</body>
</html>