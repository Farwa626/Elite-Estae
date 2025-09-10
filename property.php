<?php
// Database Connection
$host     = "localhost";
$user     = "root";
$password = "";
$dbname   = "elitestate";

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Database Connection failed: " . $conn->connect_error);
}

// Agar form submit hua to insert karna
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Basic fields
    $ownerName   = $conn->real_escape_string($_POST['ownerName'] ?? '');
    $title       = $conn->real_escape_string($_POST['title'] ?? '');
    $price       = $conn->real_escape_string($_POST['price'] ?? '');
    $location    = $conn->real_escape_string($_POST['location'] ?? '');
    $rooms       = isset($_POST['rooms']) ? (int)$_POST['rooms'] : 0;
    $baths       = isset($_POST['baths']) ? (int)$_POST['baths'] : 0;
    $size        = $conn->real_escape_string($_POST['size'] ?? '');
    $deposit     = $conn->real_escape_string($_POST['deposit'] ?? '');
    $bedroom     = isset($_POST['bedroom']) ? (int)$_POST['bedroom'] : 0;
    $bathroom    = isset($_POST['bathroom']) ? (int)$_POST['bathroom'] : 0;
    $balcony     = isset($_POST['balcony']) ? (int)$_POST['balcony'] : 0;
    $carpet_area = $conn->real_escape_string($_POST['carpet_area'] ?? '');
    $age         = $conn->real_escape_string($_POST['age'] ?? '');
    $room_floor  = isset($_POST['room_floor']) ? (int)$_POST['room_floor'] : 0;
    $total_floors= isset($_POST['total_floors']) ? (int)$_POST['total_floors'] : 0;
    $furnished   = $conn->real_escape_string($_POST['furnished'] ?? '');
    $loan        = $conn->real_escape_string($_POST['loan'] ?? '');
    $amenities   = $conn->real_escape_string($_POST['amenities'] ?? '');
    $description = $conn->real_escape_string($_POST['description'] ?? '');

    // ✅ Main Image Upload
    $mainImage = "";
    if (isset($_FILES["main_image"]) && $_FILES["main_image"]["error"] == 0) {
        $targetDir = "uploads/";
        if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);

        $mainImage = time() . "_" . basename($_FILES["main_image"]["name"]);
        $targetFilePath = $targetDir . $mainImage;

        if (!move_uploaded_file($_FILES["main_image"]["tmp_name"], $targetFilePath)) {
            echo "Main image upload fail hua!";
            $mainImage = "";
        }
    }

    // ✅ Gallery Images Upload
    $galleryPaths = [];
    if (!empty($_FILES['gallery_images']['name'][0])) {
        $galleryDir = "uploads/gallery/";
        if (!is_dir($galleryDir)) mkdir($galleryDir, 0777, true);

        $totalFiles = count($_FILES['gallery_images']['name']);
        for ($i=0; $i < $totalFiles && $i < 8; $i++) {
            if ($_FILES['gallery_images']['error'][$i] == 0) {
                $fileName = time() . "_" . basename($_FILES['gallery_images']['name'][$i]);
                $filePath = $galleryDir . $fileName;
                if (move_uploaded_file($_FILES['gallery_images']['tmp_name'][$i], $filePath)) {
                    $galleryPaths[] = $fileName;
                }
            }
        }
    }

    // ✅ Gallery ko JSON ke form me save karenge
    $galleryJson = json_encode($galleryPaths);

    // Insert Query
    $sql = "INSERT INTO property 
        (ownerName, title, price, location, rooms, baths, size, main_image, gallery_images, deposit, bedroom, bathroom, balcony, carpet_area, age, room_floor, total_floors, furnished, loan, amenities, description) 
        VALUES 
        ('$ownerName', '$title', '$price', '$location', '$rooms', '$baths', '$size', '$mainImage', '$galleryJson', '$deposit', '$bedroom', '$bathroom', '$balcony', '$carpet_area', '$age', '$room_floor', '$total_floors', '$furnished', '$loan', '$amenities', '$description')";

    if ($conn->query($sql) === TRUE) {
        header("Location: property.php?success=1");
        exit();
    } else {
        echo "Error inserting data: " . $conn->error;
    }
}

