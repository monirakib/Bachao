<!DOCTYPE html>
<html>
<head>
    <title>Booking Confirmation - Bachao Airlines</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Murecho:wght@100..900&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Murecho', sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
        }

        .header1 {
            background: linear-gradient(to right, #5c6bc0, #2da0a8);
            padding: 20px 50px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 100;
            box-sizing: border-box;
        }

        .container {
            max-width: 800px;
            margin: 130px auto 40px;
            padding: 40px;
            background: white;
            border-radius: 20px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.1);
        }

        .success-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .success-icon {
            color: #2da0a8;
            font-size: 64px;
            margin-bottom: 20px;
        }

        .booking-details {
            background: #f8f9fa;
            padding: 30px;
            border-radius: 15px;
            margin-bottom: 30px;
        }

        .detail-group {
            display: flex;
            justify-content: space-between;
            padding: 15px 0;
            border-bottom: 1px dashed #dee2e6;
        }

        .detail-label {
            color: #666;
            font-weight: 600;
        }

        .detail-value {
            color: #2c3e50;
            font-weight: 500;
        }

        .price-breakdown {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 2px solid #eee;
        }

        .action-buttons {
            display: flex;
            gap: 20px;
            margin-top: 30px;
            justify-content: center;
        }

        .btn {
            padding: 15px 30px;
            border-radius: 12px;
            font-size: 1em;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }

        .print-btn {
            background: linear-gradient(to right, #5c6bc0, #2da0a8);
            color: white;
            border: none;
        }

        .dashboard-btn {
            background: white;
            color: #2c3e50;
            border: 2px solid #e1e8ed;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        @media print {
            .header1, .action-buttons {
                display: none;
            }
            
            .container {
                margin: 0;
                box-shadow: none;
            }

            body {
                background: white;
            }
        }
    </style>
</head>
<body>
    <nav class="header1">
        <a href="{{ route('dashboard') }}" class="btn dashboard-btn">
            <i class="fas fa-home"></i> Dashboard
        </a>
    </nav>

    <div class="container">
        <div class="success-header">
            <i class="fas fa-check-circle success-icon"></i>
            <h1>Booking Confirmed!</h1>
            <p>Thank you for choosing Bachao Airlines. Your booking has been confirmed.</p>
        </div>

        <div class="booking-details">
            <div class="detail-group">
                <span class="detail-label">Booking ID</span>
                <span class="detail-value">#{{ $transaction->id }}</span>
            </div>

            <div class="detail-group">
                <span class="detail-label">Passenger Details</span>
                <span class="detail-value">
                    {{ $transaction->passenger_name }}<br>
                    {{ $transaction->email }}<br>
                    {{ $transaction->phone }}<br>
                    Passport: {{ $transaction->passport_number }}
                </span>
            </div>

            <div class="detail-group">
                <span class="detail-label">Flight Details</span>
                <span class="detail-value">
                    {{ $transaction->flight->Flight_from }} to {{ $transaction->flight->Flight_to }}<br>
                    {{ $transaction->flight->Start_date }} at {{ $transaction->flight->Start_time }}
                </span>
            </div>

            <div class="detail-group">
                <span class="detail-label">Seat Details</span>
                <span class="detail-value">
                    Seat: {{ $transaction->seat_number }}<br>
                    Class: {{ $transaction->seat_type }}
                </span>
            </div>

            <div class="price-breakdown">
                <div class="detail-group">
                    <span class="detail-label">Base Fare</span>
                    <span class="detail-value">৳{{ number_format($transaction->amount, 2) }}</span>
                </div>

                @if($transaction->insurance_amount > 0)
                <div class="detail-group">
                    <span class="detail-label">Insurance</span>
                    <span class="detail-value">৳{{ number_format($transaction->insurance_amount, 2) }}</span>
                </div>
                @endif

                <div class="detail-group total">
                    <span class="detail-label">Total Amount</span>
                    <span class="detail-value">৳{{ number_format($transaction->total_amount, 2) }}</span>
                </div>
            </div>
        </div>

        <div class="action-buttons">
            <button onclick="window.print()" class="btn print-btn">
                <i class="fas fa-print"></i> Print Ticket
            </button>
            <a href="{{ route('dashboard') }}" class="btn dashboard-btn">
                <i class="fas fa-home"></i> Return to Dashboard
            </a>
        </div>
    </div>
</body>
</html>