<?php
$conn = new mysqli("localhost", "root", "", "elitestate");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$question = '';
$error = '';
$success = '';

// Form submit handling
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $answer = trim($_POST['answer'] ?? '');

    if ($username) {
        $stmt = $conn->prepare("SELECT * FROM admins WHERE username=?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            $question = $row['recovery_question'];

            // Only check answer if user submitted it
            if ($answer !== '') {
                // Plaintext comparison
                if ($answer === $row['recovery_answer']) {
                    $newpass = "admin123"; // new password in plaintext
                    $update = $conn->prepare("UPDATE admins SET password=? WHERE username=?");
                    $update->bind_param("ss", $newpass, $username);
                    $update->execute();
                    $success = "✅ Password reset to 'admin123'. Please login again!";
                } else {
                    $error = "❌ Wrong recovery answer!";
                }
            }
        } else {
            $error = "❌ No admin found!";
        }
    } else {
        $error = "❌ Please enter your username!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Password Recovery</title>
</head>
<body>
<h2>🔑 Password Recovery</h2>

<form method="POST" autocomplete="off">
    <input type="text" name="username" placeholder="Enter Username" required
           value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>"><br><br>

    <?php if ($question): ?>
        <p>Question: <?php echo htmlspecialchars($question); ?></p>
        <input type="text" name="answer" placeholder="Your Answer" required><br><br>
    <?php endif; ?>

    <button type="submit" name="recover">Recover</button>
</form>

<?php if ($error) echo "<p style='color:red;'>$error</p>"; ?>
<?php if ($success) echo "<p style='color:green;'>$success</p>"; ?>

</body>
</html>
