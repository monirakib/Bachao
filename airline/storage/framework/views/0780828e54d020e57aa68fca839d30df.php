<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bachao Airlines - Recommendations</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            margin: 0;
            font-family: 'Murecho', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        }

        .header {
            text-align: center;
            padding: 50px 0;
            position: relative;
            z-index: 1;
            margin-bottom: 20px;
        }
        .hero-content{
            text-align: center;
        }

        .floating-title {
            font-family: 'Brush Script MT', cursive;
            font-size: 85px;
            font-style: italic;
            color: #FF8C00;
            text-shadow: 3px 3px 5px rgba(0,0,0,0.4);
            animation: float 3s ease-in-out infinite;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 20px;
            position: relative;
            z-index: 2;
            color: #FF8C00;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.6);
        }

        .airplane-icon {
            font-size: 60px;
            color: #FF8C00;
        }

        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0px); }
        }

        .letter {
            display: inline-block;
            opacity: 0;
            animation: letterAppear 0.3s forwards, float 3s ease-in-out infinite;
        }

        @keyframes letterAppear {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .section {
            width: 95vw;
            max-width: 1600px;
            margin: 30px auto;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        .section:hover {
            transform: scale(1.02);
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
        }

        .explore-section {
            margin-top: 20px;
            background-color: #F5F7FA;
        }

        .explore-message {
            color: #666;
            font-size: 14px;
            text-align: center;
            margin: 0 0 25px;
            line-height: 1.6;
        }

        .cities-container {
            width: 100%;
            padding: 20px;
            box-sizing: border-box;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 25px;
        }

        .city-card {
            width: 100%;
            background: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .city-card:hover {
            transform: translateY(-10px);
        }

        .city-image {
            width: 100%;
            height: 400px;
            object-fit: cover;
            border-radius: 8px 8px 0 0;
        }

        .city-card h3 {
            padding: 15px;
            margin: 0;
            font-size: 18px;
        }

        .city-card p {
            padding: 0 15px 15px;
            margin: 0;
            color: #666;
        }

        .airlines-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 30px;
            padding: 20px;
        }

        .airline-card {
            width: 200px;
            margin: 15px;
            padding: 15px;
            text-align: center;
            background: white;
            border-radius: 8px;
            transition: transform 0.3s;
        }

        .airline-card:hover {
            transform: scale(1.1);
        }

        .airline-logo {
            width: 150px;
            height: auto;
        }

        .airline-card h3 {
            font-size: 16px;
            margin: 10px 0;
        }

        .hotels-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 30px;
            padding: 20px;
            width: 100%;
        }

        .hotel-card {
            background: white;
            border-radius: 8px;
            padding: 15px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            margin-bottom: 15px;
            transition: transform 0.3s;
        }

        .hotel-card:hover {
            transform: scale(1.05);
        }

        .hotel-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 8px;
        }

        .routes-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 25px;
            padding: 20px;
        }

        .route-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .route-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 40px rgba(0,0,0,0.15);
        }

        .route-type {
            position: absolute;
            top: 15px;
            right: 15px;
            background: #2da0a8;
            color: white;
            padding: 5px 15px;
            border-radius: 25px;
            font-size: 0.9em;
            font-weight: 600;
        }

        .route-card h3 {
            margin: 25px 0 15px;
            color: #2c3e50;
            font-size: 1.3em;
        }

        .route-price {
            color: #2da0a8;
            font-size: 1.2em;
            font-weight: 700;
            margin: 15px 0;
        }

        .book-btn {
            display: inline-block;
            background: #2da0a8;
            color: white;
            padding: 10px 25px;
            border-radius: 25px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .book-btn:hover {
            background: #248f96;
            transform: translateY(-2px);
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

        @media (max-width: 1200px) {
            .routes-container {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        .popular-destinations {
            overflow: hidden;
            white-space: nowrap;
            padding: 20px 0;
            background: rgba(255,255,255,0.9);
            border-radius: 10px;
        }

        .destination-slider {
            display: inline-block;
            animation: slide 40s linear infinite;
        }

        .destination-slider:hover {
            animation-play-state: paused;
        }

        .destination-item {
            display: inline-block;
            margin: 0 15px;
            position: relative;
            transition: transform 0.3s;
            overflow: hidden;
            border-radius: 15px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.1);
            animation: fadeInUp 0.5s ease forwards;
        }

        .destination-item:hover {
            transform: translateY(-10px);
        }

        .destination-image {
            width: 100%;
            height: 250px;
            object-fit: cover;
            transition: all 0.5s ease;
        }

        .destination-item:hover .destination-image {
            transform: scale(1.1);
        }

        .destination-name {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 20px;
            background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);
            color: white;
            font-weight: 700;
            font-size: 1.2em;
            transform: translateY(0);
            transition: all 0.3s ease;
        }

        @keyframes slide {
            0% { transform: translateX(100%); }
            100% { transform: translateX(-100%); }
        }

        .destinations-section, 
        .airlines-section {
            max-width: 1200px;
            margin: 30px auto;
            background-color: #ffffff;
        }

        .hotels-section {
            max-width: 1200px;
            margin: 30px auto;
            padding: 40px;
            border-radius: 15px;
        }

        .hotel-section {
            margin-bottom: 30px;
        }

        .routes-section {
            width: 98vw;
            max-width: 1900px;
            margin: 30px auto;
            padding: 40px;
            background-color: #F5F7FA;
            border-radius: 15px;
        }

        .video-background {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 300px;
            overflow: hidden;
            z-index: -1;
        }

        .video-background video {
            width: 100%;
            height: 300px;
            object-fit: cover;
            position: absolute;
        }

        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 300px;
            background: rgba(0, 0, 0, 0.3);
            z-index: -1;
        }

        .section h2 {
            text-align: center;
            font-size: 32px;
            margin-bottom: 30px;
            color: #333;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .hotels-section h2,
        .routes-section h2 {
            text-align: left;
            padding-left: 20px;
        }

        .airlines-section h2,
        .destinations-section h2 {
            text-align: center;
        }

        .destinations-header {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 50px 20px;
            text-align: center;
        }

        .destinations-header h2 {
            font-size: 2.5em;
            color: #2c3e50;
            font-weight: 700;
            margin: 0;
            animation: fadeInDown 0.5s ease;
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
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
    <a href="<?php echo e(route('dashboard')); ?>" class="back-btn">
        <i class="fas fa-arrow-left"></i> Back to Dashboard
    </a>
    <div class="video-background">
        <video autoplay muted loop>
            <source src="pics/recopics/Light Blue Music Ocean Waves Inspirational Video.mp4" type="video/mp4">
        </video>
        <div class="overlay"></div>
    </div>

    <div class="header">
        <h1 class="floating-title">
            <i class="fas fa-plane airplane-icon"></i>
            <?php
            $title = "Bachao Airlines";
            $letters = str_split($title);
            foreach ($letters as $index => $letter) {
                echo '<span class="letter" style="animation-delay: ' . ($index * 0.1) . 's">' . $letter . '</span>';
            }
            ?>
        </h1>
    </div>

    <div class="hero-section">
        <div class="hero-content">
            <h1>Discover Amazing Destinations</h1>
            <p>Explore our recommended routes and find your next adventure</p>
        </div>
    </div>

    <div class="section-divider"></div>

    <div class="section explore-section">
        <h2>Explore Bangladesh</h2>
        <p class="explore-message">
            Prepare to experience Bangladesh's rich culture and explore the majestic beauties of Cox's Bazar, Sylhet, Bandarban, Sajek Valley, Rangamati etc. Plan your trip now!
        </p>
        <div class="cities-container">
            <div class="city-card">
                <img src="pics/recopics/Dhaka.jpg" alt="Dhaka" class="city-image">
                <h3>Dhaka</h3>
                <p>The capital city with vibrant culture and modern amenities.</p>
            </div>
            <div class="city-card">
                <img src="pics/recopics/Coxs.jpg" alt="Cox's Bazar" class="city-image">
                <h3>Cox's Bazar</h3>
                <p>World's longest natural sea beach.</p>
            </div>
            <div class="city-card">
                <img src="pics/recopics/Chittagong.jpg" Chittagong" class="city-image">
                <h3>Chittagong</h3>
                <p>The port city with beautiful hills and beaches.</p>
            </div>
            <div class="city-card">
                <img src="pics/recopics/Sylhets.jpeg" alt="Sylhet" class="city-image">
                <h3>Sylhet</h3>
                <p>Known for its tea gardens and natural beauty.</p>
            </div>
        </div>
    </div>

    <div class="section airlines-section">
        <h2>Top Airlines</h2>
        <div class="airlines-container">
            <div class="airline-card">
                <img src="pics/recopics/borcelle.jpg" alt="Borcelle Airlines" class="airline-logo">
                <h3>Borcelle Airlines</h3>
            </div>
            <div class="airline-card">
                <img src="pics/recopics/Bangla.jpg" alt="Bengla Airlines" class="airline-logo">
                <h3>Bengla Airlines</h3>
            </div>
            <div class="airline-card">
                <img src="pics/recopics/Novo.jpg" alt="Novo Airways" class="airline-logo">
                <h3>Novo Airways</h3>
            </div>
            <div class="airline-card">
                <img src="pics/recopics/planecloud.jpg" alt="Skylimit Bangladesh" class="airline-logo">
                <h3>Skylimit Bangladesh</h3>
            </div>
            <div class="airline-card">
                <img src="pics/recopics/RemendAirlines.jpg" alt="Remend Airlines" class="airline-logo">
                <h3>Remend Airlines</h3>
            </div>
            <div class="airline-card">
                <img src="pics/recopics/Rose.jpg" alt="Rose Maria Airlines" class="airline-logo">
                <h3>Rose Maria Airlines</h3>
            </div>
            <div class="airline-card">
                <img src="pics/recopics/Uthao.jpg" alt="Uthao Airlines" class="airline-logo">
                <h3>Uthao Airlines</h3>
            </div>
            <div class="airline-card">
                <img src="pics/recopics/Flight bottle.jpg" alt="Flight Bottle" class="airline-logo">
                <h3>Flight Bottle</h3>
            </div>
            <div class="airline-card">
                <img src="pics/recopics/Altitude.jpg" alt="Altitude Airlines" class="airline-logo">
                <h3>Altitude Airlines</h3>
            </div>
            <div class="airline-card">
                <img src="pics/recopics/Cravity.jpg" alt="Cravity Airways" class="airline-logo">
                <h3>Cravity Airways</h3>
            </div>
        </div>
    </div>

    <div class="section hotels-section">
        <h2>Recommended Hotels</h2>
        <div class="hotels-container">
            <?php
            $hotels = [
                'Dhaka' => [
                    ['name' => 'Hotel InterContinental', 'rating' => '5⭐', 'distance' => '2km from airport'],
                    ['name' => 'Le Méridien', 'rating' => '5⭐', 'distance' => '3km from airport']
                ],
                'Chittagong' => [
                    ['name' => 'Radisson Blu', 'rating' => '5⭐', 'distance' => '1km from airport'],
                    ['name' => 'Peninsula Chittagong', 'rating' => '4⭐', 'distance' => '2km from airport']
                ],
                'Sylhet' => [
                    ['name' => 'Rose View Hotel', 'rating' => '4⭐', 'distance' => '3km from airport'],
                    ['name' => 'Hotel Star Pacific', 'rating' => '4⭐', 'distance' => '2km from airport']
                ]
            ];

            foreach ($hotels as $city => $cityHotels) {
                echo "<div class='hotel-section'>";
                echo "<h3>$city Hotels</h3>";
                foreach ($cityHotels as $hotel) {
                    echo "<div class='hotel-card'>";
                    switch($hotel['name']) {
                        case 'Hotel InterContinental':
                            echo "<img src='pics/recopics/hotels/intercontinental.jpg' alt='Hotel InterContinental' class='hotel-image'>";
                            break;
                        case 'Le Méridien':
                            echo "<img src='pics/recopics/hotels/meridien.jpg' alt='Le Méridien' class='hotel-image'>";
                            break;
                        case 'Radisson Blu':
                            echo "<img src='pics/recopics/hotels/radisson.jpg' alt='Radisson Blu' class='hotel-image'>";
                            break;
                        case 'Peninsula Chittagong':
                            echo "<img src='pics/recopics/hotels/peninsula.jpg' alt='Peninsula Chittagong' class='hotel-image'>";
                            break;
                        case 'Rose View Hotel':
                            echo "<img src='pics/recopics/hotels/roseview.jpg' alt='Rose View Hotel' class='hotel-image'>";
                            break;
                        case 'Hotel Star Pacific':
                            echo "<img src='pics/recopics/hotels/starpacific.jpg' alt='Hotel Star Pacific' class='hotel-image'>";
                            break;
                    }
                    echo "<h4>{$hotel['name']}</h4>";
                    echo "<p>Rating: {$hotel['rating']}</p>";
                    echo "<p>{$hotel['distance']}</p>";
                    echo "</div>";
                }
                echo "</div>";
            }
            ?>
        </div>
    </div>

    <div class="destinations-section">
        <div class="destinations-header">
            <h2>Discover Amazing Destinations</h2>
        </div>
        <div class="destinations-container">
            <div class="popular-destinations">
                <div class="destination-slider">
                    <div class="destination-item">
                        <img src="pics/recopics/Paris.jpg" alt="Paris" class="destination-image">
                        <div class="destination-name">Paris, France</div>
                    </div>
                    <div class="destination-item">
                        <img src="pics/recopics/Dubai.jpg" alt="Dubai" class="destination-image">
                        <div class="destination-name">Dubai, UAE</div>
                    </div>
                    <div class="destination-item">
                        <img src="pics/recopics/Maldives.jpg" alt="Maldives" class="destination-image">
                        <div class="destination-name">Maldives</div>
                    </div>
                    <div class="destination-item">
                        <img src="pics/recopics/Tokyo.jpg" alt="Tokyo" class="destination-image">
                        <div class="destination-name">Tokyo, Japan</div>
                    </div>
                    <div class="destination-item">
                        <img src="pics/recopics/Istanbul.jpg" alt="Istanbul" class="destination-image">
                        <div class="destination-name">Istanbul, Turkey</div>
                    </div>
                    <div class="destination-item">
                        <img src="pics/recopics/Singapore.jpg" alt="Singapore" class="destination-image">
                        <div class="destination-name">Singapore</div>
                    </div>
                    <div class="destination-item">
                        <img src="pics/recopics/Bali.jpg" alt="Bali" class="destination-image">
                        <div class="destination-name">Bali, Indonesia</div>
                    </div>
                    <div class="destination-item">
                        <img src="pics/recopics/NYC.jpg" alt="New York" class="destination-image">
                        <div class="destination-name">New York, USA</div>
                    </div>
                    <div class="destination-item">
                        <img src="pics/recopics/London.jpg" alt="London" class="destination-image">
                        <div class="destination-name">London, UK</div>
                    </div>
                    <div class="destination-item">
                        <img src="pics/recopics/Bangkok.jpg" alt="Bangkok" class="destination-image">
                        <div class="destination-name">Bangkok, Thailand</div>
                    </div>
                    <div class="destination-item">
                        <img src="pics/recopics/Sydney.jpg" alt="Sydney" class="destination-image">
                        <div class="destination-name">Sydney, Australia</div>
                    </div>
                    <div class="destination-item">
                        <img src="pics/recopics/Rome.jpg" alt="Rome" class="destination-image">
                        <div class="destination-name">Rome, Italy</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="section routes-section">
        <h2>Top Domestic & International Routes</h2>
        <div class="routes-container">
            <div class="route-card">
                <div class="route-type">Domestic</div>
                <h3>Dhaka ✈ Chittagong</h3>
                <p>Duration: 1h</p>
                <p class="route-price">Starting from 3,500৳</p>
                <a href="dashboard.php#book" class="book-btn">Book Now</a>
            </div>

            <div class="route-card">
                <div class="route-type">Domestic</div>
                <h3>Dhaka ✈ Cox's Bazar</h3>
                <p>Duration: 1h</p>
                <p class="route-price">Starting from 4,500৳</p>
                <a href="dashboard.php#book" class="book-btn">Book Now</a>
            </div>

            <div class="route-card">
                <div class="route-type">Domestic</div>
                <h3>Dhaka ✈ Sylhet</h3>
                <p>Duration: 45m</p>
                <p class="route-price">Starting from 3,200৳</p>
                <a href="dashboard.php#book" class="book-btn">Book Now</a>
            </div>

            <div class="route-card">
                <div class="route-type">International</div>
                <h3>Dhaka ✈ Dubai</h3>
                <p>Duration: 6h 30m</p>
                <p class="route-price">Starting from 45,000৳</p>
                <a href="dashboard.php#book" class="book-btn">Book Now</a>
            </div>

            <div class="route-card">
                <div class="route-type">International</div>
                <h3>Dhaka ✈ Bangkok</h3>
                <p>Duration: 3h 15m</p>
                <p class="route-price">Starting from 35,000৳</p>
                <a href="dashboard.php#book" class="book-btn">Book Now</a>
            </div>

            <div class="route-card">
                <div class="route-type">International</div>
                <h3>Dhaka ✈ Singapore</h3>
                <p>Duration: 4h 30m</p>
                <p class="route-price">Starting from 42,000৳</p>
                <a href="dashboard.php#book" class="book-btn">Book Now</a>
            </div>

            <div class="route-card">
                <div class="route-type">International</div>
                <h3>Dhaka ✈ Kuala Lumpur</h3>
                <p>Duration: 4h</p>
                <p class="route-price">Starting from 38,000৳</p>
                <a href="dashboard.php#book" class="book-btn">Book Now</a>
            </div>

            <div class="route-card">
                <div class="route-type">International</div>
                <h3>Dhaka ✈ London</h3>
                <p>Duration: 10h 30m</p>
                <p class="route-price">Starting from 85,000৳</p>
                <a href="dashboard.php#book" class="book-btn">Book Now</a>
            </div>

            <div class="route-card">
                <div class="route-type">International</div>
                <h3>Dhaka ✈ New York</h3>
                <p>Duration: 18h 45m</p>
                <p class="route-price">Starting from 95,000৳</p>
                <a href="dashboard.php#book" class="book-btn">Book Now</a>
            </div>

            <div class="route-card">
                <div class="route-type">International</div>
                <h3>Dhaka ✈ Tokyo</h3>
                <p>Duration: 7h 15m</p>
                <p class="route-price">Starting from 65,000৳</p>
                <a href="dashboard.php#book" class="book-btn">Book Now</a>
            </div>

            <div class="route-card">
                <div class="route-type">International</div>
                <h3>Dhaka ✈ Istanbul</h3>
                <p>Duration: 8h 20m</p>
                <p class="route-price">Starting from 55,000৳</p>
                <a href="dashboard.php#book" class="book-btn">Book Now</a>
            </div>
        </div>
    </div>
</body>
</html><?php /**PATH C:\xampp\htdocs\Bachao\airline\resources\views/recommend.blade.php ENDPATH**/ ?>