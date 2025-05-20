<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bachao Airlines - Promotions</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f0f5ff;
        }

        .slider-wrapper {
            width: 80%;
            margin: 20px auto;
            overflow: hidden;
            position: relative;
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .slider {
            display: flex;
            width: 400%;
            animation: slideShow 20s infinite;
        }

        .slide {
            width: 25%;
            height: 400px;
            background-size: cover;
            background-position: center;
        }

        @keyframes slideShow {
            0%, 20% { transform: translateX(0); }
            25%, 45% { transform: translateX(-25%); }
            50%, 70% { transform: translateX(-50%); }
            75%, 95% { transform: translateX(-75%); }
            100% { transform: translateX(0); }
        }

        .offers-container {
            max-width: 1200px;
            margin: 40px auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            padding: 20px;
        }

        .offer-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }

        .offer-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        .offer-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .offer-content {
            padding: 20px;
        }

        .promo-code {
            background: #FF8C00;
            color: white;
            padding: 8px 15px;
            border-radius: 5px;
            display: inline-block;
            margin: 10px 0;
        }

        .category {
            color: #666;
            font-size: 0.9em;
            margin-bottom: 10px;
        }

        .about-section {
            background: linear-gradient(135deg, #8e9eab 0%, #eef2f3 100%);
            color: #333;
            padding: 60px 20px;
            margin-top: 50px;
        }

        .about-container {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 40px;
            padding: 20px;
        }

        .about-content h2 {
            font-size: 36px;
            margin-bottom: 20px;
            color: #1e3c72;
        }

        .about-content p {
            line-height: 1.8;
            margin-bottom: 15px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-top: 30px;
        }

        .stat-item {
            text-align: center;
            padding: 20px;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 10px;
        }

        .stat-number {
            font-size: 32px;
            font-weight: bold;
            color: #1e3c72;
        }

        .stat-label {
            font-size: 14px;
            color: #444;
        }

        .back-btn {
            position: fixed;
            top: 20px;
            left: 20px;
            background: rgba(255, 140, 0, 0.9);
            color: white;
            padding: 12px 25px;
            border-radius: 25px;
            text-decoration: none;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 8px;
            z-index: 1000;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }

        .back-btn:hover {
            transform: translateX(-5px);
            background: #FF8C00;
        }
    </style>
</head>
<body>
    <a href="{{ route('dashboard') }}" class="back-btn">
        <i class="fas fa-arrow-left"></i> Back to Dashboard
    </a>
    
    <div class="slider-wrapper">
        <div class="slider">
            <div class="slide" style="background-image: url('pics/promocodes/bkash slide.jpg');"></div>
            <div class="slide" style="background-image: url('pics/promocodes/gp star slide.jpg');"></div>
            <div class="slide" style="background-image: url('pics/promocodes/slide4.jpg');"></div>
            <div class="slide" style="background-image: url('pics/promocodes/slide3.jpg');"></div>
        </div>
    </div>

    <div class="offers-container">
        <!-- Payment Method Offers -->
        <div class="offer-card" onclick="window.location='promo_details.php?code=BKASH20'">
            <img src="pics/promocodes/bkashs.jpg" alt="bKash Offer" class="offer-image">
            <div class="offer-content">
                <div class="category">Payment Partner</div>
                <h3>20% Off with bKash</h3>
                <div class="promo-code">BKASH20</div>
                <p>Save up to 2000৳ on domestic flights</p>
            </div>
        </div>

        <div class="offer-card" onclick="window.location='promo_details.php?code=NAGAD15'">
            <img src="pics/promocodes/Nagads.jpg" alt="Nagad Offer" class="offer-image">
            <div class="offer-content">
                <div class="category">Payment Partner</div>
                <h3>15% Off with Nagad</h3>
                <div class="promo-code">NAGAD15</div>
                <p>Save up to 1500৳ on all flights</p>
            </div>
        </div>

        <!-- Special Category Discounts -->
        <div class="offer-card" onclick="window.location='promo_details.php?code=STUDENT10'">
            <img src="pics/promocodes/studentts.jpg" alt="Student Offer" class="offer-image">
            <div class="offer-content">
                <div class="category">Student Special</div>
                <h3>10% Student Discount</h3>
                <div class="promo-code">STUDENT10</div>
                <p>Valid student ID required</p>
            </div>
        </div>

        <div class="offer-card" onclick="window.location='promo_details.php?code=FAMILY25'">
            <img src="pics/promocodes/family.jpg" alt="Family Offer" class="offer-image">
            <div class="offer-content">
                <div class="category">Family Package</div>
                <h3>25% Off Family Bookings</h3>
                <div class="promo-code">FAMILY25</div>
                <p>For 4+ passengers</p>
            </div>
        </div>

        <!-- Seasonal Offers -->
        <div class="offer-card" onclick="window.location='promo_details.php?code=SUMMER30'">
            <img src="pics/promocodes/summer.jpg" alt="Summer Offer" class="offer-image">
            <div class="offer-content">
                <div class="category">Seasonal</div>
                <h3>30% Summer Special</h3>
                <div class="promo-code">SUMMER30</div>
                <p>Hot deals for summer travel</p>
            </div>
        </div>

        <!-- First Time Flyer -->
        <div class="offer-card" onclick="window.location='promo_details.php?code=FIRST40'">
            <img src="pics/promocodes/First40.jpg" alt="First Time Offer" class="offer-image">
            <div class="offer-content">
                <div class="category">New Customer</div>
                <h3>40% First Flight Discount</h3>
                <div class="promo-code">FIRST40</div>
                <p>For first-time flyers</p>
            </div>
        </div>

        <!-- MasterCard Offer -->
        <div class="offer-card" onclick="window.location='promo_details.php?code=MASTER35'">
            <img src="pics/promocodes/mastercard.jpg" alt="MasterCard Offer" class="offer-image">
            <div class="offer-content">
                <div class="category">Payment Partner</div>
                <h3>35% Off with MasterCard</h3>
                <div class="promo-code">MASTER35</div>
                <p>Exclusive discount for MasterCard holders</p>
            </div>
        </div>

        <!-- Grameenphone Offer -->
        <div class="offer-card" onclick="window.location='promo_details.php?code=GP25'">
            <img src="pics/promocodes/gps.jpg" alt="Grameenphone Offer" class="offer-image">
            <div class="offer-content">
                <div class="category">Telecom Partner</div>
                <h3>25% Off for GP STAR</h3>
                <div class="promo-code">GP25</div>
                <p>Special discount for GP STAR members</p>
            </div>
        </div>

        <!-- Robi Offer -->
        <div class="offer-card" onclick="window.location='promo_details.php?code=ROBI20'">
            <img src="pics/promocodes/robi.jpg" alt="Robi Offer" class="offer-image">
            <div class="offer-content">
                <div class="category">Telecom Partner</div>
                <h3>20% Off for Robi Users</h3>
                <div class="promo-code">ROBI20</div>
                <p>Exclusive for Robi subscribers</p>
            </div>
        </div>

        <!-- Unilever Offer -->
        <div class="offer-card" onclick="window.location='promo_details.php?code=UNI15'">
            <img src="pics/promocodes/uniliver.jpg" alt="Unilever Offer" class="offer-image">
            <div class="offer-content">
                <div class="category">Brand Partner</div>
                <h3>15% Off with Unilever</h3>
                <div class="promo-code">UNI15</div>
                <p>For Unilever product purchasers</p>
            </div>
        </div>

        <!-- PRAN-RFL Offer -->
        <div class="offer-card" onclick="window.location='promo_details.php?code=PRAN25'">
            <img src="pics/promocodes/pran.jpg" alt="PRAN Offer" class="offer-image">
            <div class="offer-content">
                <div class="category">Brand Partner</div>
                <h3>25% Off PRAN Special</h3>
                <div class="promo-code">PRAN25</div>
                <p>Exclusive offer for PRAN customers</p>
            </div>
        </div>

        <!-- City Bank Offer -->
        <div class="offer-card" onclick="window.location='promo_details.php?code=CITY30'">
            <img src="pics/promocodes/City-Bank.jpg" alt="City Bank Offer" class="offer-image">
            <div class="offer-content">
                <div class="category">Banking Partner</div>
                <h3>30% Off with City Bank</h3>
                <div class="promo-code">CITY30</div>
                <p>For City Bank card holders</p>
            </div>
        </div>

        <!-- DBBL Offer -->
        <div class="offer-card" onclick="window.location='promo_details.php?code=DBBL20'">
            <img src="pics/promocodes/dbbl.jpg" alt="Dutch-Bangla Bank Offer" class="offer-image">
            <div class="offer-content">
                <div class="category">Banking Partner</div>
                <h3>20% Off with DBBL</h3>
                <div class="promo-code">DBBL20</div>
                <p>Special offer for DBBL customers</p>
            </div>
        </div>

        <!-- Pathao Offer -->
        <div class="offer-card" onclick="window.location='promo_details.php?code=PATHAO15'">
            <img src="pics/promocodes/pathao.jpg" alt="Pathao Offer" class="offer-image">
            <div class="offer-content">
                <div class="category">Ride Sharing Partner</div>
                <h3>15% Off with Pathao</h3>
                <div class="promo-code">PATHAO15</div>
                <p>Special discount for Pathao users</p>
            </div>
        </div>
    </div>

    <div class="about-section">
        <div class="about-container">
            <div class="about-content">
                <h2>About Bachao Airlines</h2>
                <p>Founded in 2024, Bachao Airlines has become Bangladesh's most trusted airline, connecting millions of passengers to destinations across Asia and beyond.</p>
                <p>Our mission is to provide safe, reliable, and affordable air travel while maintaining the highest standards of Bengali hospitality.</p>
                <p>With a modern fleet and dedicated team, we're committed to making air travel accessible to everyone in Bangladesh.</p>
            </div>
            <div class="stats-grid">
                <div class="stat-item">
                    <div class="stat-number">50+</div>
                    <div class="stat-label">Destinations</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">20+</div>
                    <div class="stat-label">Aircraft</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">10000+</div>
                    <div class="stat-label">Happy Passengers</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">99%</                    <div class="stat-label">On-time Flights</div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

<?php
$promoDetails = [
    'SUMMER30' => [
        'title' => '30% Summer Special Discount',
        'description' => 'Beat the heat with cool summer travel deals',
        'terms' => [
            'Valid from June 1 to August 31, 2024',
            'Maximum discount of 5000৳',
            'Valid on all international routes',
            'Blackout dates apply during peak season'
        ]
    ],
    'FIRST40' => [
        'title' => '40% First Flight Discount',
        'description' => 'Special welcome offer for first-time flyers',
        'terms' => [
            'One-time use per customer',
            'Maximum discount of 4000৳',
            'Valid on domestic flights only',
            'Must create account to redeem'
        ]
    ],
    'SENIOR25' => [
        'title' => '25% Senior Citizen Discount',
        'description' => 'Special care for our senior travelers',
        'terms' => [
            'Valid ID required showing age 60+',
            'Maximum discount of 3000৳',
            'Valid on all routes',
            'Not combinable with other offers'
        ]
    ]
];
?>