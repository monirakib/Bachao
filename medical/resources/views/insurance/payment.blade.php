<!DOCTYPE html>
<html>
<head>
    <title>Insurance Payment - Medical Services</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        /* ... Copy existing styles from plans.blade.php ... */
        
        .payment-options {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 30px;
        }

        .payment-option {
            background: white;
            padding: 20px;
            border-radius: 15px;
            cursor: pointer;
            border: 2px solid #e1e8ed;
            transition: all 0.3s ease;
        }

        .payment-option:hover {
            border-color: #dd2476;
        }

        .payment-option.selected {
            border-color: #dd2476;
            background: rgba(221, 36, 118, 0.05);
        }

        .payment-details {
            margin-top: 30px;
        }

        .form-group {
            margin-bottom: 20px;
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
    </style>
</head>
<body>
    @include('layouts.navigation')

    <div class="container">
        <h1>Complete Your Insurance Purchase</h1>
        <div class="plan-summary">
            <h2>Selected Plan: {{ ucfirst($insurance->plan_type) }}</h2>
            <p>Monthly Cost: {{ $insurance->cost }} TK</p>
        </div>

        <form action="{{ route('insurance.confirm-payment', $insurance->id) }}" method="POST">
            @csrf
            <div class="payment-options">
                <label class="payment-option">
                    <input type="radio" name="payment_method" value="bkash" required>
                    <i class="fas fa-mobile-alt"></i>
                    bKash Payment
                </label>
                <label class="payment-option">
                    <input type="radio" name="payment_method" value="card">
                    <i class="fas fa-credit-card"></i>
                    Card Payment
                </label>
                <label class="payment-option">
                    <input type="radio" name="payment_method" value="cash">
                    <i class="fas fa-money-bill-wave"></i>
                    Cash Payment
                </label>
            </div>

            <div id="payment-details" class="payment-details" style="display: none;">
                <!-- Dynamic payment fields will be inserted here -->
            </div>

            <button type="submit" class="plan-button">
                Confirm Payment
            </button>
        </form>
    </div>

    <script>
        document.querySelectorAll('input[name="payment_method"]').forEach(radio => {
            radio.addEventListener('change', function() {
                const detailsDiv = document.getElementById('payment-details');
                
                switch(this.value) {
                    case 'bkash':
                        detailsDiv.style.display = 'block';
                        detailsDiv.innerHTML = `
                            <div class="form-group">
                                <label>bKash Number</label>
                                <input type="text" name="bkash_number" required pattern="01[3-9][0-9]{8}">
                            </div>
                            <div class="form-group">
                                <label>Transaction ID</label>
                                <input type="text" name="transaction_id" required>
                            </div>
                        `;
                        break;
                        
                    case 'card':
                        detailsDiv.style.display = 'block';
                        detailsDiv.innerHTML = `
                            <div class="form-group">
                                <label>Card Number</label>
                                <input type="text" name="card_number" required pattern="[0-9]{16}">
                            </div>
                            <div class="form-group">
                                <label>Expiry Date</label>
                                <input type="text" name="expiry" required pattern="(0[1-9]|1[0-2])\/([0-9]{2})">
                            </div>
                            <div class="form-group">
                                <label>CVV</label>
                                <input type="text" name="cvv" required pattern="[0-9]{3,4}">
                            </div>
                        `;
                        break;
                        
                    case 'cash':
                        detailsDiv.style.display = 'block';
                        detailsDiv.innerHTML = `
                            <div class="alert">
                                You can pay at our office. Your insurance will be activated after payment.
                            </div>
                        `;
                        break;
                }
            });
        });
    </script>
</body>
</html>