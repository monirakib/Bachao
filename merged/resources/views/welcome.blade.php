<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Smart Healthcare & Travel Ecosystem</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter+Tight:ital,wght@0,100..900;1,100..900&family=Murecho:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Murecho', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        }

        .header1 {
            background: linear-gradient(to right, #5c6bc0, #2da0a8);
            height: 90px;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 0 50px;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 100;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .logo img {
            height: 60px;
        }

        .main-content {
            margin-top: 150px;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .welcome-section {
            text-align: center;
            margin-bottom: 50px;
        }

        .welcome-section h1 {
            font-size: 2.5em;
            color: #2c3e50;
            margin-bottom: 20px;
        }

        .welcome-section p {
            font-size: 1.2em;
            color: #34495e;
            max-width: 800px;
            margin: 0 auto;
        }

        .options-container {
            display: flex;
            gap: 40px;
            justify-content: center;
            margin-top: 50px;
        }

        .option-card {
            width: 400px;
            background: white;
            border-radius: 20px;
            padding: 30px;
            text-align: center;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .option-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }

        .option-icon {
            font-size: 50px;
            margin-bottom: 20px;
        }

        .airline-icon {
            color: #3498db;
        }

        .medical-icon {
            color: #e74c3c;
        }

        .option-card h2 {
            color: #2c3e50;
            margin-bottom: 15px;
        }

        .option-card p {
            color: #7f8c8d;
            margin-bottom: 25px;
        }

        .option-button {
            padding: 12px 30px;
            border: none;
            border-radius: 25px;
            color: white;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .airline-button {
            background: linear-gradient(135deg, #3498db, #2980b9);
        }

        .medical-button {
            background: linear-gradient(135deg, #e74c3c, #c0392b);
        }

        .option-button:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }
    </style>
</head>
<body>
    <nav class="header1">
        <div class="logo">
            <img src="{{ asset('pics/piclogo-removebg-preview.png') }}" alt="Logo">
        </div>
    </nav>

    <div class="main-content">
        <div class="welcome-section">
            <h1>Welcome to Our Smart Healthcare & Travel Ecosystem</h1>
            <p>Choose your destination: Whether you're planning a journey or seeking medical assistance, 
               we're here to provide you with seamless service and care.</p>
        </div>

        <div class="options-container">
            <div class="option-card">
                <i class="fas fa-plane option-icon airline-icon"></i>
                <h2>Airline Reservations</h2>
                <p>Book your flights, manage reservations, and explore destinations with our comprehensive airline service.</p>
                <a href="http://localhost:8000" class="option-button airline-button">
                    Access Airlines
                </a>
            </div>

            <div class="option-card">
                <i class="fas fa-hospital option-icon medical-icon"></i>
                <h2>Medical Services</h2>
                <p>Access healthcare services, book appointments, and manage your medical records securely.</p>
                <a href="http://localhost:8001" class="option-button medical-button">
                    Access Healthcare
                </a>
            </div>
        </div>
    </div>
</body>
</html>