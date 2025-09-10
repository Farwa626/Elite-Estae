<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>View Property</title>

   
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <link rel="stylesheet" href="css/style.css">

  <style>
   

    .property-section {
      width: 150vh;
      height: 100vh;
      background-color:transparent;
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

    .property-info p {
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

   


</head>
<body>
<section class="furnish">
  
  <div class="property-section">
    <img src="images/Screenshot 2025-05-21 143643.png" alt="Furnished House 1" class="property-image">
    <div class="property-info">
      <h2>Luxury 4-Bedroom Villa</h2>
      <p>Features: 4 Bedrooms, 3 Bathrooms, Swimming Pool, Garage</p>
      <h3>Price: 450,00000</h3>
      <p>Availability: Available Now</p>
      <a href="fn1.php" class="view-details-btn">View Details</a>
    </div>
  </div>

  
  <div class="property-section">
    <img src="images/f21.png" alt="Furnished House 2" class="property-image">
    <div class="property-info">
      <h2>Modern 3-Bedroom Apartment</h2>
      <p>Features: 3 Bedrooms, 2 Bathrooms, Balcony, Parking</p>
      <h3>Price: 350,00000</h3>
      <p>Availability: Available from June</p>
      <a href="fn2.php" class="view-details-btn">View Details</a>
    </div>
  </div>

  
  <div class="property-section">
    <img src="images/Screenshot 2025-05-21 141726.png" alt="Furnished House 3" class="property-image">
    <div class="property-info">
      <h2>Cozy 2-Bedroom Cottage</h2>
      <p>Features: 2 Bedrooms, 1 Bathroom, Garden, Furnished</p>
      <h3>Price: 250,00000</h3>
      <p>Availability: Available Now</p>
      <a href="fn3.php" class="view-details-btn">View Details</a>
    </div>
  </div>
</section>

    




<?php include 'footer.php' ?>
 
 
 <script src="js/script.js"></script>
 
</body>
 </html>