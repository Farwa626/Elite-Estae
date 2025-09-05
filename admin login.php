<?php
session_start();
$conn = new mysqli("localhost","root","","elitestate");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

// Check if admins table is empty
$result = $conn->query("SELECT COUNT(*) as count FROM admins");
$row = $result->fetch_assoc();
if($row['count'] == 0){
    // Create default admin with plaintext password
    $defaultUsername = "Admin";
    $defaultPassword = "Admin321";  // plaintext
    $recovery_question = "What is your favorite color?";
    $recovery_answer = "blue"; // plaintext

    $stmt = $conn->prepare("INSERT INTO admins (username, password, recovery_question, recovery_answer) VALUES (?,?,?,?)");
    $stmt->bind_param("ssss", $defaultUsername, $defaultPassword, $recovery_question, $recovery_answer);
    $stmt->execute();
}

if ($_SERVER["REQUEST_METHOD"]=="POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $stmt = $conn->prepare("SELECT * FROM admins WHERE username=?");
    $stmt->bind_param("s",$username);
    $stmt->execute();
    $result = $stmt->get_result();

    if($row = $result->fetch_assoc()){
        // Plaintext password check
        if($password === $row['password']){
            // Set session variables
            $_SESSION['admin'] = $row['username'];
            $_SESSION['admin_logged_in'] = true;

            // Alert and redirect
            echo "<script>
                    alert('✅ Login successful!');
                    window.location.href='add dumy.php';
                  </script>";
            exit();
        } else {
            $error = "❌ Wrong password!";
        }
    } else {
        $error = "❌ No admin found!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Admin Login</title>
<style>
body{font-family:Arial;background:#f4f6f9;display:flex;justify-content:center;align-items:center;height:100vh;}
.login-box{background:#fff;padding:20px;border-radius:8px;box-shadow:0 2px 6px rgba(0,0,0,0.2);width:300px;}
input{width:100%;padding:10px;margin-top:10px;border:1px solid #ccc;border-radius:5px;}
button{margin-top:15px;padding:10px;background:#6a1b9a;color:white;border:none;border-radius:5px;width:100%;}
.error{color:red;margin-top:10px;}
</style>
</head>
<body>
<div class="login-box">
<h2>Admin Login</h2>
<form method="POST" autocomplete="off">
  <input type="text" name="username" placeholder="Username" required autocomplete="off">
  <input type="password" name="password" placeholder="Password" required autocomplete="new-password">
  <button type="submit">Login</button>
</form>
<?php if(isset($error)) echo "<p class='error'>$error</p>"; ?>
<p><a href="recover admin.php">Forgot Password?</a></p>
</div>
</body>
</html>
