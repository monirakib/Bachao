<!DOCTYPE html>
<html>
<head>
    <title>Logging Out - Medical Services</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            background: linear-gradient(to right, #dd2476, #ff512f);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .logout-container {
            text-align: center;
            background: white;
            padding: 40px 60px;
            border-radius: 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.35);
            animation: fadeIn 0.5s ease;
        }

        .logout-icon {
            font-size: 50px;
            background: linear-gradient(to right, #dd2476, #ff512f);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 20px;
        }

        h2 {
            color: #333;
            font-size: 24px;
            margin-bottom: 15px;
        }

        p {
            color: #666;
            font-size: 16px;
            margin-bottom: 20px;
        }

        .return-btn {
            display: inline-block;
            padding: 12px 30px;
            background: linear-gradient(to right, #dd2476, #ff512f);
            color: white;
            text-decoration: none;
            border-radius: 25px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .return-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(221, 36, 118, 0.4);
        }

        @keyframes fadeIn {
            from { 
                opacity: 0; 
                transform: translateY(-20px); 
            }
            to { 
                opacity: 1; 
                transform: translateY(0); 
            }
        }

        .background-clips {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -1;
        }

        @media (min-aspect-ratio:16/9) {
            .background-clips {
                width: 100%;
                height: auto;
            }
        }

        @media (max-aspect-ratio:16/9) {
            .background-clips {
                width: auto;
                height: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="logout-container">
        <i class="fas fa-check-circle logout-icon"></i>
        <h2>Successfully Logged Out</h2>
        <p>Thank you for using Medical Services</p>
        <a href="{{ route('home') }}" class="return-btn">Return to Homepage</a>
    </div>

    <video autoplay loop muted plays-inline class="background-clips">
        <source src="{{ asset('pics/medical/medical_background.mp4') }}" type="video/mp4">
    </video>

    <script>
        setTimeout(() => {
            window.location.href = "{{ route('home') }}";
        }, 3000);
    </script>
</body>
</html>