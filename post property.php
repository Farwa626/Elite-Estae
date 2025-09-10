<?php
// ====== Database Connection ======
$conn = new mysqli("localhost", "root", "", "elitestate");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ====== Handle Form Submit ======
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title       = $_POST['title'];
    $location    = $_POST['location'];
    $price       = $_POST['price'];
    $type        = $_POST['type'];
    $status      = $_POST['status'];
    $owner       = $_POST['owner'];
    $phone       = $_POST['phone'];
    $bedrooms    = $_POST['bedrooms'];
    $bathrooms   = $_POST['bathrooms'];
    $balcony     = $_POST['balcony'];
    $rooms       = $_POST['rooms'];
    $carpetArea  = $_POST['carpetArea'];
    $plotSize    = $_POST['plotSize'];
    $roomFloor   = $_POST['roomFloor'];
    $totalFloors = $_POST['totalFloors'];
    $age         = $_POST['age'];
    $loan        = $_POST['loan'];
    $deposit     = $_POST['deposit'];
    $readyStatus = $_POST['readyStatus'];
    $description = $_POST['description'];

    // Amenities
    $amenities = isset($_POST['amenities']) ? implode(", ", $_POST['amenities']) : "";

    // Upload Main Image
    $mainImage = "";
    if (!empty($_FILES['mainImage']['name'])) {
        $mainImage = "uploads/" . time() . "_" . basename($_FILES['mainImage']['name']);
        move_uploaded_file($_FILES['mainImage']['tmp_name'], $mainImage);
    }

    // Upload Gallery Images
    $gallery = [];
    if (!empty($_FILES['galleryImages']['name'][0])) {
        foreach ($_FILES['galleryImages']['name'] as $key => $name) {
            $filePath = "uploads/" . time() . "_" . $name;
            move_uploaded_file($_FILES['galleryImages']['tmp_name'][$key], $filePath);
            $gallery[] = $filePath;
        }
    }
    $galleryStr = implode(",", $gallery);

    // Insert Query
    $sql = "INSERT INTO property_requests 
    (title, location, price, type, status, owner, phone, bedrooms, bathrooms, balcony, rooms, carpetArea, plotSize, roomFloor, totalFloors, age, loan, deposit, readyStatus, mainImage, gallery, amenities, description) 
    VALUES 
    ('$title', '$location', '$price', '$type', '$status', '$owner', '$phone', '$bedrooms', '$bathrooms', '$balcony', '$rooms', '$carpetArea', '$plotSize', '$roomFloor', '$totalFloors', '$age', '$loan', '$deposit', '$readyStatus', '$mainImage', '$galleryStr', '$amenities', '$description')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('✅ Property request submitted! Admin approval required.'); window.location='post_property.php';</script>";
        exit;
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Post Property</title>
   
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   
   <link rel="stylesheet" href="css/style.css">
  <style>

    form {background:#fff; padding:20px; border-radius:10px; box-shadow:0 2px 10px rgba(0,0,0,0.1); max-width:700px; width:100%; display:flex; flex-direction:column; gap:12px; width: 360px;margin: 50px auto;  transform: translateX(-50px);}
    h2 {text-align:center; color:#713b68;}
    input, textarea, select {padding:10px; border:1px solid #ccc; border-radius:6px; font-size:14px; width:100%;}
    textarea {resize:vertical; min-height:80px;}
    .row {display:flex; gap:10px;}
    .row > div {flex:1;}
    button {background:#713b68; color:white; border:none; padding:12px; border-radius:6px; font-size:16px; cursor:pointer;}
    button:hover {background:#5d3056;}
    label {font-weight: bold; margin-top: 5px;}
  </style>
</head>
<body>
  <?php include 'header.php' ?>

<form method="POST" enctype="multipart/form-data">
  <h2>Post Your Property</h2>

  <input type="text" name="title" placeholder="Title (e.g. 5 Marla House)" required>
  <input type="text" name="location" placeholder="Location" required>
  <input type="number" name="price" placeholder="Price (e.g. 5000000)" required>
  <select name="type" required>
    <option value="">Select Type</option>
    <option value="House">House</option>
    <option value="Flat">Flat</option>
  </select>
  <input type="text" name="status" placeholder="Status (For Sale / For Rent)">
  
  <div class="row">
    <div><input type="text" name="owner" placeholder="Owner Name"></div>
    <div><input type="text" name="phone" placeholder="Contact Number"></div>
  </div>

  <!-- Property Details -->
  <div class="row">
    <div><input type="number" name="bedrooms" placeholder="Bedrooms"></div>
    <div><input type="number" name="bathrooms" placeholder="Bathrooms"></div>
  </div>
  <div class="row">
    <div><input type="number" name="balcony" placeholder="Balconies"></div>
    <div><input type="number" name="rooms" placeholder="Other Rooms"></div>
  </div>
  <div class="row">
    <div><input type="text" name="carpetArea" placeholder="Carpet Area (sqft)"></div>
    <div><input type="text" name="plotSize" placeholder="Plot Size (Marla/Kanal)"></div>
  </div>
  <div class="row">
    <div><input type="number" name="roomFloor" placeholder="Floor No."></div>
    <div><input type="number" name="totalFloors" placeholder="Total Floors"></div>
  </div>
  <div class="row">
    <div><input type="text" name="age" placeholder="Property Age (years)"></div>
    <div><input type="text" name="loan" placeholder="Loan (Yes/No)"></div>
  </div>
  <input type="number" name="deposit" placeholder="Deposit Amount">
  <input type="text" name="readyStatus" placeholder="Ready Status (Ready/Under Construction)">

  <!-- Images -->
  <label>Main Image</label>
  <input type="file" name="mainImage" required>
  
  <label>Gallery Images</label>
  <input type="file" name="galleryImages[]" multiple>

  <!-- Amenities -->
  <label>Amenities</label>
  <label><input type="checkbox" name="amenities[]" value="Electricity"> Electricity</label>
  <label><input type="checkbox" name="amenities[]" value="Water"> Water</label>
  <label><input type="checkbox" name="amenities[]" value="Gas"> Gas</label>
  <label><input type="checkbox" name="amenities[]" value="Parking"> Parking</label>
  <label><input type="checkbox" name="amenities[]" value="Lift"> Lift</label>
  <label><input type="checkbox" name="amenities[]" value="Security"> Security</label>

  <textarea name="description" placeholder="Property Description"></textarea>

  <button type="submit">Send Request</button>
</form>
<?php include 'footer.php' ?>
</body>
</html>
