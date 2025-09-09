<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Property View</title>

 
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   
   <link rel="stylesheet" href="css/style.css">
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
  <?php include 'header.php' ?>

   


</head>


<body>

  <div class="gallery-container">
    <img src="images/s2.png" class="main-image" id="mainImage" alt="Main Property Image">
    <div class="thumbnail-gallery" id="thumbnailGallery">
    
      <img src="images/s1.png" onclick="changeMainImage(this.src)">
      <img src="images/Screenshot 2025-05-21 143126.png" onclick="changeMainImage(this.src)">
      <img src="images/Screenshot 2025-05-21 143148.png" onclick="changeMainImage(this.src)">
      <img src="images/1441.png" onclick="changeMainImage(this.src)">
      <img src="images/1442.png" onclick="changeMainImage(this.src)">
      <img src="images/1443.png" onclick="changeMainImage(this.src)">
      <img src="images/1444.png" onclick="changeMainImage(this.src)">
      <img src="images/1445.png" onclick="changeMainImage(this.src)">
      <img src="images/1446.png" onclick="changeMainImage(this.src)"> 
      <img src="images/1439.png" onclick="changeMainImage(this.src)">
      <img src="images/1446.png" onclick="changeMainImage(this.src)">
      <img src="images/1447.png" onclick="changeMainImage(this.src)">
      <img src="images/1448.png" onclick="changeMainImage(this.src)">
      <img src="images/1449.png" onclick="changeMainImage(this.src)">
      <img src="images/1450.png" onclick="changeMainImage(this.src)">
    </div>
  </div>

  <div class="property-info">
    <h2><i class="fas fa-user"></i><span>Muhammad Anayat</span></h2>
    <h2>House Of 5 Marla  Housing Society For Sale</h2>
    <h3> 90,000,000</h3>
    <div class="location">📍 Pakistan, Mandi Bahauddin - 50400    </div>

    <div class="details-grid">
      <div><strong>Bedrooms:</strong> 4</div>
      <div><strong>Bathrooms:</strong> 3</div>
      <div><strong>Size:</strong> 2,50 sq ft</div>
      <div><strong>Price:</strong>90,000,000</div>
      <div><strong>Furnished:</strong> Yes</div>
      <div><strong>Parking:</strong> Available</div>
      <div><strong>Amenities:</strong> Swimming Pool, Balcony, Lawn</div>
      <div><strong>Security:</strong> 24/7 Guarded</div>
    </div>

    <div class="description">
      <h3>Description:</h3>
      <p>Book your dream home from our endless property options available for sale. For a luxurious lifestyle, you can check out properties in Pak Arab Housing Society. Here's the tactfully chosen House for you. No need to compromise on a peaceful lifestyle by living in this property situated in Pak Arab Housing Society. Get your ideal House on a special price of Rs. 23000000. This 5 Marla-sized property is a good choice for the investment as well. 

Details of the property are mentioned below. 
An adjoining drawing room also comes with the property to complete your home. 
Your kids can play to their heart's content in the play area adjoining the property. 
You can meet the neighbourhood community after prayers in the mosque near House. 
A beautifully designed airy dining room that comes with this House is perfect to host formal dinners. 
The security staff will be available round the clock to ensure that residents can lead a peaceful life. 
The sitting room that comes with this House is large enough to seat your family and few friends. 


To know more on the offer, please contact us.</p>
    </div>
     <button id="savePropertyBtn" class="inline-btn">Save Property</button>
<script>
  const saveBtn = document.getElementById('savePropertyBtn');

  const property = {
    id: "114",
    title: "House Of 5 Marla  Housing Society For Sale",
    image: "images/s2.png",
    location: "Pakistan , Mandi bhauddin-50400",
    price: "90,000,000",
    agent: "Muhammad Anayat",
    phone: "+92343434333",
    type: "Sale",
    status: "Furnished",
    carpet: " 2,50 sq ft",
    age: "1.5 year",
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
    
      window.location.href = "saved.html";
    } else {
      alert("This property is already saved.");
    }
  });
</script>
           <!-- ✅ Conditional Buttons -->
      <?php if (isset($_SESSION['user_id'])): ?>
         <a href="agent1.php" class="inline-btn">Contact Agent</a>
         <a href="buyer.php" class="inline-btn">Buy Now</a>
      <?php else: ?>
         <a href="login.php" class="inline-btn">Contact Agent</a>
         <a href="login.php" class="inline-btn">Buy Now</a>
      <?php endif; ?>
    </div>
  </div>

  <script>
    function changeMainImage(src) {
      document.getElementById('mainImage').src = src;
    }
  </script>



<?php include 'footer.php' ?>
 

 <script src="js/script.js"></script>
 
</body>
 </html>
