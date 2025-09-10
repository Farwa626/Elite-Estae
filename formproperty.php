<?php
include "db.php"; // database connection

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name      = $_POST['owner_name'];
    $email     = $_POST['email'];
    $title     = $_POST['title'];
    $type      = $_POST['type'];
    $status    = $_POST['status'];
    $location  = $_POST['location'];
    $bedrooms  = $_POST['bedrooms'];
    $bathrooms = $_POST['bathrooms'];
    $area      = $_POST['area'];

    // image upload
    $image = $_FILES['image']['name'];
    $target = "uploads/" . basename($image);
    move_uploaded_file($_FILES['image']['tmp_name'], $target);

    // insert into "request" table instead of "properties"
    $sql = "INSERT INTO request 
        (owner_name, email, title, type, status, location, bedrooms, bathrooms, area, image, approval_status) 
        VALUES 
        ('$name', '$email', '$title', '$type', '$status', '$location', '$bedrooms', '$bathrooms', '$area', '$image', 'pending')";

    if (mysqli_query($conn, $sql)) {
        $message = "✅ Your property request has been submitted successfully! Please wait for admin approval.";
    } else {
        $message = "❌ Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Submit Property Request</title>
  <style>
    body { font-family: Arial, sans-serif; background:#f9f9f9; padding:20px; }
    .form-box { background:white; padding:20px; max-width:600px; margin:auto; border-radius:10px; box-shadow:0 4px 10px rgba(0,0,0,0.1); }
    label { display:block; margin-top:10px; font-weight:bold; }
    input, select { width:100%; padding:8px; margin-top:5px; border:1px solid #ccc; border-radius:5px; }
    button { margin-top:15px; padding:10px 20px; background:#6b21a8; color:white; border:none; border-radius:5px; cursor:pointer; }
    button:hover { background:#4c1d95; }
    .msg { margin:10px 0; font-weight:bold; color:green; }
  </style>
</head>
<body>

<div class="form-box">
  <h2>Submit Your Property Request</h2>

  <?php if ($message != "") { ?>
      <p class="msg"><?php echo $message; ?></p>
  <?php } ?>

  <form method="POST" enctype="multipart/form-data">
    <label>Owner Name</label>
    <input type="text" name="owner_name" required>

    <label>Email</label>
    <input type="email" name="email" required>

    <label>Title</label>
    <input type="text" name="title" placeholder="Modern 5 Marla" required>

    <label>Property Type</label>
    <select name="type">
      <option value="House">House</option>
      <option value="Plot">Plot</option>
      <option value="Shop">Shop</option>
    </select>

    <label>Status</label>
    <select name="status">
      <option value="Sale">Sale</option>
      <option value="Rent">Rent</option>
    </select>

    <label>Location</label>
    <input type="text" name="location" placeholder="Tehsil, City, Country" required>

    <label>Bedrooms</label>
    <input type="number" name="bedrooms" min="0">

    <label>Bathrooms</label>
    <input type="number" name="bathrooms" min="0">

    <label>Area (sqft)</label>
    <input type="number" name="area" required>

    <label>Property Image</label>
    <input type="file" name="image" accept="image/*" required>

    <button type="submit">Submit Property</button>
  </form>
</div>

</body>
</html>
