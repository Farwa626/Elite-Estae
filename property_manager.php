<?php
include 'db.php'; // DB connection

// --------- DEFAULT ---------
$editData = []; // prevent undefined variable warning

// --------- DELETE PROPERTY ---------
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    mysqli_query($conn, "DELETE FROM properties WHERE id=$id");
    echo "<p style='color:red'>❌ Property deleted!</p>";
}

// --------- ADD / UPDATE PROPERTY ---------
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;

    $ownerName = $_POST['ownerName'] ?? '';
    $title = $_POST['title'] ?? '';
    $price = $_POST['price'] ?? '';
    $location = $_POST['location'] ?? '';
    $rooms = $_POST['rooms'] ?? '';
    $baths = $_POST['baths'] ?? '';
    $size = $_POST['size'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $status = $_POST['status'] ?? '';
    $date_posted = $_POST['date_posted'] ?? '';
    $deposit = $_POST['deposit'] ?? '';
    $bedroom     = $_POST['bedroom'] ?? '';
    $bathroom    = $_POST['bathroom'] ?? '';
    $balcony     = $_POST['balcony'] ?? '';
    $carpet_area = $_POST['carpet_area'] ?? '';
    $age         = $_POST['age'] ?? '';
    $room_floor  = $_POST['room_floor'] ?? '';
    $total_floors= $_POST['total_floors'] ?? '';
    $furnished   = $_POST['furnished'] ?? '';
    $loan        = $_POST['loan'] ?? '';
    $amenities = $_POST['amenities'] ?? '';
    $description = $_POST['description'] ?? '';

    $uploadDir = "uploads/";

    // Avatar Upload
    $avatarPath = !empty($_FILES['avatar']['name']) 
        ? $uploadDir . uniqid() . "_" . $_FILES['avatar']['name'] 
        : $_POST['old_avatar'] ?? "";
    if (!empty($_FILES['avatar']['name'])) {
        move_uploaded_file($_FILES['avatar']['tmp_name'], $avatarPath);
    }

    // Main Image Upload
    $mainImagePath = !empty($_FILES['main_image']['name']) 
        ? $uploadDir . uniqid() . "_" . $_FILES['main_image']['name'] 
        : $_POST['old_main_image'] ?? "";
    if (!empty($_FILES['main_image']['name'])) {
        move_uploaded_file($_FILES['main_image']['tmp_name'], $mainImagePath);
    }

    // Gallery Images Upload
    $galleryPaths = [];
    if (!empty($_FILES['gallery_images']['name'][0])) {
        foreach ($_FILES['gallery_images']['tmp_name'] as $key => $tmp_name) {
            $galleryName = $_FILES['gallery_images']['name'][$key];
            $galleryPath = $uploadDir . uniqid() . "_" . $galleryName;
            move_uploaded_file($tmp_name, $galleryPath);
            $galleryPaths[] = $galleryPath;
        }
    }
    $galleryImages = !empty($galleryPaths) ? implode(",", $galleryPaths) : ($_POST['old_gallery'] ?? "");

    if ($id > 0) {
        // Update
        $sql = "UPDATE properties SET 
            ownerName='$ownerName', avatar='$avatarPath', title='$title', price='$price', location='$location',
            rooms='$rooms', baths='$baths', size='$size', main_image='$mainImagePath', gallery_images='$galleryImages',
            phone='$phone', status='$status', date_posted='$date_posted', deposit='$deposit', bedroom='$bedroom', 
            bathroom='$bathroom', balcony='$balcony', carpet_area='$carpet_area', age='$age', room_floor='$room_floor',
            total_floors='$total_floors', furnished='$furnished', loan='$loan', amenities='$amenities', description='$description'
            WHERE id=$id";
        mysqli_query($conn, $sql);
        echo "<p style='color:blue'>✏️ Property updated successfully!</p>";
    } else {
        // Insert
        $stmt = $conn->prepare("INSERT INTO properties 
        (ownerName, title, price, location, rooms, baths, size, main_image, phone, status, date_posted, deposit, bedroom, bathroom, balcony, carpet_area, age, room_floor, total_floors, furnished, loan, amenities, description) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        $stmt->bind_param(
            "ssssiiisssssiiissssssss",
            $ownerName,
            $title,
            $price,
            $location,
            $rooms,
            $baths,
            $size,
            $mainImagePath,
            $phone,
            $status,
            $date_posted,
            $deposit,
            $bedroom,
            $bathroom,
            $balcony,
            $carpet_area,
            $age,
            $room_floor,
            $total_floors,
            $furnished,
            $loan,
            $amenities,
            $description
        );

        if ($stmt->execute()) {
            echo "<p style='color:green'>✅ Property added successfully!</p>";
        } else {
            echo "<p style='color:red'>❌ Error: " . $stmt->error . "</p>";
        }
    }
}

// --------- FETCH PROPERTIES ---------
$result = $conn->query("SELECT * FROM properties ORDER BY id DESC");

// --------- EDIT MODE ---------
if (isset($_GET['edit'])) {
    $id = intval($_GET['edit']);
    $editResult = $conn->query("SELECT * FROM properties WHERE id=$id");
    if ($editResult && $editResult->num_rows > 0) {
        $editData = $editResult->fetch_assoc();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">

   
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <link rel="stylesheet" href="css/style.css">
    <title>Property Manager</title>
    <style>
        body {
            font-family: Arial, sans-serif;
             background:#f4f6f9
            padding: 20px;
        }
        h2 {
            background:#6a1b9a;
            color: white;
            padding: 10px;
            border-radius: 8px;
        }
        form {
            background: #fff;
            padding: 20px;
            margin-bottom: 30px;
            border-radius: 10px;
            box-shadow: 0px 2px 6px rgba(0,0,0,0.1);
        }
        label { font-weight: bold; }
        input, textarea, select {
            width: 100%;
            padding: 8px;
            margin: 6px 0 15px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }
        button {
            background: #4CAF50;
            color: white;
            padding: 10px 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover { background: #45a049; }
        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            box-shadow: 0px 2px 6px rgba(0,0,0,0.1);
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
        }
        th {
            background: #4CAF50;
            color: white;
        }
        img.thumb { width: 60px; height: 60px; object-fit: cover; border-radius: 6px; }
        tr:nth-child(even) { background: #f9f9f9; }
        tr:hover { background: #f1f1f1; }
        .action-links a { margin-right: 10px; text-decoration: none; }
    </style>
</head>
<body>

<h2><?php echo !empty($editData) ? "✏️ Edit Property" : "🏡 Add Property"; ?></h2>

<form method="POST" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?php echo $editData['id'] ?? ''; ?>">
    <input type="hidden" name="old_avatar" value="<?php echo $editData['avatar'] ?? ''; ?>">
    <input type="hidden" name="old_main_image" value="<?php echo $editData['main_image'] ?? ''; ?>">
    <input type="hidden" name="old_gallery" value="<?php echo $editData['gallery_images'] ?? ''; ?>">

    <label>Owner Name:</label>
    <input type="text" name="ownerName" value="<?php echo $editData['ownerName'] ?? ''; ?>" required>
    
    <label>Avatar:</label>
    <input type="file" name="avatar">
    <?php if (!empty($editData['avatar'])) echo "<img src='{$editData['avatar']}' class='thumb'>"; ?>
    
    <label>Title:</label>
    <input type="text" name="title" value="<?php echo $editData['title'] ?? ''; ?>" required>
    
    <label>Price:</label>
    <input type="text" name="price" value="<?php echo $editData['price'] ?? ''; ?>" required>
    
    <label>Location:</label>
    <input type="text" name="location" value="<?php echo $editData['location'] ?? ''; ?>" required>
    
    <label>Rooms:</label>
    <input type="number" name="rooms" value="<?php echo $editData['rooms'] ?? ''; ?>" required>
    
    <label>Baths:</label>
    <input type="number" name="baths" value="<?php echo $editData['baths'] ?? ''; ?>" required>
    
    <label>Size:</label>
    <input type="text" name="size" value="<?php echo $editData['size'] ?? ''; ?>" required>
    
    <label>Main Image:</label>
    <input type="file" name="main_image">
    <?php if (!empty($editData['main_image'])) echo "<img src='{$editData['main_image']}' class='thumb'>"; ?>
    
    <label>Gallery Images:</label>
    <input type="file" name="gallery_images[]" multiple>
    <?php 
    if (!empty($editData['gallery_images'])) {
        foreach (explode(",", $editData['gallery_images']) as $g) {
            echo "<img src='$g' class='thumb'>";
        }
    }
    ?>

    <label>Phone:</label>
    <input type="text" name="phone" value="<?php echo $editData['phone'] ?? ''; ?>" required>
    
    <label>Status:</label>
    <select name="status">
        <option value="Sale" <?php if(($editData['status'] ?? '')=="Sale") echo "selected"; ?>>Sale</option>
        <option value="Rent" <?php if(($editData['status'] ?? '')=="Rent") echo "selected"; ?>>Rent</option>
    </select>
    <label>Bedroom:</label>
<input type="number" name="bedroom" value="<?php echo $editData['bedroom'] ?? ''; ?>">

<label>Bathroom:</label>
<input type="number" name="bathroom" value="<?php echo $editData['bathroom'] ?? ''; ?>">

<label>Balcony:</label>
<input type="number" name="balcony" value="<?php echo $editData['balcony'] ?? ''; ?>">

<label>Room Floor:</label>
<input type="number" name="room_floor" value="<?php echo $editData['room_floor'] ?? ''; ?>">

<label>Total Floors:</label>
<input type="number" name="total_floors" value="<?php echo $editData['total_floors'] ?? ''; ?>">

<label>Carpet Area:</label>
<input type="text" name="carpet_area" value="<?php echo $editData['carpet_area'] ?? ''; ?>">

<label>Age:</label>
<input type="text" name="age" value="<?php echo $editData['age'] ?? ''; ?>">

<label>Furnished:</label>
<select name="furnished">
    <option value="Yes" <?php if(($editData['furnished'] ?? '')=="Yes") echo "selected"; ?>>Yes</option>
    <option value="No" <?php if(($editData['furnished'] ?? '')=="No") echo "selected"; ?>>No</option>
</select>

<label>Loan Available:</label>
<select name="loan">
    <option value="Yes" <?php if(($editData['loan'] ?? '')=="Yes") echo "selected"; ?>>Yes</option>
    <option value="No" <?php if(($editData['loan'] ?? '')=="No") echo "selected"; ?>>No</option>
</select>


    <label>Date Posted:</label>
    <input type="date" name="date_posted" value="<?php echo $editData['date_posted'] ?? ''; ?>" required>
    
    <label>Deposit:</label>
    <input type="text" name="deposit" value="<?php echo $editData['deposit'] ?? ''; ?>">
    
    <label>Amenities:</label>
    <textarea name="amenities"><?php echo $editData['amenities'] ?? ''; ?></textarea>

    <label>Description:</label>
    <textarea name="description"><?php echo $editData['description'] ?? ''; ?></textarea>

    <button type="submit"><?php echo !empty($editData) ? "Update Property" : "Add Property"; ?></button>
    
</form>

<hr>

<h2>📋 All Properties</h2>
<table>
    <tr>
        <th>ID</th>
        <th>Avatar</th>
        <th>Title</th>
        <th>Price</th>
        <th>Location</th>
        <th>Main Image</th>
        <th>Status</th>
        <th>Action</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()) { ?>
    <tr>
        <td><?php echo $row['id']; ?></td>
        <td><img src="<?php echo $row['avatar']; ?>" class="thumb"></td>
        <td><?php echo $row['title']; ?></td>
        <td><?php echo $row['price']; ?></td>
        <td><?php echo $row['location']; ?></td>
        <td><img src="<?php echo $row['main_image']; ?>" class="thumb"></td>
        <td><?php echo $row['status']; ?></td>
        <td class="action-links">
            <a href="?edit=<?php echo $row['id']; ?>">✏️ Edit</a> | 
            <a href="?delete=<?php echo $row['id']; ?>" onclick="return confirm('Delete this property?')">🗑️ Delete</a>
        </td>
    </tr>
    <?php } ?>
</table>

</body>
</html>
