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
<?php include 'header.php' ?>

   


</head>


<body>

  <div class="gallery-container">
    <img src="images/f21.png" class="main-image" id="mainImage" alt="Main Property Image">
    <div class="thumbnail-gallery" id="thumbnailGallery">
    
      <img src="images/f22.png" onclick="changeMainImage(this.src)">
      <img src="images/f23.png" onclick="changeMainImage(this.src)">
      <img src="images/f224.png" onclick="changeMainImage(this.src)">
      <img src="images/f25.png" onclick="changeMainImage(this.src)">
      <img src="images/f26.png" onclick="changeMainImage(this.src)">
      <img src="images/f27.png" onclick="changeMainImage(this.src)">
      <img src="images/f28.png" onclick="changeMainImage(this.src)">
      <img src="images/f29.png" onclick="changeMainImage(this.src)">
      <img src="images/f210.png" onclick="changeMainImage(this.src)"> 
      <img src="images/f211.png" onclick="changeMainImage(this.src)">
      
    </div>
  </div>

  <div class="property-info">
    <h2><i class="fas fa-user"></i><span>Muhammad Akram</span></h2>
    <h2>House Of 5 Marla  House For Sale</h2>
    <h3> 75,000,000</h3>
    <div class="location">📍 Pakistan, Mandi Bahauddin - 50400</div>

    <div class="details-grid">
      <div><strong>Bedrooms:</strong> 3</div>
      <div><strong>Bathrooms:</strong> 3</div>
      <div><strong>Size:</strong> 2,100 sq ft</div>
      <div><strong>Price:</strong>75,000,000</div>
      <div><strong>Furnished:</strong> Yes</div>
      <div><strong>Parking:</strong> Available</div>
      <div><strong>Amenities:</strong> Swimming Pool, Balcony, Lawn</div>
      <div><strong>Security:</strong> 24/7 Guarded</div>
    </div>

    <div class="description">
      <h3>Description:</h3>
      <p>Experience luxurious living in this beautifully furnished 5 Marla house located in the heart of Mandi Bahauddin (50400), Pakistan.
         Spanning 2,100 sq. ft., this stunning home is thoughtfully designed with 3 spacious bedrooms and 3 modern bathrooms, 
         offering both comfort and style. The property comes fully furnished, making it move-in ready for families or investors seeking 
         convenience and elegance. Key features include a private swimming pool, a relaxing balcony, and a well-maintained lawn—perfect for 
         both leisure and entertainment. With dedicated parking and 24/7 guarded security, this home ensures a safe and peaceful lifestyle. 
         Priced at Rs. 75,000,000, this is a rare opportunity to own a premium residence in a prime location. Don't miss out—contact us today 
         for more details or to schedule a viewing.

</p>
    </div>
     <button id="savePropertyBtn" class="inline-btn">Save Property</button>
<script>
  const saveBtn = document.getElementById('savePropertyBtn');

  const property = {
    id: "115",
    title: "House Of 5 Marla  House For Sale",
    image: "images/f21.png",
    location: "Pakistan , Mandi bhauddin-50400",
    price: "75,000,000",
    agent: "Muhammad Akram",
    phone: "+92343434333",
    type: "Sale",
    status: "Furnished",
    carpet: " 21,00 sq ft",
    age: "1 year",
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
      <a href="agent1.php" class="inline-btn">Contact Agent</a>
         <a href="buyer.html" class="inline-btn">Buy Now</a>
  </div>

  <script>
    function changeMainImage(src) {
      document.getElementById('mainImage').src = src;
    }
  </script>
  </div>

 


<?php include 'footer.php' ?>
 

 <script src="js/script.js"></script>
 
</body>
 </html>
