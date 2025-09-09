<?php
session_start();
include 'db.php'; // database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['user_email']); // updated field name
    $password = trim($_POST['user_pass']); // updated field name

    // Prepare query (SQL Injection safe)
    $stmt = $conn->prepare("SELECT id, name, password FROM register WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        // Save user data in session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];

        // Redirect back to original page
        $redirect = isset($_GET['redirect']) ? $_GET['redirect'] : 'home.php';
        header("Location: " . $redirect);
        exit();
    } else {
        $error = "Invalid email or password!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; }
        .login-box {
            width: 350px; margin: 80px auto; padding: 20px;
            background: white; border-radius: 10px; box-shadow: 0 0 10px #aaa;
        }
        h2 { text-align: center; margin-bottom: 20px; }
        input[type="text"], input[type="password"] {
            width: 100%; padding: 10px; margin: 10px 0;
            border: 1px solid #ccc; border-radius: 5px;
        }
        button {
            width: 100%; padding: 10px; background: #28a745;
            color: white; border: none; border-radius: 5px; cursor: pointer;
        }
        button:hover { background: #218838; }
        .error { color: red; text-align: center; margin: 10px 0; }
        .link { text-align: center; margin-top: 15px; }
    </style>
</head>
<body>
    <div class="login-box">
        <h2>Login</h2>
        
        <?php if (isset($error)) { echo "<p class='error'>$error</p>"; } ?>

        <form action="login.php<?php if(isset($_GET['redirect'])) echo '?redirect=' . urlencode($_GET['redirect']); ?>" method="POST" autocomplete="off">
            
            <!-- Fake hidden fields to trick browser autofill -->
            <input type="text" style="display:none">
            <input type="password" style="display:none">

            <!-- Real fields with new names -->
            <input type="text" name="user_email" placeholder="Enter your email" required autocomplete="new-email">
            <input type="password" name="user_pass" placeholder="Enter your password" required autocomplete="new-password">
            
            <button type="submit">Login</button>
        </form>

        <div class="link">
            <p>Don't have an account? <a href="register.php">Register here</a></p>
        </div>
    </div>
</body>
</html>
