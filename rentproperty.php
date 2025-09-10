<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "elitestate";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("❌ Connection failed: " . $conn->connect_error);
}

$message = "";

// Handle form submission for booking
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the form has been submitted and all required fields are present
    if (
        isset(
            $_POST['property_title'],
            $_POST['full_name'],
            $_POST['email'],
            $_POST['phone'],
            $_POST['move_in_date']
        )
    ) {
        // Sanitize form inputs to prevent SQL injection
        $property_title = $conn->real_escape_string($_POST['property_title']);
        $full_name = $conn->real_escape_string($_POST['full_name']);
        $email = $conn->real_escape_string($_POST['email']);
        $phone = $conn->real_escape_string($_POST['phone']);
        $move_in_date = $conn->real_escape_string($_POST['move_in_date']);

        // Insert booking data into the database
        $sql = "INSERT INTO bookings (property_title, full_name, email, phone, move_in_date)
                VALUES ('$property_title', '$full_name', '$email', '$phone', '$move_in_date')";

        if ($conn->query($sql) === TRUE) {
            // Using a div with the message class
            $message = "<div class='message-container success-message'><p>✅ Your booking request has been submitted successfully! We will contact you soon.</p></div>";
        } else {
            $message = "<div class='message-container error-message'><p>❌ Error: " . $conn->error . "</p></div>";
        }
    } else {
        $message = "<div class='message-container error-message'><p>❌ Please fill out all required fields.</p></div>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book a Property</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="css/furnish 1.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        body { font-family: Arial, sans-serif; margin: 0; background: url('images/bg.png') no-repeat center center fixed; background-size: cover; }
        .form-container { max-width: 600px; margin: 30px auto; background-color: rgba(255, 255, 255, 0.44); padding: 30px; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); }
        .form-container h2 { text-align: center; color: #333; margin-bottom: 20px; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: bold; }
        .form-group input, .form-group textarea, .form-group select { width: 100%; padding: 10px; border: 1px solid #696565be; border-radius: 4px; box-sizing: border-box; }
        .submit-btn { width: 100%; padding: 12px; background-color: #007bff; color: #fff; border: none; border-radius: 4px; font-size: 16px; cursor: pointer; }
        .submit-btn:hover { background-color: #0056b3; }
        
        /* New styles for the message container */
        .message-container { 
            margin-top: 15px; 
            text-align: center;
            padding: 15px;
            border-radius: 8px;
            font-size: 1.2em; /* This is the key change for size */
            font-weight: bold;
        }

        .success-message {
            color: green;
            background-color: rgba(80, 22, 56, 0.2);
        }

        .error-message {
            color: red;
            background-color: rgba(231, 76, 60, 0.2);
        }

    </style>
</head>
<body>
    <header class="header">
        <nav class="navbar nav-1">
            <section class="flex">
                <a href="home.php" class="logo"><i class="fas fa-house"></i>Elite Estate</a>
                <ul>
                    <li><a href="view property/post property.html">Post Property<i class="fas fa-paper-plane"></i></a></li>
                </ul>
            </section>
        </nav>
        
        <nav class="navbar nav-2">
            <section class="flex">
                <div id="menu-btn" class="fas fa-bars"></div>
                <div class="menu">
                    <ul>
                        <li><a href="#">Buy<i class="fas fa-angle-down"></i></a>
                            <ul>
                                <li><a href="list2.html">House</a></li>
                                <li><a href="list3.html">Flat</a></li>
                                <li><a href="furnish1.html">Furnished</a></li>
                            </ul>
                        </li>
                        <li><a href="#">Sell<i class="fas fa-angle-down"></i></a>
                            <ul>
                                <li><a href="pview property/post property.html">Post property</a></li>
                                <li><a href="dash.html">Dashboard</a></li>
                            </ul>
                        </li>
                        <li><a href="#">Rent</a>
                            <ul>
                                <li><a href="house.html">House</a></li>
                                <li><a href="flats.html">Flat</a></li>
                            </ul>
                        </li>
                        <li><a href="#">Help<i class="fas fa-angle-down"></i></a>
                            <ul>
                                <li><a href="about1.html">About Us</a></i></li>
                                <li><a href="contact.html">Contact Us</a></i></li>
                                <li><a href="contact.html#faq">FAQ</a></i></li>
                            </ul>
                        </li>
                    </ul>
                </div>
                
                <ul>
                    <li><a href="saved.html">Saved <i class="far fa-heart"></i></a></li>
                    <li><a href="#">Account <i class="fas fa-angle-down"></i></a>
                        <ul>
                            <li><a href="login.php">Login</a></li>
                            <li><a href="register.html">Register</a></li>
                        </ul>
                    </li>
                </ul>
            </section>
        </nav>
    </header>

    <div class="form-container">
        <h2>Book This Property</h2>
        <?php echo $message; ?>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
            
            <div class="form-group">
                <label for="property_title">Property Title</label>
                <input type="text" id="property_title" name="property_title" required>
            </div>

            <h3>Your Information</h3>
            <div class="form-group">
                <label for="full_name">Full Name</label>
                <input type="text" id="full_name" name="full_name" required>
            </div>
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input type="tel" id="phone" name="phone" required>
            </div>
            <div class="form-group">
                <label for="move_in_date">Preferred Move-in Date</label>
                <input type="date" id="move_in_date" name="move_in_date" required>
            </div>
            
            <button type="submit" class="submit-btn">Submit Booking Request</button>
        </form>
    </div>

    <footer class="footer">
        <section class="flex">
            <div class="box">
                <a href="tel:1234567890"><i class="fas fa-phone"></i><span>123456789</span></a>
                <a href="tel:1112223333"><i class="fas fa-phone"></i><span>1112223333</span></a>
                <a href="mailto:shaikhanas@gmail.com"><i class="fas fa-envelope"></i><span>hajrahamad@gmail.com</span></a>
                <a href="#"><i class="fas fa-map-marker-alt"></i><span>Pakistan, Mandi bhauddin - 50400</span></a>
            </div>
            <div class="box">
                <a href="home.php" class="a"><span>Home</span></a>
                <a href="about1.html" class="b"><span>About</span></a>
                <a href="contact.html" class="c"><span>Contact</span></a>
                <a href="list2.html" class="d"><span>All listings</span></a>
                <a href="saved.html" class="e"><span>Saved properties</span></a>
            </div>
            <div class="box">
                <a href="https://www.facebook.com/profile.php?id=61577889561897"><i class="fab fa-facebook-f"></i><span>&nbsp;&nbsp;Facebook</span></a>
                <a href="https://twitter-cl.vercel.app/home"><i class="fab fa-twitter"></i><span>&nbsp;&nbsp;Twitter</span></a>
                <a href="https://www.linkedin.com/in/elite-estate-314823370/"><i class="fab fa-linkedin"></i><span>&nbsp;&nbsp;Linkedin</span></a>
                <a href="https://www.instagram.com/elite_state23/?hl=en"><i class="fab fa-instagram"></i><span>&nbsp;&nbsp;Instagram</span></a>
            </div>
        </section>
        <div class="credit">&copy; copyright @ 2024-2025 by <span>ELITE ESTATE</span> | all rights reserved!</div>
    </footer>

    <script src="js/script.js"></script>

</body>
</html>
<?php $conn->close(); ?>