<?php
$status_message = '';
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "elitestate";
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }

    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $experience = intval($_POST['experience']);
    $cnic = $conn->real_escape_string($_POST['cnic']);

    // Insert into agent_requests
    $stmt = $conn->prepare("INSERT INTO agent_requests (name, email, phone, experience, cnic) VALUES (?,?,?,?,?)");
    $stmt->bind_param("sssds", $name, $email, $phone, $experience, $cnic);
    if($stmt->execute()){
        $status_message = "✅ Your agent request has been submitted and is pending admin approval.";
    } else {
        $status_message = "❌ Error submitting request. Please try again.";
    }

    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Agent Request Form</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
<style>
  body { font-family: Arial, sans-serif;  background:#f4f4f4; }
  form { max-width:400px; margin:auto; background:white; padding:20px; border-radius:8px; box-shadow:0 2px 6px rgba(0,0,0,0.1); }
  label { display:block; margin-top:10px; font-weight:bold; }
  input { width:100%; padding:8px; margin-top:5px; border:1px solid #ccc; border-radius:5px; }
  button { margin-top:15px; padding:10px; background:#6a1b9a; border:none; color:white; border-radius:5px; cursor:pointer; width:100%; }
  button:hover { background:#4a148c; }
  .status-message { text-align:center; margin-bottom:15px; font-weight:bold; }
  .status-message.success { color:green; }
  .status-message.error { color:red; }
</style>
</head>
<body>
<?php include 'header.php' ?>
<h2 style="text-align:center;">Agent Request Form</h2>

<?php if($status_message): ?>
  <div class="status-message <?php echo strpos($status_message,'✅') !== false ? 'success':'error'; ?>">
    <?php echo $status_message; ?>
  </div>
<?php endif; ?>

<form method="POST" action="">
  <label for="name">Full Name *</label>
  <input type="text" name="name" id="name" required>

  <label for="cnic">CNIC (xxxxx-xxxxxxx-x) *</label>
  <input type="text" name="cnic" id="cnic" pattern="\d{5}-\d{7}-\d" required>

  <label for="email">Email *</label>
  <input type="email" name="email" id="email" required>

  <label for="phone">Phone</label>
  <input type="text" name="phone" id="phone">

  <label for="experience">Experience (years) *</label>
  <input type="number" name="experience" id="experience" min="0" required>

  <button type="submit">Submit Request</button>
</form>

</body>

<?php include 'footer.php' ?>
</html>