// ✅ View ek property
if (isset($_GET['view'])) {
    $id = (int)$_GET['view'];
    $result = $conn->query("SELECT * FROM property WHERE id=$id");
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        ?>
        <h2><?php echo htmlspecialchars($row['title']); ?></h2>

        <!-- Main Image -->
        <?php if (!empty($row['main_image'])) { ?>
            <img src="uploads/<?php echo htmlspecialchars($row['main_image']); ?>" width="300"><br>
        <?php } ?>

        <!-- Gallery Images -->
        <?php 
        if (!empty($row['gallery_images'])) {
            $galleryArr = json_decode($row['gallery_images'], true);
            echo "<h4>Gallery:</h4>";
            foreach ($galleryArr as $img) {
                echo "<img src='uploads/gallery/" . htmlspecialchars($img) . "' width='120' style='margin:5px;'>";
            }
        }
        ?>

        <p><b>Owner:</b> <?php echo htmlspecialchars($row['ownerName']); ?></p>
        <p><b>Price:</b> <?php echo htmlspecialchars($row['price']); ?></p>
        <p><b>Location:</b> <?php echo htmlspecialchars($row['location']); ?></p>
        <p><b>Rooms:</b> <?php echo $row['rooms']; ?></p>
        <p><b>Baths:</b> <?php echo $row['baths']; ?></p>
        <p><b>Size:</b> <?php echo htmlspecialchars($row['size']); ?></p>
        <p><b>Deposit:</b> <?php echo htmlspecialchars($row['deposit']); ?></p>
        <p><b>Bedroom:</b> <?php echo $row['bedroom']; ?></p>
        <p><b>Bathroom:</b> <?php echo $row['bathroom']; ?></p>
        <p><b>Balcony:</b> <?php echo $row['balcony']; ?></p>
        <p><b>Carpet Area:</b> <?php echo htmlspecialchars($row['carpet_area']); ?></p>
        <p><b>Age:</b> <?php echo htmlspecialchars($row['age']); ?></p>
        <p><b>Floor:</b> <?php echo $row['room_floor']."/".$row['total_floors']; ?></p>
        <p><b>Furnished:</b> <?php echo htmlspecialchars($row['furnished']); ?></p>
        <p><b>Loan:</b> <?php echo htmlspecialchars($row['loan']); ?></p>
        <p><b>Amenities:</b> <?php echo htmlspecialchars($row['amenities']); ?></p>
        <p><b>Description:</b> <?php echo htmlspecialchars($row['description']); ?></p>
        <br><a href="property.php">🔙 Back to List</a>
        <?php
        exit();
    } else {
        echo "Property not found!";
        exit();
    }
}

// ✅ Property list
$result = $conn->query("SELECT * FROM property ORDER BY id DESC");

if (isset($_GET['success'])) {
    echo "<p style='color:green;'>Property added successfully!</p>";
}

echo "<h2>All Properties</h2>";
while ($row = $result->fetch_assoc()) {
    echo "<div style='border:1px solid #ccc; padding:10px; margin:10px;'>";
    echo "<h3>" . htmlspecialchars($row['title']) . "</h3>";
    echo "<p><b>Owner:</b> " . htmlspecialchars($row['ownerName']) . "</p>";
    echo "<p><b>Price:</b> " . htmlspecialchars($row['price']) . "</p>";
    echo "<p><b>Location:</b> " . htmlspecialchars($row['location']) . "</p>";

    // Main image show
    if (!empty($row['main_image'])) {
        echo "<img src='uploads/" . htmlspecialchars($row['main_image']) . "' width='200'><br><br>";
    }

    echo "<a href='property.php?view=" . $row['id'] . "'>
            <button>View Property</button>
          </a>";
    echo "</div>";
}
?>
