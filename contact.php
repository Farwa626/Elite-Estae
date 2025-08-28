<?php
// Load PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if(isset($_POST['send'])){
    // Database connection
    $conn = new mysqli("localhost","root","","elitestate");
    if($conn->connect_error){
      die("Connection Failed: " . $conn->connect_error);
    }

    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $message = $conn->real_escape_string($_POST['message']);

    // Insert into contact table
    $sql = "INSERT INTO contact (name, email, message) VALUES ('$name','$email','$message')";
    if($conn->query($sql) === TRUE){

        // ✅ PHPMailer include
        require 'PHPMailer/Exception.php';
        require 'PHPMailer/PHPMailer.php';
        require 'PHPMailer/SMTP.php';

        $mail = new PHPMailer(true);

        try {
            // SMTP settings
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'eliteestate130@gmail.com';   // ✅ apna Gmail
            $mail->Password   = 'mghe ovhv kxgt emro';     // ✅ Gmail App Password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            // Sender & Receiver
            $mail->setFrom('eliteestate130@gmail.com', 'Elite Estate');
            $mail->addAddress($email, $name); // User ko confirmation
            $mail->addAddress('eliteestate130@gmail.com', 'Admin'); // ✅ Admin ko bhi mail

            // Content
            $mail->isHTML(true);
            $mail->Subject = "Thank you for contacting Elite Estate";
            $mail->Body    = "
                <h3>Hello $name,</h3>
                <p>We have received your message:</p>
                <blockquote>$message</blockquote>
                <p>Our team will contact you soon.</p>
                <br>
                <b>- Elite Estate Team</b>
            ";

            $mail->send();

            echo "<script>alert('Your message has been sent successfully!');</script>";

        } catch (Exception $e) {
            echo "<script>alert('Message could not be sent. Mailer Error: {$mail->ErrorInfo}');</script>";
        }
    } else {
      echo "<script>alert('Error: " . $conn->error . "');</script>";
    }
    $conn->close();
}

// Re-establish connection for the FAQ section
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "elitestate";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        /* Styles for the FAQ section */
        .faq {
            padding: 2rem 5%;
            background: #f7f7f7;
        }
        .faq .box-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(30rem, 1fr));
            gap: 2rem;
            justify-content: center;
        }
        .faq .box {
            background-color: #fff;
            padding: 2rem;
            border: 1px solid #ddd;
            border-radius: 0.5rem;
            box-shadow: 0 0.4rem 0.8rem rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            cursor: pointer;
        }
        .faq .box:hover {
            transform: translateY(-1rem);
            box-shadow: 0 0.6rem 1.2rem rgba(0, 0, 0, 0.2);
        }
        .faq .box.active h3 {
            color: #6e196aff;
        }
        .faq .box.active p {
            display: block;
        }
        .faq .box p {
            line-height: 2;
            font-size: 1.6rem;
            color: #666;
            display: none;
        }
        .heading {
            text-align: center;
            font-size: 3.5rem;
            color: #333;
            margin-bottom: 3rem;
            text-transform: capitalize;
        }
    </style>
</head>
<body>

