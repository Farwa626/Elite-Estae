<?php
include 'db.php'; 

function redirect_and_exit($message, $conn) {
    echo "<script>alert('" . htmlspecialchars($message) . "'); window.location.href = '" . basename($_SERVER['PHP_SELF']) . "';</script>";
    $conn->close();
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // initialize
    $target_file = null;
    $gallery_images = null;

    // --- Add Property ---
    if (isset($_POST['add_property'])) {
        $title        = $_POST['title'] ?? null;
        $house_number = $_POST['house_number'] ?? null;
        $price        = $_POST['price'] ?? null;
        $availability = $_POST['availability'] ?? null;
        $description  = $_POST['description'] ?? null;
        $location     = $_POST['location'] ?? null;
        $bedrooms     = $_POST['bedrooms'] ?? null;
        $bathrooms    = $_POST['bathrooms'] ?? null;
        $size         = $_POST['size'] ?? null;
        $is_furnished = $_POST['is_furnished'] ?? null;
        $parking      = $_POST['parking'] ?? null;
        $amenities    = $_POST['amenities'] ?? null;
        $security     = $_POST['security'] ?? null;
        $agent_name   = $_POST['agent_name'] ?? null;
        $agent_phone  = $_POST['agent_phone'] ?? null;
        $property_age = $_POST['property_age'] ?? null;
        $floor_count  = $_POST['floor_count'] ?? null;

        if (!empty($_FILES["image"]["name"])) {
            $target_dir = "uploads/";
            if (!is_dir($target_dir)) mkdir($target_dir);
            $target_file = $target_dir . time() . "_" . basename($_FILES["image"]["name"]);
            move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
        }

        $gallery_paths = [];
        if (!empty($_FILES['gallery_images']['name'][0])) {
            $target_dir = "uploads/";
            if (!is_dir($target_dir)) mkdir($target_dir);
            foreach ($_FILES['gallery_images']['name'] as $key => $filename) {
                $gallery_file = $target_dir . time() . "_" . basename($filename);
                if (move_uploaded_file($_FILES['gallery_images']['tmp_name'][$key], $gallery_file)) {
                    $gallery_paths[] = $gallery_file;
                }
            }
        }
        $gallery_images = implode(",", $gallery_paths);

        $sql = "INSERT INTO furnish 
(title, house_number, price, availability, image_path, gallery_images, description, location, bedrooms, bathrooms, size, is_furnished, parking, amenities, security, agent_name, agent_phone, property_age, floor_count) 
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param(
            "ssssssssiissssssssi",
            $title,
            $house_number,
            $price,
            $availability,
            $target_file,
            $gallery_images,
            $description,
            $location,
            $bedrooms,
            $bathrooms,
            $size,
            $is_furnished,
            $parking,
            $amenities,
            $security,
            $agent_name,
            $agent_phone,
            $property_age,
            $floor_count
        );

        if ($stmt->execute()) {
            redirect_and_exit(" Property added successfully!", $conn);
        } else {
            echo " Error: " . $stmt->error;
        }
        $stmt->close();
    }

    // --- Edit Property ---
    if (isset($_POST['edit_property'])) {
        $id           = $_POST['property_id'] ?? null;
        $title        = $_POST['title'] ?? null;
        $house_number = $_POST['house_number'] ?? null;
        $price        = $_POST['price'] ?? null;
        $availability = $_POST['availability'] ?? null;
        $description  = $_POST['description'] ?? null;
        $location     = $_POST['location'] ?? null;
        $bedrooms     = $_POST['bedrooms'] ?? null;
        $bathrooms    = $_POST['bathrooms'] ?? null;
        $size         = $_POST['size'] ?? null;
        $is_furnished = $_POST['is_furnished'] ?? null;
        $parking      = $_POST['parking'] ?? null;
        $amenities    = $_POST['amenities'] ?? null;
        $security     = $_POST['security'] ?? null;
        $agent_name   = $_POST['agent_name'] ?? null;
        $agent_phone  = $_POST['agent_phone'] ?? null;
        $property_age = $_POST['property_age'] ?? null;
        $floor_count  = $_POST['floor_count'] ?? null;

        // initialize
        $image_sql = "";
        $gallery_sql = "";

        // handle image (optional)
        if (!empty($_FILES["image"]["name"])) {
            $target_dir = "uploads/";
            if (!is_dir($target_dir)) mkdir($target_dir);
            $target_file = $target_dir . time() . "_" . basename($_FILES["image"]["name"]);
            move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
            $image_sql = ", image_path=?";
        }

        // handle gallery (optional)
        if (!empty($_FILES['gallery_images']['name'][0])) {
            $gallery_paths = [];
            $target_dir = "uploads/";
            if (!is_dir($target_dir)) mkdir($target_dir);
            foreach ($_FILES['gallery_images']['name'] as $key => $filename) {
                $gallery_file = $target_dir . time() . "_" . basename($filename);
                if (move_uploaded_file($_FILES['gallery_images']['tmp_name'][$key], $gallery_file)) {
                    $gallery_paths[] = $gallery_file;
                }
            }
            $gallery_images = implode(",", $gallery_paths);
            $gallery_sql = ", gallery_images=?";
        }

        // build query dynamically
        $sql = "UPDATE furnish SET 
            title=?, house_number=?, price=?, availability=?, description=?, location=?, bedrooms=?, bathrooms=?, size=?, is_furnished=?, parking=?, amenities=?, security=?, agent_name=?, agent_phone=?, property_age=?, floor_count=? 
            $image_sql $gallery_sql 
            WHERE id=?";

        $stmt = $conn->prepare($sql);

        // build types and params
        $types = "ssssssiiisssssssi"; // 17 fixed columns
        $params = [
            $title, $house_number, $price, $availability,
            $description, $location, $bedrooms, $bathrooms,
            $size, $is_furnished, $parking, $amenities,
            $security, $agent_name, $agent_phone,
            $property_age, $floor_count
        ];

        if ($image_sql) {
            $types .= "s";
            $params[] = $target_file;
        }

        if ($gallery_sql) {
            $types .= "s";
            $params[] = $gallery_images;
        }

        $types .= "i";
        $params[] = $id;

        $stmt->bind_param($types, ...$params);

        if ($stmt->execute()) {
            redirect_and_exit("✅ Property updated successfully!", $conn);
        } else {
            echo " Error: " . $stmt->error;
        }
        $stmt->close();
    }
}

