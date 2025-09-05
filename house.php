<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ELITE ESTATE</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/video.css">
    <link rel="stylesheet" href="css/house.css">

    <style>
        body {
            margin: 0;
            padding: 0;
        
            font-family: 'Inter', sans-serif;
            background-color: rgb(230,214,245);
        }

        .promotion-ad {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 300px;
            max-width: 90vw;
            height: auto;
            background-color: #ffffff;
            border: 1px solid #e0e0e0;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            padding: 15px;
            border-radius: 12px;
            z-index: 1000;
            font-family: 'Inter', sans-serif;
            opacity: 0;
            transform: translateY(20px);
            animation: fadeInAd 0.8s ease-out forwards;
            display: none;
        }

        @media (max-width: 600px) {
            .promotion-ad {
                bottom: 10px;
                right: 10px;
                width: calc(100% - 20px);
                max-width: unset;
            }
        }

        .promotion-ad img {
            max-width: 100%;
            height: auto;
            display: block;
            border-radius: 8px;
            margin-bottom: 10px;
        }

        .promotion-ad h3 {
            font-size: 1.2em;
            color: #333;
            margin-top: 0;
            margin-bottom: 5px;
            text-align: center;
        }
        .promotion-ad h2 {
            font-size: 1.2em;
            color: #333;
            margin-top: 0;
            margin-bottom: 5px;
            text-align: center;
        }

        .promotion-ad p {
            font-size: 0.9em;
            color: #555;
            line-height: 1.5;
            text-align: center;
            margin-bottom: 15px;
        }

        .promotion-ad .ad-link {
            display: block;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            padding: 10px 15px;
            border-radius: 6px;
            text-align: center;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .promotion-ad .ad-link:hover {
            background-color: #0056b3;
        }

        .close-btn {
            position: absolute;
            top: 8px;
            right: 12px;
            font-size: 26px;
            cursor: pointer;
            color: #aaaaaa;
            transition: color 0.3s ease;
            font-weight: normal;
            line-height: 1;
        }

        .close-btn:hover {
            color: #333333;
        }

        .discount-label {
            position: absolute;
            top: 15px;
            left: -35px;
            background-color: #ff4500;
            color: #fff;
            padding: 5px 30px;
            font-weight: bold;
            font-size: 0.9em;
            text-align: center;
            transform: rotate(-45deg);
            transform-origin: 0% 50%;
            z-index: 1001;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        @keyframes fadeInAd {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
    </head>
<?php include 'header.php' ?>

    <div class="container">
        <div>
            <h1 style="text-align: center;font-size:xx-large;"><b>Rental Houses</b></h1>
            <br><br><br>
        </div>
        <div class="rental-grid">
            <div class="rental-item">
                <img src="images/f1.png" alt="Cozy Apartment" loading="lazy">
                <div class="details">
                    <h3>Cozy Apartment</h3>
                    <p>2 Bedrooms, 3 Bathroom</p>
                    <h2>Price: 80,000</h2>
                    <a href="view details1.php" class="view-details-btn">View Details</a>
                </div>
            </div>
            <div class="rental-item">
                <img src="images/f2.png" alt="Rental House 2">
                <div class="details">
                    <h3>Modern Townhouse</h3>
                    <p>3 Bedrooms, 2 Bathrooms</p>
                    <h2>Price: 75,000</h2>
                    <a href="view details2.php" class="view-details-btn">View Details</a>
                </div>
            </div>
            <div class="rental-item">
                <img src="images/f3.png" alt="Rental House 3">
                <div class="details">
                    <h3>Family Home</h3>
                    <p>4 Bedrooms, 3 Bathrooms</p>
                    <h2>Price: 85,000</h2>
                    <a href="view details3.php" class="view-details-btn">View Details</a>
                </div>
            </div>
            <div class="rental-item">
                <img src="images/f4.png" alt="Rental House 4">
                <div class="details">
                    <h3>Studio Apartment</h3>
                    <p>5 Bedroom, 4 Bathroom</p>
                    <h2>Price: 70,000</h2>
                    <a href="view details4.php" class="view-details-btn">View Details</a>
                </div>
            </div>
            <div class="rental-item">
                <img src="images/f5.png" alt="Rental House 5">
                <div class="details">
                    <h3>Luxury Villa</h3>
                    <p>5 Bedrooms, 2 Bathrooms</p>
                    <h2>Price: 90,000</h2>
                    <a href="view details5.php" class="view-details-btn">View Details</a>
                </div>
            </div>
            <div class="rental-item">
                <img src="images/f6.png" alt="Rental House 6">
                <div class="details">
                    <h3>House with View</h3>
                    <p>6 Bedrooms, 2 Bathrooms</p>
                    <h2>Price: 92,000</h2>
                    <a href="view details6.php" class="view-details-btn">View Details</a>
                </div>
            </div>
            <div class="rental-item">
                <img src="images/f7.png" alt="Rental House 7">
                <div class="details">
                    <h3>Small Cottage</h3>
                    <p>4 Bedroom, 3 Bathroom</p>
                    <h2>Price:85,000</h2>
                    <a href="view details7.php" class="view-details-btn">View Details</a>
                </div>
            </div>
            <div class="rental-item">
                <img src="images/f8.png" alt="Rental House 8">
                <div class="details">
                    <h3>Large House</h3>
                    <p>6 Bedrooms, 3 Bathrooms</p>
                    <h2>Price: 80,000</h2>
                    <a href="view details8.php" class="view-details-btn">View Details</a>
                </div>
            </div>
        </div>
    </div>

    <div class="promotion-ad" id="promo-ad">
        <span class="close-btn" onclick="hidePromotionAd();">&times;</span>
        <div class="discount-label">15% OFF</div>
        <a href="https://www.google.com" target="_blank">
            <img src="images/f2.png" alt="Promotion Ad Image">
        </a>
        <h3>Check Out Our Latest Offer!</h3>
        <h2>Sleekline Residence(ID-5)</h2>
        <p>Get amazing discounts on your favorite items. Shop now!</p>
        <a href="view details2.php" target="_blank" class="ad-link">View Now</a>
    </div>



<?php include 'footer.php' ?>

    <script src="js/script.js"></script>

    <script>
        const promoAd = document.getElementById('promo-ad');
        const localStorageKey = 'promotionAdClosed';
        const adDisplayDelay = 10000;

        function hidePromotionAd() {
            promoAd.style.display = 'none';
            localStorage.setItem(localStorageKey, 'true');
        }

        document.addEventListener('DOMContentLoaded', () => {
            const hasClosedAd = localStorage.getItem(localStorageKey);
            if (!hasClosedAd) {
                setTimeout(() => {
                    promoAd.style.display = 'block';
                }, adDisplayDelay);
            }
        });
    </script>
    </body>
</html>