<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>

    <!-- font awesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

    <!-- custom css file link -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/furnish 1.css">
    <style>
        /* General styling for sections to match the client reviews section */
        section.reviews, section.steps {
            padding: 2rem 5%;
            background: #f7f7f7;
        }
        
        /* Heading style consistent across sections */
        .heading {
            text-align: center;
            font-size: 3.5rem;
            color: #333;
            margin-bottom: 3rem;
            text-transform: capitalize;
        }

        /* Styles for the steps section */
        .steps .box-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            gap: 2rem;
        }

        .steps .box {
            flex: 1 1 30rem;
            border: 1px solid #ddd;
            padding: 2rem;
            border-radius: 0.5rem;
            background-color: #fff;
            box-shadow: 0 0.4rem 0.8rem rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            opacity: 0;
            animation: fadeIn 0.5s forwards, moveIn 0.5s forwards;
            animation-delay: var(--delay);
            cursor: pointer;
            text-align: center;
        }

        .steps .box:nth-child(1) { --delay: 0.2s; }
        .steps .box:nth-child(2) { --delay: 0.4s; }
        .steps .box:nth-child(3) { --delay: 0.6s; }

        .steps .box img {
            width: 100%;
            max-height: 20rem;
            object-fit: contain;
            margin-bottom: 1.5rem;
        }

        .steps .box h3 {
            font-size: 2.5rem;
            color: #444;
            margin-bottom: 1rem;
        }

        .steps .box p {
            font-size: 1.6rem;
            color: #666;
        }

        .steps .box:hover {
            transform: translateY(-1rem);
            box-shadow: 0 0.6rem 1.2rem rgba(0, 0, 0, 0.2);
        }

        /* Keyframes for animations */
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes moveIn {
            from { transform: translateY(5rem) scale(0.8); }
            to { transform: translateY(0) scale(1); }
        }

        /* Styles for the reviews section */
        .reviews .box-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(30rem, 1fr));
            gap: 2rem;
            justify-content: center;
        }

        .reviews .box {
            background-color: #fff;
            padding: 2rem;
            border: 1px solid #ddd;
            border-radius: 0.5rem;
            box-shadow: 0 0.4rem 0.8rem rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .reviews .box .user {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            margin-bottom: 1rem;
        }

        .reviews .box .user img {
            height: 7rem;
            width: 7rem;
            border-radius: 50%;
            object-fit: cover;
        }

        .reviews .box .user h3 {
            font-size: 2rem;
            color: #333;
        }

        .reviews .box .user .stars {
            font-size: 1.5rem;
            color: gold;
        }

        .reviews .box p {
            line-height: 2;
            font-size: 1.6rem;
            color: #666;
        }

        .reviews .box:hover {
            transform: translateY(-1rem);
            box-shadow: 0 0.6rem 1.2rem rgba(0, 0, 0, 0.2);
        }

        @media (max-width: 768px) {
            .steps .box, .reviews .box {
                flex: 1 1 100%;
            }
        }
    </style>
</head>
<body>
<?php
// Database connection code
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "elitestate";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    // You might want to handle this more gracefully on the live site
    die("Connection failed: " . $conn->connect_error);
}
?>

<?php include 'header.php' ?>

<!-- header section ends -->

<!-- about section starts  -->
<section class="about">
    <div class="row">
        <div class="image">
            <img src="images/about1.jpg" alt="Snow" style="width:100%;">
            <div class="text" style="color:#0e0c0d;" fontsize="50px"> </div>
        </div>
        <div class="content">
            <h3>Why choose us?</h3>
            <p><b>We're a dedicated real estate team with deep local expertise, committed to helping you find the perfect property or achieve your selling goals. We prioritize building lasting relationships through transparent communication and personalized services.</b></p>
            <a href="contact.php" class="inline-btn">contact us</a>
        </div>
    </div>
</section>
<!-- about section ends -->

<!-- steps section starts -->
<section class="steps">
    <h1 class="heading">3 simple steps</h1>
    <div class="box-container">
        <div class="box">
            <img src="images/search property.png" alt="">
            <h3>Search for a Property</h3>
            <p>Find the perfect property for you by browsing our extensive listings.</p>
        </div>
        <div class="box">
            <img src="images/contact image.png" alt="">
            <h3>Contact Our Agents</h3>
            <p>Get in touch with our experienced agents for expert advice and assistance.</p>
        </div>
        <div class="box">
            <img src="images/enjoy.png" alt="">
            <h3>Enjoy Your New Property</h3>
            <p>Settle in and make your new property your own.</p>
        </div>
    </div>
</section>
<!-- steps section ends -->

<!-- review section starts -->
<section class="reviews">
    <h1 class="heading">Client's reviews</h1>
    <div class="box-container">
        <div class="box">
            <div class="user">
                <img src="images/pic-1.png" alt="">
                <div>
                    <h3>Hammad ahmad</h3>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                </div>
            </div>
            <p>I absolutely love my new apartment! The location is perfect, and the amenities are top-notch. It's a bit noisy at times, but overall, I'm very happy.</p>
        </div>
        <div class="box">
            <div class="user">
                <img src="images/pic-2.png" alt="">
                <div>
                    <h3>Maryam</h3>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                </div>
            </div>
            <p>The house is beautiful, but the neighborhood isn't the best. I'm also having some issues with the plumbing that the landlord hasn't addressed.</p>
        </div>
        <div class="box">
            <div class="user">
                <img src="images/pic-3.png" alt="">
                <div>
                    <h3>Tahir abbas</h3>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                </div>
            </div>
            <p>This condo is a great investment. It's in a rapidly developing area, and I'm confident it will appreciate in value. The view is amazing!</p>
        </div>
        <div class="box">
            <div class="user">
                <img src="images/pic-4.png" alt="">
                <div>
                    <h3>Shanaya</h3>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                </div>
            </div>
            <p>I'm so disappointed with this rental. It was dirty when I moved in, and the appliances are old and outdated. I can't wait to move out.</p>
        </div>
        <div class="box">
            <div class="user">
                <img src="images/pic-5.png" alt="">
                <div>
                    <h3>M.Ahmad</h3>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                </div>
            </div>
            <p>The property is exactly as advertised. The agent was very helpful and responsive, and the closing process was smooth and easy.</p>
        </div>
        <div class="box">
            <div class="user">
                <img src="images/pic-6.png" alt="">
                <div>
                    <h3>Zohra Baig</h3>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                </div>
            </div>
            <p><br>This is a fantastic family home. It's spacious, has a big backyard, and is close to good schools. We couldn't be happier!!</p>
        </div>
    </div>
</section>

<!-- review section ends -->

<!-- footer section starts -->
<?php include 'footer.php' ?>

<!-- footer section ends -->

<!-- custom js file link -->
<script src="js/script.js"></script>

</body>
</html>