// --- Delete Property ---
if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];
    $sql = "DELETE FROM furnish WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        redirect_and_exit("✅ Property deleted successfully!", $conn);
    } else {
        echo " Error deleting: " . $stmt->error;
    }
    $stmt->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Furnished Properties</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px; }
        .container { max-width: 900px; margin: auto; }
        .form-container, .edit-form-container { background: white; padding: 30px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); margin-bottom: 40px; }
        h2, h1 { text-align: center; color: #333; }
        label { display: block; margin-bottom: 8px; font-weight: bold; color: #555; }
        input[type="text"], textarea, input[type="number"], input[type="file"], select { width: 100%; padding: 12px; margin-bottom: 20px; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box; }
        input[type="submit"] { background-color: #007bff; color: white; padding: 15px 20px; border: none; border-radius: 5px; cursor: pointer; width: 100%; font-size: 16px; transition: background-color 0.3s ease; }
        input[type="submit"]:hover { background-color: #0056b3; }
        .property-container { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px; padding: 20px; background-color: white; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        .property-card { border: 1px solid #ccc; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
        .property-card img { width: 100%; height: 200px; object-fit: cover; display: block; }
        .property-details { padding: 15px; }
        .property-details h3 { margin-top: 0; }
        .property-details p { margin: 5px 0; font-size: 14px; }
        .gallery img { width:70px; height:70px; object-fit:cover; border-radius:5px; margin:2px; }
        .actions { text-align: right; padding: 10px; }
        .actions a { margin-left: 10px; text-decoration: none; font-weight: bold; }
        .edit-link { color: #007bff; }
        .delete-link { color: #dc3545; }
    </style>
</head>
<body>

<div class="container">
    <?php
    if (isset($_GET['edit_id'])) {
        $edit_id = $_GET['edit_id'];
        $sql = "SELECT * FROM furnish WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $edit_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $property_to_edit = $result->fetch_assoc();
        $stmt->close();
    ?>
    <div class="edit-form-container">
    <h2>Edit Property</h2>
    <form action="" method="post" enctype="multipart/form-data">
        <input type="hidden" name="property_id" value="<?php echo htmlspecialchars($property_to_edit['id'] ?? ''); ?>">
        
        <label for="title">Property Title:</label>
        <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($property_to_edit['title'] ?? ''); ?>" required>

        <label for="house_number">House Number:</label>
        <input type="text" id="house_number" name="house_number" value="<?php echo htmlspecialchars($property_to_edit['house_number'] ?? ''); ?>" required>
        
        <label for="price">Price:</label>
        <input type="text" id="price" name="price" value="<?php echo htmlspecialchars($property_to_edit['price'] ?? ''); ?>" required>
        
        <label for="availability">Availability Status:</label>
        <input type="text" id="availability" name="availability" value="<?php echo htmlspecialchars($property_to_edit['availability'] ?? ''); ?>" required>
        
        <label for="description">Property Description:</label>
        <textarea id="description" name="description" rows="5"><?php echo htmlspecialchars($property_to_edit['description'] ?? ''); ?></textarea>
        
        <label for="location">Location:</label>
        <input type="text" id="location" name="location" value="<?php echo htmlspecialchars($property_to_edit['location'] ?? ''); ?>">
        
        <label for="bedrooms">Bedrooms:</label>
        <input type="number" id="bedrooms" name="bedrooms" min="1" value="<?php echo htmlspecialchars($property_to_edit['bedrooms'] ?? ''); ?>">
        
        <label for="bathrooms">Bathrooms:</label>
        <input type="number" id="bathrooms" name="bathrooms" min="1" value="<?php echo htmlspecialchars($property_to_edit['bathrooms'] ?? ''); ?>">
        
        <p>Current Image: <img src="<?php echo htmlspecialchars($property_to_edit['image_path'] ?? ''); ?>" alt="Current Image" style="max-width: 100px;"></p>
        <label for="image">Change Image (optional):</label>
        <input type="file" id="image" name="image">

        <label for="gallery_images">Gallery Images (optional):</label>
        <input type="file" id="gallery_images" name="gallery_images[]" multiple>
        
        <input type="submit" name="edit_property" value="Update Property">
    </form>
</div>
    <a href="add_and_view_furnishings.php">Back to Add Properties</a>
    <hr>
    <?php } else  ?>

<div class="form-container">
    <h2>Add New Furnished Property</h2>
    <form action="" method="post" enctype="multipart/form-data">
        <input type="hidden" name="add_property" value="1">

        <label for="title">Property Title:</label>
        <input type="text" id="title" name="title" required>

        <label for="house_number">House Number:</label>
        <input type="text" id="house_number" name="house_number" required>
        
        <label for="price">Price:</label>
        <input type="text" id="price" name="price" required>
        
        <label for="availability">Availability Status:</label>
        <input type="text" id="availability" name="availability" value="Available Now" required>

        <label for="size">Size (e.g., 2,500 sq ft):</label>
        <input type="text" id="size" name="size">

        <label for="is_furnished">Furnished:</label>
        <select id="is_furnished" name="is_furnished">
            <option value="Yes">Yes</option>
            <option value="No">No</option>
        </select>

        <label for="parking">Parking:</label>
        <input type="text" id="parking" name="parking">

        <label for="amenities">Amenities (separate with commas):</label>
        <textarea id="amenities" name="amenities" rows="3"></textarea>

        <label for="security">Security:</label>
        <input type="text" id="security" name="security">

        <label for="agent_name">Agent Name:</label>
        <input type="text" id="agent_name" name="agent_name">

        <label for="agent_phone">Agent Phone:</label>
        <input type="text" id="agent_phone" name="agent_phone">

        <label for="property_age">Property Age:</label>
        <input type="text" id="property_age" name="property_age">

        <label for="floor_count">Number of Floors:</label>
        <input type="number" id="floor_count" name="floor_count" min="1">

        <label for="description">Property Description:</label>
        <textarea id="description" name="description" rows="5"></textarea>

        <label for="location">Location:</label>
        <input type="text" id="location" name="location">

        <label for="bedrooms">Bedrooms:</label>
        <input type="number" id="bedrooms" name="bedrooms" min="1">

        <label for="bathrooms">Bathrooms:</label>
        <input type="number" id="bathrooms" name="bathrooms" min="1">

        <label for="image">Property Image:</label>
        <input type="file" id="image" name="image" required>

        <label for="gallery_images">Gallery Images:</label>
        <input type="file" id="gallery_images" name="gallery_images[]" multiple>

        <input type="submit" value="Add Property">
    </form>
</div>

    
    <h1>All Furnished Properties</h1>
    <div class="property-container">
        <?php
        $sql = "SELECT id, title, house_number, price, availability, image_path, gallery_images, description, location, bedrooms, bathrooms FROM furnish ORDER BY created_at DESC";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                ?>
                <div class="property-card">
                    <img src="<?php echo htmlspecialchars($row["image_path"]); ?>" alt="<?php echo htmlspecialchars($row["title"]); ?>">
                    <div class="property-details">
                        <h3><?php echo htmlspecialchars($row["title"]); ?></h3>
                        <p><strong>House #:</strong> <?php echo htmlspecialchars($row["house_number"]); ?></p>
                        <p><strong>Price:</strong> <?php echo htmlspecialchars($row["price"]); ?></p>
                        <p><strong>Availability:</strong> <?php echo htmlspecialchars($row["availability"]); ?></p>
                        <p><strong>Location:</strong> <?php echo htmlspecialchars($row["location"]); ?></p>
                        <p><strong>Bedrooms:</strong> <?php echo htmlspecialchars($row["bedrooms"]); ?></p>
                        <p><strong>Bathrooms:</strong> <?php echo htmlspecialchars($row["bathrooms"]); ?></p>
                        <p><?php echo nl2br(htmlspecialchars($row["description"])); ?></p>

                        <?php if (!empty($row["gallery_images"])): ?>
                            <div class="gallery">
                                <strong>Gallery:</strong><br>
                                <?php foreach (explode(",", $row["gallery_images"]) as $gimg): ?>
                                    <img src="<?php echo htmlspecialchars($gimg); ?>" alt="Gallery Image">
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="actions">
                        <a href="?edit_id=<?php echo $row['id']; ?>" class="edit-link">Edit</a> | 
                        <a href="?delete=<?php echo $row['id']; ?>" class="delete-link" onclick="return confirm('Are you sure you want to delete this property?');">Delete</a>
                    </div>
                </div>
                <?php
            }
        } else {
            echo "<p style='text-align: center;'>No properties found.</p>";
        }

        $conn->close();
        ?>
    </div>
</div>

</body>
</html>