<header class="header">
    <nav class="navbar nav-1">
        <section class="flex">
           <a href="home.php" class="logo"><i class="fas fa-house"></i><b></b>ELITE ESTATE</a>
           <ul>
             <li><a href="view property/post property.html">post property<i class="fas fa-paper-plane"></i></a></li>
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
                       <li><a href="list2.php">House</a></li>
                       <li><a href="list3.php">Flat</a></li>
                       <li><a href="furnish1.php">Furnished</a></li>
                    </ul>
                 </li>
                 <li><a href="#">Sell<i class="fas fa-angle-down"></i></a>
                    <ul>
                       <li><a href="view property/post property.html">Post Property</a></li>
                       <li><a href="dash.html">Dashboard</a></li>
                    </ul>
                 </li>
                 <li><a href="#">Rent</a>
                    <ul>
                       <li><a href="house.html">House</a></li>
                       <li><a href="flats.html">Flat</a></li>
                    </ul>
                 </li>
                 <li><a href="#">help<i class="fas fa-angle-down"></i></a>
                    <ul>
                       <li><a href="about1.html">About us</a></li>
                       <li><a href="contact.html">Contact us</a></li>
                       <li><a href="contact.html#faq">FAQ</a></li>
                    </ul>
                 </li>
              </ul>
           </div>

           <ul>
              <li><a href="saved.html">Saved <i class="far fa-heart"></i></a></li>
              <li><a href="#">Account <i class="fas fa-angle-down"></i></a>
                 <ul>
                    <li><a href="login.html">Login</a></li>
                    <li><a href="register.html">Register</a></li>
                 </ul>
              </li>
           </ul>
        </section>
    </nav>
</header>

<section class="contact">
    <div class="row">
        <div class="image">
            <img src="images/contact-img.svg" alt="">
        </div>
        <form action="" method="post">
            <h3 style="color:#fcfbfb;">Get in Touch</h3>
            <input type="text" name="name" required maxlength="50" placeholder="Enter your name" class="box">
            <input type="email" name="email" required maxlength="50" placeholder="Enter your email" class="box">
            <textarea name="message" placeholder="Enter your message" required maxlength="1000" cols="30" rows="10" class="box"></textarea>
            <input type="submit" value="send message" name="send" class="btn">
        </form>
    </div>
</section>

<!-- Static FAQ -->
<section class="faq" id="static-faq">
    <h1 class="heading">General Frequently Asked Questions</h1>
    <div class="box-container">
        <div class="box active">
            <h3><span>Can I visit property before booking?</span><i class="fas fa-angle-down"></i></h3>
            <p>Yes, schedule a viewing with our agent to explore the property.</p>
        </div>
        <div class="box active">
            <h3><span>What documents are needed for booking?</span><i class="fas fa-angle-down"></i></h3>
            <p>Typically, you'll need ID proof and other relevant documents. Our team will provide a detailed list.</p>
        </div>
        <div class="box">
            <h3><span>How long does it takes to complete the registration process?</span><i class="fas fa-angle-down"></i></h3>
            <p>Registration usually takes a few days to a week.</p>
        </div>
        <div class="box">
            <h3><span>What are the property's Amenities?</span><i class="fas fa-angle-down"></i></h3>
            <p>Our property features swimming pool, gym, parking, security etc.</p>
        </div>
    </div>
</section>

<!-- Dynamic FAQ -->
<section class="faq" id="dynamic-faq">
    <h1 class="heading">Questions from our Clients</h1>
    <div class="box-container">
        <?php
        $sql = "SELECT name, message FROM contact ORDER BY created_at DESC LIMIT 10";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo '<div class="box">';
                echo '<h3><i class="fas fa-user-circle"></i> ' . htmlspecialchars($row["name"]) . ' asked:</h3>';
                echo '<p>' . nl2br(htmlspecialchars($row["message"])) . '</p>';
                echo '</div>';
            }
        } else {
            echo '<p style="text-align: center; color: #999; font-size: 1.6rem;">No questions found yet.</p>';
        }
        $conn->close();
        ?>
    </div>
</section>

<footer class="footer">
    <section class="flex">
        <div class="box">
            <a href="tel:1234567890"><i class="fas fa-phone"></i><span>123456789</span></a>
            <a href="tel:1112223333"><i class="fas fa-phone"></i><span>1112223333</span></a>
            <a href="mailto:hajrahamad@gmail.com"><i class="fas fa-envelope"></i><span>hajrahamad@gmail.com</span></a>
            <a href="#"><i class="fas fa-map-marker-alt"></i><span>Pakistan, Mandi bhauddin - 50400</span></a>
        </div>
    </section>
</footer>

<script src="js/script.js"></script>
</body>
</html>
