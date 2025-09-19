<?php
session_start();

// Database connection details
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "elitestate"; 

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$property = null;

// Check if a property ID is provided in the URL
if (isset($_GET['id'])) {
    $property_id = $_GET['id'];
    
    // Fetch property details from the database
    $sql = "SELECT id, title, house_number, price, availability, image_path, description, location, bedrooms, bathrooms FROM furnish WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $property_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $property = $result->fetch_assoc();
    }
    $stmt->close();
}

$conn->close();

if (!$property) {
    // If no property is found, show an error message
    echo "<p style='text-align: center; color: red;'>Property not found.</p>";
    include 'footer.php';
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($property['title']); ?> - Property View</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="save.css">
    <style>
        body {
            background-color: #f5f5f5;
            color: #333;
        }

        .gallery-container {
            background-color: #2e2e2e;
            padding: 20px;
            border-radius: 10px;
            max-width: 1200px;
            margin: auto;
        }

        .main-image {
            width: 100%;
            max-height: 500px;
            object-fit: cover;
            border-radius: 10px;
        }

        .thumbnail-gallery {
            display: flex;
            overflow-x: auto;
            margin-top: 15px;
            gap: 10px;
            padding-bottom: 10px;
        }

        .thumbnail-gallery img {
            height: 100px;
            width: auto;
            border-radius: 5px;
            cursor: pointer;
            transition: transform 0.2s;
        }

        .thumbnail-gallery img:hover {
            transform: scale(1.05);
        }

        .property-info {
            margin-top: 30px;
            max-width: 1200px;
            margin-inline: auto;
        }

        .property-info h2 {
            font-size: 28px;
            margin-bottom: 10px;
        }
        .property-info h3 {
            font-size: 28px;
            margin-bottom: 10px;
        }

        .property-info .location {
            font-size: 16px;
            color: #777;
            margin-bottom: 20px;
        }

        .details-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 15px;
            margin-bottom: 30px;
        }

        .details-grid div {
            background-color: #fff;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .description {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            line-height: 1.6;
        }
    </style>
</head>
<body>

<?php include 'header.php' ?>

<div class="gallery-container">
    <img src="<?php echo htmlspecialchars($property['image_path']); ?>" class="main-image" id="mainImage" alt="<?php echo htmlspecialchars($property['title']); ?>">
    <div class="thumbnail-gallery" id="thumbnailGallery">
        <img src="<?php echo htmlspecialchars($property['image_path']); ?>" onclick="changeMainImage(this.src)">
    </div>
</div>

<div class="property-info">
    <h2><i class="fas fa-home"></i><span>Property Details</span></h2>
    <h2><?php echo htmlspecialchars($property['title']); ?> (House #<?php echo htmlspecialchars($property['house_number']); ?>)</h2>
    <h3><?php echo htmlspecialchars($property['price']); ?></h3>
    <div class="location">📍 <?php echo htmlspecialchars($property['location']); ?></div>

    <div class="details-grid">
        <div><strong>Bedrooms:</strong> <?php echo htmlspecialchars($property['bedrooms']); ?></div>
        <div><strong>Bathrooms:</strong> <?php echo htmlspecialchars($property['bathrooms']); ?></div>
        <div><strong>Availability:</strong> <?php echo htmlspecialchars($property['availability']); ?></div>
        <div><strong>Price:</strong> <?php echo htmlspecialchars($property['price']); ?></div>
    </div>

    <div class="description">
        <h3>Description:</h3>
        <p><?php echo nl2br(htmlspecialchars($property['description'])); ?></p>
    </div>

    <button id="savePropertyBtn" class="inline-btn">Save Property</button>
    <script>
        const saveBtn = document.getElementById('savePropertyBtn');
        const property = {
            id: "<?php echo htmlspecialchars($property['id']); ?>",
            title: "<?php echo htmlspecialchars($property['title']); ?>",
            image: "<?php echo htmlspecialchars($property['image_path']); ?>",
            location: "<?php echo htmlspecialchars($property['location']); ?>",
            price: "<?php echo htmlspecialchars($property['price']); ?>",
            // Add other details as needed for the saved property display
            house_number: "<?php echo htmlspecialchars($property['house_number']); ?>"
        };

        let saved = JSON.parse(localStorage.getItem('savedProperties')) || [];
        if (saved.some(p => p.id === property.id)) {
            saveBtn.textContent = "Saved";
            saveBtn.disabled = true;
        }

        saveBtn.addEventListener('click', () => {
            let saved = JSON.parse(localStorage.getItem('savedProperties')) || [];
            if (!saved.some(p => p.id === property.id)) {
                saved.push(property);
                localStorage.setItem('savedProperties', JSON.stringify(saved));
                saveBtn.textContent = "Saved";
                saveBtn.disabled = true;
                alert("Property saved!");
                window.location.href = "saved.php";
            } else {
                alert("This property is already saved.");
            }
        });

        // This is a placeholder since you only have one image per property in your DB
        // You would need to add a separate table for gallery images to make this dynamic
        function changeMainImage(src) {
            document.getElementById('mainImage').src = src;
        }
    </script>

    <?php if (isset($_SESSION['user_id'])): ?>
        <a href="agent1.php" class="inline-btn">Contact Agent</a>
        <a href="buyer.php" class="inline-btn">Buy Now</a>
    <?php else: ?>
        <a href="login.php" class="inline-btn">Contact Agent</a>
        <a href="login.php" class="inline-btn">Buy Now</a>
    <?php endif; ?>
</div>

<?php include 'footer.php' ?>

<script src="js/script.js"></script>
</body>
</html>