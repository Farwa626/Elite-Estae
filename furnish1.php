<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Furnished Properties</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">

    <style>
        .furnish-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            padding: 20px;
        }
        .property-section {
            width: 150vh;
            height: 100vh;
            background-color: transparent;
            margin-bottom: 20px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        .property-image {
            width: 80%;
            height: 80%;
            object-fit: cover;
            border-radius: 10px;
        }
        .property-info {
            margin-top: 10px;
        }
        .property-info h2 {
            font-size: 24px;
            margin-bottom: 5px;
        }
        .property-info p, .property-info h3 {
            margin: 4px 0;
            color: #444;
        }
        .view-details-btn {
            display: inline-block;
            margin-top: 10px;
            padding: 10px 20px;
            background-color: #007BFF;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        .view-details-btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<?php include 'header.php' ?>

<section class="furnish">
    <div class="furnish-container">
        <div class="property-section">
            <img src="images/Screenshot 2025-05-21 143643.png" alt="Furnished House 1" class="property-image">
            <div class="property-info">
                <h2>Luxury Villa<span class="house-number">(House #135)</span></h2>
                <h3>Price: 450,00000</h3>
                <h3>Availability: Available Now</h3>
                <a href="fn1.php" class="view-details-btn">View Details</a>
            </div>
        </div>
        
        <div class="property-section">
            <img src="images/f21.png" alt="Furnished House 2" class="property-image">
            <div class="property-info">
                <h2>Modern Apartment<span class="house-number">(House #136)</span></h2>
                <h3>Price: 350,00000</h3>
                <h3>Availability: Available from June</h3>
                <a href="fn2.php" class="view-details-btn">View Details</a>
            </div>
        </div>
        
        <div class="property-section">
            <img src="images/Screenshot 2025-05-21 141726.png" alt="Furnished House 3" class="property-image">
            <div class="property-info">
                <h2>Cozy Cottage<span class="house-number">(House #137)</span></h2>
                <h3>Price: 250,00000</h3>
                <h3>Availability: Available Now</h3>
                <a href="fn3.php" class="view-details-btn">View Details</a>
            </div>
        </div>
        <?php
        // Database connection details
        $servername = "localhost";
        $username = "root"; // Your database username
        $password = ""; // Your database password
        $dbname = "elitestate"; // Your database name

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Fetch properties from the database
        $sql = "SELECT id, title, house_number, price, availability, image_path FROM furnish ORDER BY created_at DESC";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Loop through each row and display a property card
            while($row = $result->fetch_assoc()) {
        ?>
        <div class="property-section">
            <img src="<?php echo htmlspecialchars($row['image_path']); ?>" alt="<?php echo htmlspecialchars($row['title']); ?>" class="property-image">
            <div class="property-info">
                <h2><?php echo htmlspecialchars($row['title']); ?><span class="house-number">(House #<?php echo htmlspecialchars($row['house_number']); ?>)</span></h2>
                <h3>Price: <?php echo htmlspecialchars($row['price']); ?></h3>
                <h3>Availability: <?php echo htmlspecialchars($row['availability']); ?></h3>
                <a href="fn4.php?id=<?php echo urlencode($row['id']); ?>" class="view-details-btn">View Details</a>

            </div>
        </div>
        <?php
            }
        } else {
            echo "<p style='text-align: center; width: 100%;'>No dynamic properties found.</p>";
        }

        $conn->close();
        ?>
    </div>
</section>

<?php include 'footer.php' ?>

<script src="js/script.js"></script>

</body>
</html>
