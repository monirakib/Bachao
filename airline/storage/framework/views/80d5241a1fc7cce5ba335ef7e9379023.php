<!DOCTYPE html>
<html>
<head>
    <title>Bachao Airlines</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter+Tight:ital,wght@0,100..900;1,100..900&family=Murecho:wght@100..900&display=swap" rel="stylesheet">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    
    <style>
        html
        {
            scroll-behavior: smooth;
        }
        .flight-details-grid{
            margin-top: 50px;
            display: grid;
            grid-template-columns: 1200px;
            align-items: center;
            justify-content: center;
        }
        .box{
            align-items: center;
            justify-content: space-between;
            border-style: solid;
            border-color:rgb(229, 231, 235);
            background-color:rgb(229, 231, 235) ;
            margin-top: 20px;
            margin-bottom: 20px;
            height:360px;
            box-sizing: border-box;
            border-radius: 20px;
        }
        .ticket-brief{
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 6px;
            height: 30px;
            padding: 10px;
            background-color:rgb(229, 231, 235) ;
            box-shadow: rgba(0,0,0,0.15);
        }
        .tedit{
            font-family:Murecho;
            font-weight: 500;
        }
        .tedit2{
            font-family: Murecho;
            font-family: 100;
        }
        .time{
            padding-top: 15px;
            padding-left: 15px;
            padding-right: 15px;
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
            background-color: white;
        }
        .destination{
            padding-left: 15px;
            padding-right: 15px;
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
            background-color: white;
        }
        .date{
            padding-bottom: 15px;
            padding-left: 15px;
            padding-right: 15px;
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
            background-color: white;
        }
        .logo{
            width:200px
        }
        .minilogo{
            margin-top: 25px;
            width: 200px;
        }
        .ticket-price{
            height: 50px;
            padding: 10px 20px;
            background-color: rgb(229, 231, 235);
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-radius: 0 0 20px 20px;
            margin-top: auto;
        }
        .id{
            padding-top: 5px;
        }
        .tedit3{
            font-size: x-large;
            font-family: Murecho;
            font-weight: 700;
        }
        .select-button{
            width: 100px;
            height: 35px;
            text-decoration-color: aliceblue;
            background: linear-gradient(145deg, #3a47d5, #4048c7);
            border-radius: 20px;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 10px;
            font-size: 14px;
            box-shadow: 0 4px 15px rgba(64, 74, 211, 0.2);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .select-button p {
            margin: 0;
            padding: 0;
            line-height: 35px;
        }
        p{
            font-family: Murecho;
            margin-top: 0px;
            margin-bottom:0px;
        }

        body{
            margin:0px;
            padding-bottom: 1000px;
        }

        a{
            text-decoration: none;
            color: rgb(48, 47, 47);
        }
        .header1{
            display: flex;
            background: linear-gradient(to right, #5c6bc0, #2da0a8);;
            height: 90px;
            justify-content: space-between;
            position: fixed;
            top:0;
            left: 0;
            right:0;
            z-index: 110;
            border-radius: 0 0 75% 75%;
            box-shadow: 0 1px 4px rgba(0,0,0,0.5);
        }
        .header2{
            background: linear-gradient(to right, #e2e2e2, #c9d6ff);
            height: 110px;
            justify-content: space-between;
            position: fixed;
            top: 70px;
            left: 0;
            right:0;
            z-index: 100;
            border-radius: 0 0 50% 50%;
            box-shadow: 0 1px 4px rgba(0,0,0,0.5);
        }
        .logost{
            align-items: center ;
            margin-top: 5px;
            width:200px;
        }
        .store-logo{
            width: 250px;
            height: 77px;
            margin-left: 250px;
        }
        .search{
            display: flex;
            flex:1fr;
            align-items: center;
            justify-content: center;
            max-width: 600px;
        }
        .cat{
            padding: 10px;
            width:200px;
            font-size: 16px;
            height: 40px;
            border-top-left-radius: 10px;
            border-bottom-left-radius: 10px;
            border-width: 1px;
        }
        .searchbar{
            padding: 10px;
            font-size: 16px;
            width: 400px;
            height: 40px;
            border-top-left-radius: 10px;
            border-bottom-left-radius: 10px;
            border-width: 1px;
        }

        .glass{
            display: flex;
            height:38px;
            border-top-right-radius: 10px;
            border-bottom-right-radius: 10px;
        }
        .glass:hover{
            background-color: rgba(0,0,0,0.15);
            opacity: 0.7;
            cursor: pointer;
        }
        .glass:active{
            opacity: 0.5;
            cursor: pointer;
        }
        .contact{
            color: rgb(48, 47, 47);
            margin-top: 15px;
            align-items: center;
            display: flex;
            flex-direction: column;
        }
        .con-up{
            display: flex;
            flex-direction: row;
        }
        .ig{
            margin-bottom: 10px;
            margin-left: 10px;
            width:30px;
            height: 30px;
        }
        .c1-text{
            font-weight: 700;
        }
        .c-text{
            font-weight: 500;
        }
        .f-text{
            font-family: Murecho;
            font-weight: 700;
            color: rgb(48, 47, 47);
        }
        .c-text:hover{
            background-color: rgba(0,0,0,0);
            opacity: 0.7;
            cursor: pointer;
        }
        .c-text:active{
            opacity: 0.5;
            cursor: pointer;
        }
        .guest{
            background: linear-gradient(to right, #e2e2e2, #c9d6ff);
            margin-top:20px;
            width: 40px;
            height: 40px;
            border-radius: 20px;
        }
        .guest:hover{
            opacity: 0.9;
            cursor: pointer;
        }
        .guest:active{
            opacity: 0.7;
            cursor: pointer;
        }
        .guest-logo{
            width: 40px;
            height: 40px;
        }
        .guest a {
            text-decoration: none;
            display: inline-flex;
            align-items: center;
        }

        .guest-logo:hover {
            opacity: 0.8;
            transform: scale(1.05);
            transition: all 0.3s ease;
        }
        .log-in{
            width: 80px;
            height: 42px;
        }
        .login-button{
            border: none;
            background: linear-gradient(to right, #e2e2e2, #c9d6ff);
            width: 80px;
            height: 42px;
            border-top-left-radius: 21px;
            border-bottom-left-radius: 21px;
            border-top-right-radius: 21px;
            border-bottom-right-radius: 21px;
            margin-top: 20px;
        }
        .login-button:hover{
            opacity: 0.9;
            cursor: pointer;
        }
        .login-button:active{
            opacity: 0.7;
            cursor: pointer;
        }
        .head2{
            margin-left: 200px;
            margin-right: 200px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 12px;
        }
        .head2t{
            margin-top: 45px;
            font-weight: 700;
            color: rgb(104, 102, 102);
            margin-right: 20px;
        }
        .head2t:hover{
            background-color: rgba(0,0,0,0);
            opacity: 0.7;
            cursor: pointer;
        }
        .head2t:active{
            opacity: 0.5;
            cursor: pointer;
        }
        .video1{
            margin-top: 130px;
            width:1920px;
            height: 500px;
        }
        .plane{
            margin-top: 97px;
            width:1920px;
        }
        .header3 {
            background: linear-gradient(135deg, #4e54c8, #8f94fb);
            color: #fff;
            padding: 30px 20px;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
            text-align: center;
            max-width: 900px;
            margin: 30px auto;
            position: relative;
            overflow: hidden;
        }

        .head3 {
            position: relative;
            z-index: 1;
        }

        .tagline {
            font-size: 2rem;
            font-weight: bold;
            letter-spacing: 1px;
            margin-bottom: 10px;
            font-family: 'Poppins', sans-serif;
        }

        .sub-tagline {
            font-size: 1.2rem;
            margin-bottom: 20px;
            line-height: 1.5;
            font-family: 'Roboto', sans-serif;
        }

        .book-button button {
            width: 140px;
            height: 60px;
            background: #ff6b6b;
            color: #fff;
            font-size: 1rem;
            font-family: 'Poppins', sans-serif;
            font-weight: bold;
            padding: 12px 30px;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            transition: all 0.3s ease-in-out;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .book-button button:hover {
            background: #ff4a4a;
            transform: scale(1.1);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.3);
        }

        .book-plane-animation {
            position: absolute;
            top: 30px;
            left: -260px;
            width: 100%;
            height: 150px;
            z-index: 0;
            overflow: hidden;
        }

        .book-plane {
            position: absolute;
            width: 120px;
            animation: fly-plane 12s linear infinite;
            transform: rotate(-20deg);
        }

        @keyframes fly-plane {
            0% {
                transform: translateX(0) rotate(0deg);
            }
            50%{
                transform: translateX(750px) rotate(-30deg);
            }
            100% {
                transform: translateX(1500px) rotate(-60deg);
            }
        }
        .search form {
            display: flex;
            align-items: center;
        }

        .search-btn {
            background: none;
            border: none;
            cursor: pointer;
            padding: 0;
        }

        .searchbar {
            width: 300px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-right: 10px;
        }
        .flight-filter {
            margin: 20px auto;
            max-width: 800px;
            padding: 20px;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .filter-form {
            display: flex;
            justify-content: center;
            gap: 20px;
        }

        .filter-group {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .filter-group select {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            min-width: 200px;
        }

        .filter-btn {
            padding: 10px 20px;
            background: #e6000f;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .filter-btn:hover {
            background: #d4000d;
        }

        .fa-exchange-alt {
            color: #666;
            font-size: 20px;
        }
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            font-family: 'Murecho', sans-serif;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        .header1 {
            background: linear-gradient(to right, #5c6bc0, #2da0a8);;
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
            padding: 15px 30px;
            transition: all 0.3s ease;
        }

        .store-logo img {
            transition: transform 0.3s ease;
        }

        .store-logo img:hover {
            transform: scale(1.05);
        }

        .search {
            position: relative;
            transition: all 0.3s ease;
        }

        .searchbar {
            width: 300px;
            padding: 12px 20px;
            border: 2px solid transparent;
            border-radius: 30px;
            background: rgba(255, 255, 255, 0.9);
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .searchbar:focus {
            width: 350px;
            border-color: #e6000f;
            outline: none;
            box-shadow: 0 4px 20px rgba(230, 0, 15, 0.2);
        }

        .flight-details-grid {
            opacity: 0;
            transform: translateY(20px);
            animation: fadeInUp 0.6s ease forwards;
        }

        .box {
            transition: all 0.3s ease;
            transform: translateY(0);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .box:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .select-button {
            background: linear-gradient(135deg, #e6000f 0%, #ff4d4d 100%);
            border: none;
            padding: 10px 25px;
            border-radius: 25px;
            transition: all 0.3s ease;
            transform: scale(1);
        }

        .select-button:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 15px rgba(230, 0, 15, 0.3);
        }

        .contact {
            position: relative;
            overflow: hidden;
        }

        .con-up {
            transition: all 0.3s ease;
        }

        .con-up:hover {
            transform: translateY(-2px);
        }

        .guest-logo {
            transition: all 0.3s ease;
        }

        .guest-logo:hover {
            transform: rotate(5deg) scale(1.1);
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .loading {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.9);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .loading::after {
            content: '';
            width: 50px;
            height: 50px;
            border: 5px solid #f3f3f3;
            border-top: 5px solid #e6000f;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        .recommendations-link {
            text-decoration: none;
            color: inherit;
            transition: all 0.3s ease;
        }

        .recommendations-link:hover {
            color: #4e54c8;
            transform: translateY(-2px);
        }

        .head2t {
            margin-top: 45px;
            font-weight: 700;
            color: rgb(104, 102, 102);
            margin-right: 20px;
            transition: all 0.3s ease;
        }

        .head2t:hover {
            background-color: rgba(0,0,0,0);
            opacity: 0.7;
            cursor: pointer;
            transform: translateY(-2px);
        }
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            backdrop-filter: blur(5px);
            z-index: 1000;
        }
        .modal-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            padding: 30px;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 4px 20px rgba(0,0,0,0.2);
        }
        .modal-content i {
            font-size: 40px;
            color: #e74c3c;
            margin-bottom: 15px;
        }
        .login-btn {
            display: inline-block;
            padding: 10px 25px;
            background: #2da0a8;
            color: white;
            text-decoration: none;
            border-radius: 20px;
            margin-top: 15px;
            transition: all 0.3s ease;
        }
        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(45,160,168,0.3);
        }
        .access-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            backdrop-filter: blur(5px);
            z-index: 1000;
        }

        .access-modal-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            padding: 40px;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 4px 20px rgba(0,0,0,0.2);
        }

        .access-modal-content i {
            font-size: 50px;
            color: #e74c3c;
            margin-bottom: 20px;
        }

        .access-modal .login-btn {
            display: inline-block;
            padding: 12px 30px;
            background: #2da0a8;
            color: white;
            text-decoration: none;
            border-radius: 25px;
            transition: all 0.3s ease;
        }
        .admin-access {
            position: fixed;
            top: 20px;
            left: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 20px;
            background: #2c3e50;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.3s ease;
            z-index: 1000;
        }

        .admin-access:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(44, 62, 80, 0.3);
        }

        .admin-access i {
            font-size: 20px;
        }
        .admin-access {
            position: fixed;
            top: 20px;
            left: 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 25px;
            background: linear-gradient(135deg, #2da0a8 0%, #2589a0 100%);
            color: white;
            text-decoration: none;
            border-radius: 25px;
            font-family: 'Murecho', sans-serif;
            font-weight: 600;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 15px rgba(45, 160, 168, 0.2);
            z-index: 1000;
        }

        .admin-access:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(45, 160, 168, 0.3);
            background: linear-gradient(135deg, #2589a0 0%, #2da0a8 100%);
        }

        .admin-access i {
            font-size: 18px;
            animation: pulse 2s infinite;
        }

        .admin-access span {
            font-size: 14px;
            letter-spacing: 0.5px;
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }
    </style>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const loader = document.createElement('div');
        loader.className = 'loading';
        document.body.appendChild(loader);

        window.addEventListener('load', function() {
            loader.remove();
        });

        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
    });

    function showAccessDenied(event) {
        event.preventDefault();
        document.getElementById('accessDeniedModal').style.display = 'block';
    }
    window.onclick = function(event) {
        if (event.target == document.getElementById('accessDeniedModal')) {
            document.getElementById('accessDeniedModal').style.display = 'none';
        }
    }

    function showAccessDenied() {
        document.getElementById('accessDeniedModal').style.display = 'block';
    }

    window.onclick = function(event) {
        if (event.target == document.getElementById('accessDeniedModal')) {
            document.getElementById('accessDeniedModal').style.display = 'none';
        }
    }

    function showFlightAccessDenied() {
        document.getElementById('flightAccessDeniedModal').style.display = 'block';
    }

    window.onclick = function(event) {
        if (event.target == document.getElementById('flightAccessDeniedModal')) {
            document.getElementById('flightAccessDeniedModal').style.display = 'none';
        }
    }

    function showRewardAccessDeniedModal() {
        document.getElementById('rewardAccessDeniedModal').style.display = 'block';
    }

    window.onclick = function(event) {
        if (event.target == document.getElementById('rewardAccessDeniedModal')) {
            document.getElementById('rewardAccessDeniedModal').style.display = 'none';
        }
    }
    </script>
    <script>
function showAccessDeniedModal() {
    document.getElementById('accessDeniedModal').style.display = 'block';
}

function showFlightAccessDenied() {
    document.getElementById('flightAccessDeniedModal').style.display = 'block';
}

function showRewardAccessDeniedModal() {
    document.getElementById('rewardAccessDeniedModal').style.display = 'block';
}

window.addEventListener('click', function(event) {
    const accessDeniedModal = document.getElementById('accessDeniedModal');
    const flightAccessDeniedModal = document.getElementById('flightAccessDeniedModal');
    const rewardAccessDeniedModal = document.getElementById('rewardAccessDeniedModal');
    
    if (event.target == accessDeniedModal) {
        accessDeniedModal.style.display = 'none';
    }
    if (event.target == flightAccessDeniedModal) {
        flightAccessDeniedModal.style.display = 'none';
    }
    if (event.target == rewardAccessDeniedModal) {
        rewardAccessDeniedModal.style.display = 'none';
    }
});
</script>
</head>

<body>
    <nav class="header1">
        <?php if(Auth::user() && Auth::user()->user_type === 'Admin'): ?>
            <a href="<?php echo e(route('admin.dashboard')); ?>" class="admin-access">
                <i class="fas fa-user-shield"></i>
                <span>Admin Panel</span>
            </a>
        <?php endif; ?>
        <div class="store-logo">
            <img class="logost" src="<?php echo e(asset('pics/piclogo-removebg-preview.png')); ?>">
        </div>
        <div class="search">
            <form method="GET" action="">
                <input class="searchbar" 
                       type="search" 
                       name="search" 
                       placeholder="Filter your flight search ✈︎"
                       value="<?php echo e(request('search')); ?>">
                <button type="submit" class="search-btn">
                    <img class="glass" src="<?php echo e(asset('pics/AIRPLANE LOGO DESIGN.png')); ?>">
                </button>
            </form>
        </div>
        <div class="contact">
            <div class="con-up">
                <p class="c1-text" >Need help? Connect with us on  </p>
                <img class="ig" src="<?php echo e(asset('pics/ig-removebg-preview.png')); ?>">
            </div>
            <div>
                <a class="c-text" href="https://www.instagram.com/rababechan/" target="_blank">@rababechan | </a>
                <a class="c-text" href="https://www.instagram.com/monir_akib/" target="_blank"> @monir_akib | </a>
                <a class="c-text" href="https://www.instagram.com/ia.yamin/" target="_blank"> @ia.yamin </a>
            </div>
        </div>
        <div class="guest">
            <?php if(Auth::check()): ?>
                <a href="<?php echo e(route('user.profile')); ?>">
                    <img class="guest-logo" src="<?php echo e(asset('pics/guest-removebg-preview.png')); ?>" alt="User Profile">
                </a>
            <?php else: ?>
                <a href="#" onclick="showAccessDenied(event)">
                    <img class="guest-logo" src="<?php echo e(asset('pics/guest-removebg-preview.png')); ?>" alt="User Profile">
                </a>
            <?php endif; ?>
            <span style="color: rgb(48, 47, 47); font-family: Murecho; font-weight:700;">
                <?php echo e(Auth::user() ? Auth::user()->first_name : 'Guest'); ?>

            </span>
        </div>
        <div class="log-in">
    <?php if(Auth::check()): ?>
        <form method="POST" action="<?php echo e(route('logout')); ?>" style="margin: 0;">
            <?php echo csrf_field(); ?>
            <button type="submit" class="login-button" style="color: rgb(48, 47, 47); font-family: Murecho; font-weight:700;">
                <p>Logout</p>
            </button>
        </form>
    <?php else: ?>
        <button type="button" 
                class="login-button" 
                onclick="location.href='<?php echo e(route('login')); ?>'"
                style="color: rgb(48, 47, 47); font-family: Murecho; font-weight:700;">
            <p>Login</p>
        </button>
    <?php endif; ?>
</div>
    </nav>
    
    <nav class="header2">
        <div class="head2">
            <div class="head2t">
                <a href="<?php echo e(Auth::check() ? route('reward_points') : '#'); ?>" 
                   onclick="<?php echo e(!Auth::check() ? 'showRewardAccessDeniedModal(); return false;' : ''); ?>" 
                   style="color: rgb(104, 102, 102); font-family: Murecho; font-weight: 700;">
                    Reward Points
                </a>
            </div>
            <div class="head2t">
                <a href="<?php echo e(route('travel_insurance')); ?>" style="color: rgb(104, 102, 102); font-family: Murecho; font-weight: 700;">
                    Travel Insurance
                </a>
            </div>
            <div class="head2t">
                <a href="<?php echo e(route('promo')); ?>" style="color: rgb(104, 102, 102); font-family: Murecho; font-weight: 700;">PromoCodes</a>
            </div>
            <div class="head2t">
                <a href="<?php echo e(route('recommend')); ?>" class="recommendations-link">Our Recommendations</a>
            </div>
            <div class="head2t">
                <a style="color: rgb(104, 102, 102); font-family: Murecho; font-weight: 700;" 
                   class="f-text" 
                   href="<?php echo e(route('feedback')); ?>">
                    Customer Support
                </a>
            </div>
        </div>
    </nav>
    <video class="video1" autoplay muted loop plays-inline>
        <source src="<?php echo e(asset('pics/Orange Blue Modern Travel Video (4150 x 1080 px).mp4')); ?>"
        type="video/mp4">
    </video>
    <nav class="header3">
        <div class="head3">
            <h2 class="tagline">Fly Beyond Horizons, Explore the World Your Way!</h2>
            <p class="sub-tagline">Still dreaming of your perfect getaway? Book your dream destination now!</p>
            <div class="book-button">
                <a href="#book" class="book-linkSmoothScroll">
                    <button> Book now</button>
                </a>
            </div>
        </div>
        <div class="book-plane-animation">
            <img src="<?php echo e(asset('pics/airplane.png')); ?>" alt="Plane" class="book-plane">
        </div>
    </nav>

<div class="flight-details-grid" id="book">
    <div class="flight-filter">
        <form method="GET" action="" class="filter-form">
            <div class="filter-group">
                <select name="source" required>
                    <option value="">Select Source</option>
                    <?php $__currentLoopData = $sources; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $source): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($source); ?>" <?php echo e(request('source') === $source ? 'selected' : ''); ?>>
                            <?php echo e($source); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>

                <i class="fas fa-exchange-alt"></i>

                <select name="destination" required>
                    <option value="">Select Destination</option>
                    <?php $__currentLoopData = $destinations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $destination): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($destination); ?>" <?php echo e(request('destination') === $destination ? 'selected' : ''); ?>>
                            <?php echo e($destination); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>

                <button type="submit" class="filter-btn">Search Flights</button>
            </div>
        </form>
    </div>
</div>
<?php if($flights->count() > 0): ?>
    <div class="flight-details-grid">
        <?php $__currentLoopData = $flights; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $flight): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="box">
                <div class="ticket-brief">
                    <div class="tb"><p class="tedit">💎Partially refundable</p></div>
                    <div class="tb"><p class="tedit">💰Best deal</p></div>
                    <div class="tb"><p class="tedit">🕓Pay later</p></div>
                </div>
                <div class="time">
                    <div class="departure"><p class="tedit"><?php echo e($flight->Start_time); ?></p></div>
                    <div class="duration"><p class="tedit"><?php echo e($flight->Duration); ?></p></div>
                    <div class="arrival"><p class="tedit"><?php echo e($flight->End_time); ?></p></div>
                </div>
                <div class="destination">
                    <div class="from"><p class="tedit"><?php echo e($flight->Flight_from); ?></p></div>
                    <div class="logo">
                        <img class="minilogo" src="<?php echo e(asset('pics/black_minimalist_jet_airplane_logo_design__1_-removebg-preview.png')); ?>">
                    </div>
                    <div class="to"><p class="tedit"><?php echo e($flight->Flight_to); ?></p></div>
                </div>
                <div class="date">
                    <div class="stdate"><p class="tedit2"><?php echo e($flight->Start_date); ?></p></div>
                    <div class="type"><p class="tedit2"><?php echo e($flight->Type); ?></p></div>
                    <div class="enddate"><p class="tedit2"><?php echo e($flight->Land_date); ?></p></div>
                </div>
                <div class="ticket-price">
                    <div class="ticket-id-price">
                        <div class="id"><p class="tedit2">🎫<?php echo e($flight->Flight_ID); ?></p></div>
                        <div class="price"><p class="tedit3">৳<?php echo e($flight->Price); ?></p></div>
                    </div>
                    <div class="select">
                        <?php if(auth()->guard()->check()): ?>
                            <a href="<?php echo e(route('transaction', ['flight_id' => $flight->Flight_ID])); ?>" 
                               class="select-button">
                                <p style="color: aliceblue; font-weight: 700;">Select></p>
                            </a>
                        <?php else: ?>
                            <button onclick="showFlightAccessDenied()" 
                                    class="select-button">
                                <p style="color: aliceblue; font-weight: 700;">Select></p>
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
<?php else: ?>
    <p>No flights found</p>
<?php endif; ?>
<div id="flightAccessDeniedModal" class="access-modal">
    <div class="access-modal-content">
        <i class="fas fa-lock"></i>
        <h3>Access Denied</h3>
        <p>Please login to book this flight</p>
        <a href="<?php echo e(route('login')); ?>" class="login-btn">Login Now</a>
    </div>
</div>
<div id="accessDeniedModal" class="modal">
    <div class="modal-content">
        <i class="fas fa-lock"></i>
        <h3>Access Denied</h3>
        <p>Please login to access your profile settings</p>
        <a href="<?php echo e(route('login')); ?>" class="login-btn">Login Now</a>
    </div>
</div>
<div id="rewardaccessDeniedModal" class="modal">
    <div class="modal-content">
        <i class="fas fa-lock"></i>
        <h3>Access Denied</h3>
        <p>Please login to access this feature</p>
        <a href="<?php echo e(route('login')); ?>" class="login-btn">Login Now</a>
    </div>
</div>
<div id="rewardAccessDeniedModal" class="modal">
    <div class="modal-content">
        <h2><i class="fas fa-exclamation-circle"></i> Access Denied</h2>
        <p>Please login to view your reward points.</p>
        <a href="<?php echo e(route('login')); ?>" class="login-btn">Login Now</a>
    </div>
</div>
<script>
window.onclick = function(event) {
    var accessModal = document.getElementById('accessDeniedModal');
    var flightModal = document.getElementById('flightAccessDeniedModal');
    var rewardModal = document.getElementById('rewardAccessDeniedModal');
    
    if (event.target == accessModal || event.target == flightModal) {
        accessModal.style.display = 'none';
        flightModal.style.display = 'none';
    }
}
</script>
</body>
</html><?php /**PATH C:\xampp\htdocs\Bachao\airline\resources\views/dashboard.blade.php ENDPATH**/ ?>