<?php
session_start();

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['Submit'])) {
    
    // Get user input from the form
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['pass']);
    $confirm_password = trim($_POST['c_pass']);

    // Initialize variables to hold messages
    $success_message = "";
    $error_message = "";

    // Step 1: Perform form validation
    if (empty($name) || empty($email) || empty($password) || empty($confirm_password)) {
        $error_message = "All fields are required.";
    } elseif ($password !== $confirm_password) {
        $error_message = "Passwords do not match. Please try again.";
    } elseif (strlen($password) < 8) {
        $error_message = "Password must be at least 8 characters long.";
    } elseif (!preg_match("/[0-9]/", $password)) {
        $error_message = "Password must contain at least one number.";
    } elseif (!preg_match("/[A-Z]/", $password)) {
        $error_message = "Password must contain at least one uppercase letter.";
    } elseif (!preg_match("/[a-z]/", $password)) {
        $error_message = "Password must contain at least one lowercase letter.";
    } else {
        // Step 2: Database operations
        $servername = "localhost";
        $username = "root"; 
        $dbpassword = ""; 
        $dbname = "elitestate";

        $conn = new mysqli($servername, $username, $dbpassword, $dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        
        $name = $conn->real_escape_string($name);
        $email = $conn->real_escape_string($email);
        
        // Check if email already exists
        $stmt_check = $conn->prepare("SELECT email FROM users WHERE email = ?");
        $stmt_check->bind_param("s", $email);
        $stmt_check->execute();
        $stmt_check->store_result();
        
        if ($stmt_check->num_rows > 0) {
            $error_message = "This email is already registered. Please use a different email or log in.";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert new user
            $stmt_insert = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
            $stmt_insert->bind_param("sss", $name, $email, $hashed_password);

            if ($stmt_insert->execute()) {
                // ✅ Auto login
                $_SESSION['user_id'] = $stmt_insert->insert_id;
                $_SESSION['user_name'] = $name;

                // ✅ Redirect back if redirect link given
                $redirect = isset($_GET['redirect']) ? $_GET['redirect'] : 'index.php';
                header("Location: " . $redirect);
                exit();
            } else {
                $error_message = "Error: " . $stmt_insert->error;
            }
            $stmt_insert->close();
        }
        
        $stmt_check->close();
        $conn->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Elite Estate</title>
    <link rel="stylesheet" href="css/furnish 1.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        .password-container { position: relative; }
        .password-container .fa-eye {
            position: absolute; top: 50%; right: 15px;
            transform: translateY(-50%); cursor: pointer; color: #666;
        }
        .success-msg { color: green; text-align: center; margin: 10px 0; }
        .error-msg { color: red; text-align: center; margin: 10px 0; }
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
                                <li><a href="view property/post property.html">Post property</a></li>
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
                                <li><a href="about1.html">About Us</a></li>
                                <li><a href="contact.html">Contact Us</a></li>
                                <li><a href="contact.html#faq">FAQ</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <ul>
                    <li><a href="saved.html">Saved <i class="far fa-heart"></i></a></li>
                    <li><a href="#">Account <i class="fas fa-angle-down"></i></a>
                        <ul>
                            <li><a href="login.php">Login</a></li>
                            <li><a href="register.php">Register</a></li>
                        </ul>
                    </li>
                </ul>
            </section>
        </nav>
    </header>

    <section class="form-container">
        <?php if (!empty($success_message)): ?>
            <p class="success-msg"><?= htmlspecialchars($success_message) ?></p>
        <?php endif; ?>
        <?php if (!empty($error_message)): ?>
            <p class="error-msg"><?= htmlspecialchars($error_message) ?></p>
        <?php endif; ?>

        <form action="" method="post">
            <h3>Create an account!</h3>
            <input type="text" name="name" required maxlength="50" placeholder="Enter your name" class="box" value="<?= isset($_POST['name']) ? htmlspecialchars($_POST['name']) : '' ?>">
            <input type="email" name="email" required maxlength="50" placeholder="Enter your email" class="box" value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>">
            
            <div class="password-container">
                <input type="password" name="pass" id="pass" required maxlength="20" placeholder="Enter your password" class="box">
                <i class="fas fa-eye" id="togglePassword"></i>
            </div>
            
            <div class="password-container">
                <input type="password" name="c_pass" id="c_pass" required maxlength="20" placeholder="Confirm your password" class="box">
                <i class="fas fa-eye" id="toggleConfirmPassword"></i>
            </div>

            <p>Already have an account? <a href="login.php">Login now</a></p>
            <input type="submit" value="register now" name="Submit" class="btn">
        </form>
    </section>

    <footer class="footer">
        <section class="flex">
            <div class="box">
                <a href="tel:1234567890"><i class="fas fa-phone"></i><span>123456789</span></a>
                <a href="tel:1112223333"><i class="fas fa-phone"></i><span>1112223333</span></a>
                <a href="mailto:hajrahamad@gmail.com"><i class="fas fa-envelope"></i><span>hajrahamad@gmail.com</span></a>
                <a href="#"><i class="fas fa-map-marker-alt"></i><span>Pakistan, Mandi bhauddin - 50400</span></a>
            </div>
            <div class="box">
                <a href="home.php"><span>Home</span></a>
                <a href="about1.html"><span>About</span></a>
                <a href="contact.html"><span>Contact</span></a>
                <a href="list2.html"><span>All listings</span></a>
                <a href="saved.html"><span>Saved properties</span></a>
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const togglePassword = document.getElementById('togglePassword');
            const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
            const password = document.getElementById('pass');
            const confirmPassword = document.getElementById('c_pass');

            function toggleVisibility(input, icon) {
                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                } else {
                    input.type = 'password';
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
            }

            if (togglePassword) {
                togglePassword.addEventListener('click', function() {
                    toggleVisibility(password, this);
                });
            }

            if (toggleConfirmPassword) {
                toggleConfirmPassword.addEventListener('click', function() {
                    toggleVisibility(confirmPassword, this);
                });
            }
        });
    </script>
</body>
</html>
