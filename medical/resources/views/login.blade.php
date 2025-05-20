<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
    />
    <title>Login Page | Caged coder</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap');

        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Montserrat', sans-serif;
        }

        body{
            background-color: #c9d6ff;
            background: linear-gradient(to right, #dd2476, #ff512f);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            height: 100vh;
        }

        .container{
            background-color: #fff;
            border-radius: 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.35);
            position: relative;
            overflow: hidden;
            width: 968px;  /* Increased from 768px */
            max-width: 100%;
            min-height: 580px;  /* Increased from 480px */
            width: 968px;
            min-height: 680px;  /* Increased to accommodate all content */
            max-width: 95vw;   /* Ensures container doesn't overflow on smaller screens */
            padding: 20px 0;   /* Added padding to prevent content touching edges */
        }

        .container p{
            font-size: 16px;  /* Increased from 14px */
            line-height: 24px;  /* Increased from 20px */
            letter-spacing: 0.3px;
            margin: 25px 0;  /* Increased from 20px */
        }

        .container span{
            font-size: 14px;  /* Increased from 12px */
        }

        .container a{
            color: #333;
            font-size: 14px;  /* Increased from 13px */
            text-decoration: none;
            margin: 20px 0 12px;  /* Increased margins */
        }

        .container button{
            background-color: #2da0a8;
            color: #fff;
            font-size: 14px;  /* Increased from 12px */
            padding: 12px 50px;  /* Increased from 10px 45px */
            border: 1px solid transparent;
            border-radius: 8px;
            font-weight: 600;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            margin-top: 15px;  /* Increased from 10px */
            cursor: pointer;
        }

        .container button.hidden{
            background-color: transparent;
            border-color: #fff;
        }

        .container form{
            background-color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            padding: 0 40px;
            height: 100%;
            padding: 20px 40px;
            overflow-y: auto;  /* Adds scrolling if content is too long */
            max-height: 680px; /* Match container height */
        }

        .container input, .container select {
            background-color: #eee;
            border: none;
            margin: 10px 0;  /* Increased from 8px */
            padding: 12px 18px;  /* Increased from 10px 15px */
            font-size: 14px;  /* Increased from 13px */
            border-radius: 8px;
            width: 100%;
            outline: none;
            margin: 8px 0;     /* Reduced margin between inputs */
            padding: 10px 15px; /* Slightly reduced padding */
            font-size: 13px;   /* Slightly smaller font */
        }

        .form-container{
            position: absolute;
            top: 0;
            height: 100%;
            transition: all 0.6s ease-in-out;
        }

        .sign-in{
            left: 0;
            width: 50%;
            z-index: 2;
        }

        .container.active .sign-in{
            transform: translateX(100%);
        }

        .sign-up{
            left: 0;
            width: 50%;
            opacity: 0;
            z-index: 1;
        }

        .container.active .sign-up{
            transform: translateX(100%);
            opacity: 1;
            z-index: 5;
            animation: move 0.6s;
        }

        @keyframes move{
            0%, 49.99%{
                opacity: 0;
                z-index: 1;
            }
            50%, 100%{
                opacity: 1;
                z-index: 5;
            }
        }

        .social-icons{
            margin: 25px 0;  /* Increased from 20px */
            margin: 15px 0;    /* Reduced margin */
            display: flex;
            flex-wrap: wrap;   /* Allows icons to wrap on smaller screens */
            justify-content: center;
            gap: 10px;
        }

        .social-icons a{
            border: 1px solid #ccc;
            border-radius: 20%;
            display: inline-flex;
            justify-content: center;
            align-items: center;
            margin: 0 3px;
            width: 45px;  /* Increased from 40px */
            height: 45px;  /* Increased from 40px */
            width: 35px;       /* Slightly smaller icons */
            height: 35px;
            margin: 0;
        }

        .social-icons i {
            font-size: 18px;  /* Added new style */
        }

        .toggle-container{
            position: absolute;
            top: 0;
            left: 50%;
            width: 50%;
            height: 100%;
            overflow: hidden;
            transition: all 0.6s ease-in-out;
            border-radius: 150px 0 0 100px;
            z-index: 1000;
            padding: 0px;
        }

        .container.active .toggle-container{
            transform: translateX(-100%);
            border-radius: 0 150px 100px 0;
        }

        .toggle{
            background-color: #ff512f;
            height: 100%;
            background: linear-gradient(to right, #dd2476, #ff512f);
            color: #fff;
            position: relative;
            left: -100%;
            height: 100%;
            width: 200%;
            transform: translateX(0);
            transition: all 0.6s ease-in-out;
        }

        .container.active .toggle{
            transform: translateX(50%);
        }

        .toggle-panel{
            position: absolute;
            width: 50%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            padding: 0 30px;
            text-align: center;
            top: 0;
            transform: translateX(0);
            transition: all 0.6s ease-in-out;
            padding: 0 20px;
        }

        .toggle-left{
            transform: translateX(-200%);
        }

        .container.active .toggle-left{
            transform: translateX(0);
        }

        .toggle-right{
            right: 0;
            transform: translateX(0);
        }

        .container.active .toggle-right{
            transform: translateX(200%);
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

        @media (min-aspect-ratio:16/9){
            .background-clips {
                width: 100%;
                height: auto;
            }
        }

        @media (max-aspect-ratio:16/9){
            .background-clips{
                width: auto;
                height: 100%;
            }

        }
        .name-container{
            display: flex;
            justify-content: space-between;
            width: 100%;
        }

        .half-width1{
            margin-right: 12px;
        }

        .container select {
            background-color: #eee;
            border: none;
            margin: 10px 0;  /* Increased from 8px */
            padding: 12px 18px;  /* Increased from 10px 15px */
            font-size: 14px;  /* Increased from 13px */
            border-radius: 8px;
            width: 100%;
            outline: none;
            margin: 8px 0;     /* Reduced margin between inputs */
            padding: 10px 15px; /* Slightly reduced padding */
            font-size: 13px;   /* Slightly smaller font */
        }

        .container select::after {
            content: '\25BC';
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            pointer-events: none;
        }

        .dob-gender-select {
            display: flex;
            justify-content: space-between;
            width: 100%;
        }

        .dob {
            margin-right: 12px;
        }

        .container h1 {
            font-size: 28px;  /* Added new style */
            margin-bottom: 15px;
            font-size: 24px;   /* Slightly smaller heading */
            margin-bottom: 10px;
        }

        .submit-click {
            background: linear-gradient(to right, #dd2476, #ff512f);
        }

        @media (max-height: 800px) {
            .container {
                min-height: 600px;
            }
            
            .container form {
                padding: 15px 30px;
            }
            
            .container input,
            .container select {
                margin: 6px 0;
                padding: 8px 12px;
            }
            
            .social-icons {
                margin: 10px 0;
            }
            
            .container h1 {
                font-size: 22px;
            }
        }

    </style>
  </head>

  <body>
    <div class="container" id="container">
      <div class="form-container sign-up">
        <form method="POST" action="{{ route('register') }}">
          @csrf
          <h1>Join Medical Services</h1>
          <div class="social-icons">
            <a href="#" class="icon"
              ><i class="fa-brands fa-google-plus-g"></i
            ></a>
            <a href="#" class="icon"><i class="fa-brands fa-facebook-f"></i></a>
            <a href="#" class="icon"><i class="fa-brands fa-github"></i></a>
            <a href="#" class="icon"
              ><i class="fa-brands fa-linkedin-in"></i
            ></a>
          </div>
          <span>or register with your email</span>
          <div class="name-container">
            <input type="text" name="first_name" placeholder="First Name" class="half-width1" required />
            <input type="text" name="last_name" placeholder="Last Name" required />
          </div>
          <input type="email" name="email" placeholder="Email Address" required />
          <input type="password" name="password" placeholder="Create Password" required />
          <div class="dob-gender-select">
            <input type="date" name="date_of_birth" class="dob" required />
            <select name="gender" required>
                <option value="" disabled selected>Select Gender</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
                <option value="other">Other</option>
            </select>
          </div>
          <input type="tel" name="phone" placeholder="Phone Number" required />
          <input type="text" name="address" placeholder="Address" required />
          <span>By signing up, you agree to our <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>.</span>
          <button type="submit" name="register" class="submit-click">Create Account</button>
        </form>
      </div>
      <div class="form-container sign-in">
        <form method="POST" action="{{ route('login') }}">
          @csrf
          @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
          @endif
          <h1>Welcome Back</h1>
          <div class="social-icons">
            <a href="#" class="icon"
              ><i class="fa-brands fa-google-plus-g"></i
            ></a>
            <a href="#" class="icon"><i class="fa-brands fa-facebook-f"></i></a>
            <a href="#" class="icon"><i class="fa-brands fa-github"></i></a>
            <a href="#" class="icon"
              ><i class="fa-brands fa-linkedin-in"></i
            ></a>
          </div>
          <span>access your medical services</span>
          <input type="email" name="email" value="{{ old('email') }}" placeholder="Email Address" required />
          @error('email')
            <span class="error">{{ $message }}</span>
          @enderror
          <input type="password" name="password" placeholder="Password" required />
          @error('password')
            <span class="error">{{ $message }}</span>
          @enderror
          <a href="{{ route('password.request') }}">Forgot Your Password?</a>
          <button type="submit" name="login" class="submit-click">Access Portal</button>
        </form>
      </div>
      <div class="toggle-container">
        <div class="toggle">
          <div class="toggle-panel toggle-left">
            <h1>Welcome Back!</h1>
            <p>Access your medical records, appointments, and healthcare services securely.</p>
            <button class="hidden" id="login">Sign In</button>
          </div>
          <div class="toggle-panel toggle-right">
            <h1>Your Health Journey Starts Here</h1>
            <p>Join our medical services platform for comprehensive healthcare management.</p>
            <button class="hidden" id="register">Create Account</button>
          </div>
        </div>
      </div>
    </div>
    <video autoplay loop muted plays-inline class="background-clips">
      <source src="{{ asset('pics/medical/medical_background.mp4') }}" type="video/mp4">
    </video>

    <script>
        const container = document.getElementById("container");
        const registerBtn = document.getElementById("register");
        const loginBtn = document.getElementById("login");

        registerBtn.addEventListener("click", () => {
        container.classList.add("active");
        });

        loginBtn.addEventListener("click", () => {
        container.classList.remove("active");
        });
    </script>
  </body>
</html>