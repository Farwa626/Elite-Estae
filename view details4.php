<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>ELITE ESTATE - Rental House Details</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <link rel="stylesheet" href="css/style.css">
   <link rel="stylesheet" href="save.css">
   <link rel="stylesheet" href="css/view details.css">

   <style>
       body {
        background-color: rgb(230, 214, 245) 
    }
/* ====== PAGE CONTAINER ====== */
.container {
  max-width: 1000px;
  margin: 40px auto;
  background: #fff;
  border-radius: 12px;
  box-shadow: 0 4px 20px rgba(0,0,0,0.1);
  padding: 25px;
}
.container h1 {
  text-align: center;
  margin-bottom: 20px;
  color: rgb(139,97,132);
}

/* ====== GALLERY ====== */
.gallery { text-align: center; }
.main-image {
  width: 100%;
  max-height: 500px;
  object-fit: cover;
  border-radius: 12px;
  box-shadow: 0 4px 12px rgba(0,0,0,0.3);
  margin-bottom: 15px;
}
.thumbnails {
  display: flex;
  gap: 12px;
  justify-content: center;
  flex-wrap: wrap;
}
.thumbnails img {
  width: 120px;
  height: 90px;
  object-fit: cover;
  border-radius: 8px;
  cursor: pointer;
  transition: transform 0.3s, border 0.3s;
}
.thumbnails img:hover {
  transform: scale(1.05);
  border: 2px solid #6a0dad;
}

/* ====== DETAILS ====== */
.details {
  margin-top: 30px;
}
.details h2 {
  margin-bottom: 15px;
  color: rgb(139,97,132);
}
.info-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 20px;
}
.info-item {
  background: #f3e9fa;
  padding: 15px;
  border-radius: 10px;
  display: flex;
  align-items: center;
  gap: 12px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.1);
  color: #333;
  font-weight: 500;
}
.info-item i {
  font-size: 22px;
  color: rgb(139,97,132);
}

/* ====== DESCRIPTION ====== */
.description {
  margin-top: 30px;
  padding: 20px;
  background: #faf5ff;
  border-left: 6px solid rgb(139,97,132);
  border-radius: 8px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}
.description h2 {
  color: rgb(139,97,132);
  margin-bottom: 10px;
}
.description p {
  color: #444;
  line-height: 1.6;
  font-size: 16px;
}

/* ====== BUTTONS ====== */
.buttons {
  margin-top: 25px;
  display: flex;
  gap: 15px;
  justify-content: center;
  flex-wrap: wrap;
}
.buttons button, .buttons a {
  padding: 12px 20px;
  border-radius: 30px;
  border: none;
  background: rgb(139,97,132);
  color: #fff;
  font-size: 16px;
  cursor: pointer;
  text-decoration: none;
  transition: background 0.3s;
}
.buttons button:hover, .buttons a:hover {
  background: #6a0dad;
}
   </style>
</head>
<body>
   
<?php include'header.php' ?>


<div class="container">
   <h1>Rental House Details</h1>

   <div class="gallery">
      <img id="mainImage" src="images/f4.png" alt="Main" class="main-image">
      <div class="thumbnails">
         <img src="images/bath16.png" onclick="changeImage(this)">
         <img src="images/bed4.png" onclick="changeImage(this)">
         <img src="images/kit4.png" onclick="changeImage(this)">
         <img src="images/bath4.png" onclick="changeImage(this)">
         <img src="images/hall-img-6.webp" onclick="changeImage(this)">
         <img src="images/living6.png" onclick="changeImage(this)">
         <img src="images/bal5.png" onclick="changeImage(this)">
      </div>
   </div>

   <div class="details">
      <h2><i class="fas fa-user"></i> Agent: Faisal Yameen</h2>
      <div class="info-grid">
         <div class="info-item"><i class="fas fa-map-marker-alt"></i> Pakistan, Mandi Bahauddin</div>
         <div class="info-item"><i class="fas fa-tag"></i> 70,000 / month</div>
         <div class="info-item"><i class="fas fa-bed"></i> 5 Bedrooms</div>
         <div class="info-item"><i class="fas fa-bath"></i> 4 Bathrooms</div>
         <div class="info-item"><i class="fas fa-ruler-combined"></i> 650 sq ft</div>
         <div class="info-item"><i class="fas fa-layer-group"></i> 2 Floors</div>
      </div>
   </div>

   <div class="description">
      <h2><i class="fas fa-info-circle"></i> Description</h2>
      <p>
         Affordable Comfort: Your Perfect Starter Rental. It features 5 bedrooms, 4 bathrooms, a spacious living room, a modern kitchen, and a lovely lobby. The house is situated close to schools, parks, and shopping centers, making it an ideal location for large families.
      </p>
   </div>

     <div class="buttons">
      <button id="savePropertyBtn"class="inline-btn">SaveProperty</button>
           <!-- ✅ Conditional Buttons -->
      <?php if (isset($_SESSION['user_id'])): ?>
         <a href="agent1.php" class="inline-btn">Contact Agent</a>
         <a href="rentproperty.php" class="inline-btn">Book Now</a>
      <?php else: ?>
         <a href="login.php" class="inline-btn">Contact Agent</a>
         <a href="login.php" class="inline-btn">Book Now</a>
      <?php endif; ?>
    </div>
  </div>

<?php include'footer.php' ?>


<script src="js/script.js"></script>
<script>
   const changeImage = (element) => {
      document.getElementById('mainImage').src = element.src;
   };
</script>

</body>
</html>