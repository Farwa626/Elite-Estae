<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>ELITE ESTATE</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="save.css">
  
   <link rel="stylesheet" href="css/view details.css">


  </head>
</head>
<body>
   
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
      border-left: 6px  rgb(139,97,132);
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
      transition: 0.3s;
    }
    .buttons button:hover, .buttons a:hover {
      background:  rgb(139,97,132);
    }

.old-price {
  text-decoration: line-through;
  color: #888;
  margin-right: 8px;
  font-size: 14px;
}

.new-price {
  color: #e63946;
  font-weight: bold;
  font-size: 16px;
  margin-right: 6px;
}

.discount-label {
  color: #2e7d32; /* green highlight */
  font-size: 13px;
  font-weight: 600;
}

  </style>


<?php include 'header.php' ?>
    <title><i>Rental House Details</i></title>
    <link rel="stylesheet" href="view details.html">
</head>
<body>
    <div class="container">
    <h1>Rental House Details</h1>

    <!-- Gallery -->
    <div class="gallery">
      <img id="mainImage" src="images/f2.png" alt="Main" class="main-image">
      <div class="thumbnails">
          <img src="images/h2.jpg" onclick="changeImage(this)">
        <img src="images/bed 2.png" onclick="changeImage(this)">
        <img src="images/kit2.png" onclick="changeImage(this)">
        <img src="images/bath2.png" onclick="changeImage(this)">
        <img src="images/bed3.png" onclick="changeImage(this)">
        <img src="images/living2.png" onclick="changeImage(this)">
        <img src="images/a4.jpg" onclick="changeImage(this)">
        <img src="images/bal2.png" onclick="changeImage(this)">
      </div>
    </div>

    <!-- Property Details -->
    <div class="details">
      <h2><i class="fas fa-user"></i> Agent: Shoqat Khan</h2>

      <div class="info-grid">
        <div class="info-item"><i class="fas fa-map-marker-alt"></i> Mandi Bahauddin, Pakistan</div>
        <div class="info-item"><i class="fas fa-tag"></i><span class="old-price">85,000 / month</span><span class="new-price">75,000 / month</span><span class="discount-label">(Discounted Price)</span></div>
        <div class="info-item"><i class="fas fa-bed"></i> 2 Bedrooms</div>
        <div class="info-item"><i class="fas fa-bath"></i> 2 Bathrooms</div>
        <div class="info-item"><i class="fas fa-ruler-combined"></i> 500 sq ft</div>
        <div class="info-item"><i class="fas fa-layer-group"></i> 2 Floors</div>
      </div>
    </div>

    <!-- Description -->
    <div class="description">
      <h2><i class="fas fa-info-circle"></i> Description</h2>
      <p>
        Discover your dream home perfectly located for family living!  
        This rental property features 2 spacious bedrooms, 2 modern bathrooms, a living and dining area, a newly renovated kitchen, and a green lawn.  
        The area offers a peaceful environment with easy access to schools, markets, and public transport.  
        Contact us today to schedule a viewing or get more details!
      </p>
    </div>

    <!-- Buttons -->
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
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <script>
    function changeImage(img) {
      document.getElementById("mainImage").src = img.src;
    }
  </script>
<script>
  const saveBtn = document.getElementById('savePropertyBtn');

  const property = {
    id: "118",
    title: "New luxery rental place",
    image: "images/f1.png",
    location: "Pakistan , Mandi bhauddin-50400",
    price: "75,000,",
    agent: "Shoqat khan",
    phone: "+92343434333",
    type: "Sale",
    status: "Rental",
    carpet: " 500 sq ft",
    floor: "2"
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
</script>
  

<?php include 'footer.php' ?>


<script src="js/script.js"></script>

</body>
</html>