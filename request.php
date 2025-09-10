<?php
include "db.php";

// Form submit hone ke baad backend code chalega
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $owner = $_POST['owner_name'];
    $email = $_POST['email'];
    $title = $_POST['title'];
    $type = $_POST['type'];
    $status = $_POST['status'];
    $location = $_POST['location'];

    // Image upload
    $imageName = $_FILES['image']['name'];
    $tmp = $_FILES['image']['tmp_name'];
    $folder = "uploads/" . basename($imageName);
    move_uploaded_file($tmp, $folder);

    // Insert request (default approval_status = pending)
    $sql = "INSERT INTO request (owner_name, email, title, type, status, location, image, approval_status) 
            VALUES ('$owner', '$email', '$title', '$type', '$status', '$location', '$imageName', 'pending')";

    if (mysqli_query($conn, $sql)) {
        $msg = "✅ Request submitted successfully. Admin will review it.";
    } else {
        $msg = "❌ Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Submit Property Request</title>
  <style>
    body { font-family: Arial, sans-serif; background:#f4f4f4; padding:20px; }
    form { background:#fff; padding:20px; border-radius:10px; width:400px; margin:auto; box-shadow:0 0 10px rgba(0,0,0,0.1);}
    label { display:block; margin-top:10px; font-weight:bold; }
    input, select { width:100%; padding:8px; margin-top:5px; border:1px solid #ccc; border-radius:5px; }
    button { margin-top:15px; padding:10px; background:#6b21a8; color:white; border:none; border-radius:5px; cursor:pointer; }
    button:hover { background:#4c1580; }
    .msg { text-align:center; margin-bottom:15px; font-weight:bold; }
  </style>
</head>
<body>

<h2 style="text-align:center;">Submit Property Request</h2>

<?php if (isset($msg)) { echo "<p class='msg'>$msg</p>"; } ?>

<form action="" method="POST" enctype="multipart/form-data">
  <label>Owner Name</label>
  <input type="text" name="owner_name" required>

  <label>Email</label>
  <input type="email" name="email" required>

  <label>Property Title</label>
  <input type="text" name="title" required>

  <label>Property Type</label>
  <select name="type" required>
    <option value="House">House</option>
    <option value="Flat">Flat</option>
    <option value="Plot">Plot</option>
  </select>

  <label>Status</label>
  <select name="status" required>
    <option value="Sale">Sale</option>
    <option value="Rent">Rent</option>
  </select>

  <label>Location</label>
  <input type="text" name="location" required>

  <label>Upload Image</label>
  <input type="file" name="image" required>

  <button type="submit">Submit Request</button>
</form>

</body>
</html>
